<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Pembelajaran') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Section -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">
                    Selamat Datang, {{ $user->name }}! 👋
                </h1>
                <p class="mt-2 text-gray-600">
                    Lanjutkan perjalanan pembelajaran Anda hari ini
                </p>
            </div>

            <!-- Quick Actions -->
            @if($continueLearning && $continueLearning->material)
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl p-6 mb-8 text-white shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold mb-2">📚 Lanjutkan Belajar</h3>
                        <p class="text-indigo-100 mb-4">
                            Anda sedang mempelajari: {{ $continueLearning->material->title ?? 'Materi' }}
                        </p>
                        <div class="flex items-center gap-4">
                            <a href="{{ $continueLearning->material->slug ? route('materi.show', $continueLearning->material->slug) : '#' }}" 
                               class="bg-white text-indigo-600 px-6 py-2 rounded-lg font-semibold hover:bg-indigo-50 transition">
                                Lanjutkan
                            </a>
                            <div class="text-sm">
                                Progress: {{ round($continueLearning->progress_percentage ?? 0) }}%
                            </div>
                        </div>
                    </div>
                    <div class="hidden md:block">
                        <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                            <span class="text-3xl">📖</span>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Mind Maps Created -->
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Mind Map Dibuat</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalMindmaps }}</p>
                        </div>
                        <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                            <span class="text-2xl">🧠</span>
                        </div>
                    </div>
                    <div class="mt-4">
                        @if($mindmapStats && count($mindmapStats) > 0)
                        @foreach($mindmapStats as $category => $count)
                            @if($loop->first)
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-500">{{ $category }}</span>
                                <span class="font-semibold">{{ $count }}</span>
                            </div>
                            @endif
                        @endforeach
                        @else
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500">Belum ada mind map</span>
                            <span class="font-semibold">0</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- In Progress -->
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Sedang Dipelajari</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $inProgressMaterials }}</p>
                        </div>
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <span class="text-2xl">📚</span>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500">Total Progress</span>
                            <span class="font-semibold text-indigo-600">{{ $overallProgress }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                            <div class="bg-indigo-600 h-2 rounded-full" style="width: {{ $overallProgress }}%"></div>
                        </div>
                    </div>
                </div>

                <!-- Completed -->
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Materi Selesai</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $completedMaterials }}</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <span class="text-2xl">✅</span>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500">Quiz Lulus</span>
                            <span class="font-semibold text-green-600">{{ $passedQuizzes }}/{{ $totalQuizAttempts }}</span>
                        </div>
                    </div>
                </div>

                <!-- Learning Streak -->
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Streak Belajar</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $learningStreak }} hari</p>
                        </div>
                        <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                            <span class="text-2xl">🔥</span>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500">Total Waktu</span>
                            <span class="font-semibold">{{ $totalStudyHours }} jam</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column - 2/3 width -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Recommended Materials -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                        <div class="p-6 border-b border-gray-100">
                            <h3 class="text-lg font-semibold text-gray-900">🎯 Rekomendasi Materi</h3>
                            <p class="text-sm text-gray-500 mt-1">Materi yang mungkin Anda sukai</p>
                        </div>
                        <div class="p-6">
                            @if($recommendedMaterials && $recommendedMaterials->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($recommendedMaterials as $material)
                                @if($material->slug)
                                <a href="{{ route('materi.show', $material->slug) }}" 
                                   class="block p-4 rounded-lg border border-gray-200 hover:border-indigo-300 hover:bg-indigo-50 transition">
                                    <div class="flex items-start gap-3">
                                        <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <span class="text-lg">📖</span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h4 class="font-semibold text-gray-900 truncate">{{ $material->title ?? 'Materi' }}</h4>
                                            <p class="text-sm text-gray-500 mt-1">
                                                {{ $material->subcategory?->category?->name ?? 'General' }}
                                            </p>
                                        </div>
                                    </div>
                                </a>
                                @endif
                                @endforeach
                            </div>
                            @else
                            <div class="text-center py-8 text-gray-500">
                                <span class="text-4xl mb-2 block">🎉</span>
                                <p>Anda telah menyelesaikan semua materi yang tersedia!</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                        <div class="p-6 border-b border-gray-100">
                            <h3 class="text-lg font-semibold text-gray-900">📊 Aktivitas Terbaru</h3>
                            <p class="text-sm text-gray-500 mt-1">Riwayat pembelajaran Anda</p>
                        </div>
                        <div class="p-6">
                            @if($recentActivity && $recentActivity->count() > 0)
                            <div class="space-y-4">
                                @foreach($recentActivity as $activity)
                                @if($activity->material)
                                <div class="flex items-center gap-4 p-3 rounded-lg hover:bg-gray-50 transition">
                                    <div class="w-10 h-10 {{ $activity->completed_at ? 'bg-green-100' : 'bg-yellow-100' }} rounded-lg flex items-center justify-center flex-shrink-0">
                                        <span class="text-lg">{{ $activity->completed_at ? '✅' : '📖' }}</span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-medium text-gray-900 truncate">{{ $activity->material->title ?? 'Materi' }}</h4>
                                        <p class="text-sm text-gray-500">
                                            {{ $activity->completed_at ? 'Selesai' : 'Progress: ' . round($activity->progress_percentage ?? 0) . '%' }}
                                            • {{ $activity->updated_at?->diffForHumans() ?? 'Baru saja' }}
                                        </p>
                                    </div>
                                    @if(!$activity->completed_at && $activity->material->slug)
                                    <a href="{{ route('materi.show', $activity->material->slug) }}" 
                                       class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">
                                        Lanjutkan
                                    </a>
                                    @endif
                                </div>
                                @endif
                                @endforeach
                            </div>
                            @else
                            <div class="text-center py-8 text-gray-500">
                                <span class="text-4xl mb-2 block">📭</span>
                                <p>Belum ada aktivitas pembelajaran</p>
                                <a href="{{ route('kelas.index') }}" class="text-indigo-600 hover:text-indigo-700 font-medium mt-2 inline-block">
                                    Mulai belajar sekarang
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Quiz Performance -->
                    @if($quizPerformance && count($quizPerformance) > 0)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                        <div class="p-6 border-b border-gray-100">
                            <h3 class="text-lg font-semibold text-gray-900">📈 Performa Quiz</h3>
                            <p class="text-sm text-gray-500 mt-1">7 percobaan terakhir</p>
                        </div>
                        <div class="p-6">
                            <div class="flex items-end justify-between h-40 gap-2">
                                @foreach($quizPerformance as $perf)
                                <div class="flex-1 flex flex-col items-center">
                                    <div class="w-full bg-gray-200 rounded-t-lg relative" 
                                         style="height: {{ $perf['score'] ?? 0 }}%">
                                        <div class="absolute inset-0 {{ ($perf['status'] ?? '') == 'passed' ? 'bg-green-500' : 'bg-red-500' }} rounded-t-lg opacity-80"></div>
                                    </div>
                                    <span class="text-xs text-gray-500 mt-2">{{ $perf['date'] ?? '-' }}</span>
                                    <span class="text-xs font-semibold">{{ $perf['score'] ?? 0 }}%</span>
                                </div>
                                @endforeach
                            </div>
                            <div class="mt-4 flex items-center justify-center gap-6 text-sm">
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 bg-green-500 rounded"></div>
                                    <span class="text-gray-600">Lulus</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 bg-red-500 rounded"></div>
                                    <span class="text-gray-600">Perlu Coba Lagi</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Right Column - 1/3 width -->
                <div class="space-y-8">
                    <!-- Achievements -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                        <div class="p-6 border-b border-gray-100">
                            <h3 class="text-lg font-semibold text-gray-900">🏆 Pencapaian</h3>
                            <p class="text-sm text-gray-500 mt-1">{{ count($achievements) }} unlocked</p>
                        </div>
                        <div class="p-6">
                            @if(count($achievements) > 0)
                            <div class="space-y-3">
                                @foreach($achievements as $achievement)
                                <div class="flex items-center gap-3 p-3 bg-gradient-to-r from-yellow-50 to-orange-50 rounded-lg">
                                    <span class="text-2xl">{{ $achievement['icon'] }}</span>
                                    <div>
                                        <h4 class="font-semibold text-gray-900 text-sm">{{ $achievement['title'] }}</h4>
                                        <p class="text-xs text-gray-600">{{ $achievement['description'] }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="text-center py-6 text-gray-500">
                                <span class="text-3xl mb-2 block">🎯</span>
                                <p class="text-sm">Selesaikan materi pertama Anda untuk membuka pencapaian!</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                        <div class="p-6 border-b border-gray-100">
                            <h3 class="text-lg font-semibold text-gray-900">⚡ Aksi Cepat</h3>
                        </div>
                        <div class="p-6 space-y-3">
                            <a href="{{ route('kelas.index') }}" 
                               class="flex items-center gap-3 p-3 rounded-lg hover:bg-indigo-50 transition text-gray-700 hover:text-indigo-700">
                                <span class="text-xl">📚</span>
                                <span class="font-medium">Jelajahi Kelas</span>
                            </a>
                            <a href="{{ route('mindmap.index') }}" 
                               class="flex items-center gap-3 p-3 rounded-lg hover:bg-indigo-50 transition text-gray-700 hover:text-indigo-700">
                                <span class="text-xl">🧠</span>
                                <span class="font-medium">Buat Mind Map</span>
                            </a>
                            <a href="{{ route('student.profile') }}" 
                               class="flex items-center gap-3 p-3 rounded-lg hover:bg-indigo-50 transition text-gray-700 hover:text-indigo-700">
                                <span class="text-xl">👤</span>
                                <span class="font-medium">Profil Saya</span>
                            </a>
                            <a href="{{ route('learning-results.index') }}" 
                               class="flex items-center gap-3 p-3 rounded-lg hover:bg-indigo-50 transition text-gray-700 hover:text-indigo-700">
                                <span class="text-xl">📊</span>
                                <span class="font-medium">Hasil Pembelajaran</span>
                            </a>
                        </div>
                    </div>

                    <!-- Daily Goal -->
                    <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl p-6 text-white shadow-lg">
                        <h3 class="text-lg font-semibold mb-2">🎯 Target Harian</h3>
                        <p class="text-indigo-100 text-sm mb-4">Selesaikan 1 materi atau 1 quiz hari ini</p>
                        <div class="flex items-center gap-2">
                            @if($inProgressMaterials > 0 || $totalQuizAttempts > 0)
                            <span class="text-2xl">✨</span>
                            <span class="font-medium">Anda sudah aktif hari ini!</span>
                            @else
                            <span class="text-2xl">💪</span>
                            <span class="font-medium">Mulai belajar sekarang!</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
