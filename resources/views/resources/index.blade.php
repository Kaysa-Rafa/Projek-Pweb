<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-900 dark:text-white leading-tight">
                    Resources
                </h2>
                <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">
                    Browse and download custom Warcraft 3 resources
                </p>
            </div>
            <a href="{{ route('resources.upload') }}" class="btn-primary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Upload Resource
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Search and Filters -->
            <div class="card p-6 mb-6">
                <form action="{{ route('resources.index') }}" method="GET" class="space-y-4 md:space-y-0 md:flex md:space-x-4">
                    <!-- Search Input -->
                    <div class="flex-1">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Search resources..." 
                               class="input-primary">
                    </div>
                    
                    <!-- Category Filter -->
                    <div class="w-full md:w-48">
                        <select name="category" class="input-primary">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Sort By -->
                    <div class="w-full md:w-48">
                        <select name="sort" class="input-primary">
                            <option value="latest" {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>Latest</option>
                            <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                            <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Highest Rated</option>
                        </select>
                    </div>
                    
                    <!-- Buttons -->
                    <div class="flex space-x-2">
                        <button type="submit" class="btn-primary whitespace-nowrap">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            Search
                        </button>
                        <a href="{{ route('resources.index') }}" class="btn-secondary">
                            Clear
                        </a>
                    </div>
                </form>
            </div>

            <!-- Resources Grid -->
            @if($resources->count())
                <div class="resource-grid mb-6">
                    @foreach($resources as $resource)
                        <div class="card-hover">
                            <div class="h-48 bg-gray-200 dark:bg-gray-700 flex items-center justify-center overflow-hidden relative">
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
                                
                                @if(!$resource->is_approved)
                                    <div class="absolute top-2 left-2">
                                        <span class="badge-warning">Pending</span>
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
                                
                                <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400 mb-3">
                                    <span class="badge-primary">{{ $resource->category->name }}</span>
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                        {{ number_format($resource->rating, 1) }}
                                    </span>
                                </div>
                                
                                <div class="flex justify-between items-center text-xs text-gray-500 dark:text-gray-400">
                                    <span>By {{ $resource->user->username }}</span>
                                    <div class="flex items-center space-x-2">
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                            </svg>
                                            {{ $resource->download_count }}
                                        </span>
                                        <span>{{ $resource->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="card p-4">
                    {{ $resources->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="card text-center py-12">
                    <svg class="w-24 h-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No resources found</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-6">
                        @if(request()->anyFilled(['search', 'category']))
                            Try adjusting your search filters
                        @else
                            Be the first to upload a resource!
                        @endif
                    </p>
                    <a href="{{ route('resources.upload') }}" class="btn-primary">
                        Upload Resource
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>