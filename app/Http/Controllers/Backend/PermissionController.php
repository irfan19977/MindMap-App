<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('permissions.index');
        $permissions = Permission::orderBy('created_at', 'desc')->get();
        
        return view('backend.permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('permissions.create');
        return view('backend.permissions.addedit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
        ]);

        Permission::create($validated);

        return redirect()->route('permissions.index')
            ->with('success', 'Permission berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        $this->authorize('permissions.edit');
        return view('backend.permissions.addedit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name,' . $permission->id,
        ]);

        $permission->update($validated);

        return redirect()->route('permissions.index')
            ->with('success', 'Permission berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        $this->authorize('permissions.delete');
        try {
            // Check if permission has roles
            if ($permission->roles()->count() > 0) {
                return redirect()->route('permissions.index')
                    ->with('error', 'Tidak dapat menghapus permission yang memiliki role. Hapus permission dari role terlebih dahulu.');
            }

            $permission->delete();

            return redirect()->route('permissions.index')
                ->with('success', 'Permission berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('permissions.index')
                ->with('error', 'Gagal menghapus permission: ' . $e->getMessage());
        }
    }
}
