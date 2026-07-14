<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CourseClass extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'classes';

    protected $fillable = [
        'category_id',
        'subcategory_id',
        'teacher_id',
        'name',
        'slug',
        'description',
        'cover_image',
        'status',
        'capacity',
        'is_featured',
        'created_by',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($courseClass) {
            if (empty($courseClass->slug)) {
                $courseClass->slug = Str::slug($courseClass->name);
            }
        });

        static::updating(function ($courseClass) {
            if ($courseClass->isDirty('name') && empty($courseClass->slug)) {
                $courseClass->slug = Str::slug($courseClass->name);
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function materials()
    {
        return $this->belongsToMany(Material::class, 'class_material', 'class_id', 'material_id')
            ->withPivot('order_number')
            ->orderByPivot('order_number');
    }

    public function collaborations()
    {
        return $this->hasMany(TeacherCollaboration::class, 'class_id');
    }

    public function acceptedCollaborations()
    {
        return $this->hasMany(TeacherCollaboration::class, 'class_id')->where('status', 'accepted');
    }

    public function enrollments()
    {
        return $this->hasMany(ClassEnrollment::class, 'class_id');
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'class_enrollments', 'class_id', 'student_id')
            ->withPivot('status', 'progress_percentage', 'enrolled_at', 'completed_at', 'approved_at', 'notes')
            ->wherePivot('status', '!=', 'dropped');
    }

    public function pendingEnrollments()
    {
        return $this->enrollments()->where('status', 'pending');
    }

    public function activeEnrollments()
    {
        return $this->enrollments()->where('status', 'active');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'publish');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function getProgressForStudent($studentId)
    {
        $materialIds = $this->materials()->pluck('materials.id');

        if ($materialIds->isEmpty()) {
            return 0;
        }

        $student = Student::find($studentId);
        if (! $student) {
            return 0;
        }

        $total = $materialIds->count();
        
        // Get materials completed through UserProgress
        $progressCompleted = UserProgress::where('user_id', $student->user_id)
            ->whereIn('material_id', $materialIds)
            ->whereNotNull('completed_at')
            ->pluck('material_id')
            ->toArray();

        // Get materials completed through passed quizzes
        $quizCompleted = \App\Models\QuizAttempt::where('user_id', $student->user_id)
            ->where('status', 'passed')
            ->with('quiz:id,material_id')
            ->get()
            ->pluck('quiz.material_id')
            ->filter()
            ->unique()
            ->values()
            ->toArray();

        // Merge both completion methods and ensure uniqueness
        $allCompletedMaterialIds = array_unique(array_merge($progressCompleted, $quizCompleted));
        
        // Count only materials that are actually in this class
        $completed = count(array_intersect($allCompletedMaterialIds, $materialIds->toArray()));

        return round(($completed / $total) * 100, 2);
    }

    public function getFormattedStatusAttribute(): string
    {
        return match ($this->status) {
            'publish' => 'Diterbitkan',
            'draft' => 'Draft',
            'inactive' => 'Tidak Aktif',
            default => 'Tidak Diketahui',
        };
    }

    public function getCoverImageUrlAttribute(): string
    {
        return $this->cover_image
            ? asset('storage/' . $this->cover_image)
            : asset('backend/assets/images/default-cover.jpg');
    }
}
