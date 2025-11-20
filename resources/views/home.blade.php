<x-app-layout>
    <x-slot name="header">
        <div class="text-center py-8">
            <h1 class="text-4xl md:text-6xl font-bold text-gray-900 dark:text-white mb-6">
                Welcome to <span class="text-gradient">Hive Workshop</span>
            </h1>
            <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto mb-8">
                The largest community for Warcraft 3 custom maps, models, textures, and development resources.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('resources.index') }}" class="btn-primary text-lg px-8 py-3">
                    Browse Resources
                </a>
                <a href="{{ route('resources.upload') }}" class="btn-outline text-lg px-8 py-3">
                    Upload Your Work
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <!-- Stats Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-16">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="card text-center p-6">
                    <div class="text-3xl font-bold text-hive-600 dark:text-hive-400 mb-2">
                        {{ \App\Models\Resource::count() }}
                    </div>
                    <div class="text-gray-600 dark:text-gray-400 font-medium">Total Resources</div>
                </div>
                <div class="card text-center p-6">
                    <div class="text-3xl font-bold text-green-600 dark:text-green-400 mb-2">
                        {{ \App\Models\Resource::sum('download_count') }}
                    </div>
                    <div class="text-gray-600 dark:text-gray-400 font-medium">Total Downloads</div>
                </div>
                <div class="card text-center p-6">
                    <div class="text-3xl font-bold text-purple-600 dark:text-purple-400 mb-2">
                        {{ \App\Models\User::count() }}
                    </div>
                    <div class="text-gray-600 dark:text-gray-400 font-medium">Community Members</div>
                </div>
                <div class="card text-center p-6">
                    <div class="text-3xl font-bold text-orange-600 dark:text-orange-400 mb-2">
                        {{ \App\Models\Category::count() }}
                    </div>
                    <div class="text-gray-600 dark:text-gray-400 font-medium">Categories</div>
                </div>
            </div>
        </div>

        <!-- Featured Resources -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-16">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Featured Resources</h2>
                <a href="{{ route('resources.index') }}" class="btn-outline">
                    View All Resources
                </a>
            </div>

            <div class="resource-grid">
                @foreach(\App\Models\Resource::featured()->approved()->limit(8)->get() as $resource)
                    <div class="card-hover">
                        <div class="h-48 bg-gray-200 dark:bg-gray-700 flex items-center justify-center overflow-hidden">
                            @if($resource->thumbnail_path)
                                <img src="{{ Storage::url($resource->thumbnail_path) }}" 
                                     alt="{{ $resource->title }}"
                                     class="h-full w-full object-cover">
                            @else
                                <div class="text-gray-400">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                            @if($resource->is_featured)
                                <div class="absolute top-2 right-2">
                                    <span class="badge-warning">Featured</span>
                                </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-lg mb-2 line-clamp-2">
                                <a href="{{ route('resources.show', $resource) }}" 
                                   class="text-gray-900 dark:text-white hover:text-hive-600 dark:hover:text-hive-400 transition-colors">
                                    {{ $resource->title }}
                                </a>
                            </h3>
                            <p class="text-gray-600 dark:text-gray-300 text-sm mb-3 line-clamp-2">
                                {{ $resource->description }}
                            </p>
                            <div class="flex justify-between items-center text-sm text-gray-500 dark:text-gray-400">
                                <span class="badge-primary">{{ $resource->category->name }}</span>
                                <div class="flex items-center space-x-2">
                                    <span>{{ $resource->download_count }} downloads</span>
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                        {{ number_format($resource->rating, 1) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Categories Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white text-center mb-8">Browse Categories</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach(\App\Models\Category::rootCategories()->withCount('resources')->get() as $category)
                    <a href="{{ route('resources.index', ['category' => $category->id]) }}"
                       class="card text-center p-6 group hover:shadow-xl transition-all duration-300">
                        <div class="w-16 h-16 bg-hive-100 dark:bg-hive-900 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-hive-200 dark:group-hover:bg-hive-800 transition-colors">
                            <svg class="w-8 h-8 text-hive-600 dark:text-hive-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-2">{{ $category->name }}</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $category->resources_count }} resources</p>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>