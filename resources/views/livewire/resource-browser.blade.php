<div>
    <!-- Search and Filters -->
    <div class="mb-6 bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <div class="flex flex-col md:flex-row gap-4">
            <!-- Search Input -->
            <div class="flex-1">
                <input 
                    type="text" 
                    wire:model.live="search"
                    placeholder="Search resources..." 
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
                >
            </div>
            
            <!-- Category Filter -->
            <select 
                wire:model.live="category"
                class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
            >
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            
            <!-- Sort By -->
            <select 
                wire:model.live="sortBy"
                class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
            >
                <option value="latest">Latest</option>
                <option value="popular">Most Popular</option>
                <option value="rating">Highest Rated</option>
            </select>
            
            <!-- Clear Filters -->
            <button 
                wire:click="clearFilters"
                class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors"
            >
                Clear
            </button>
        </div>
    </div>

    <!-- Resources Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($resources as $resource)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow hover:shadow-lg transition-shadow">
                <!-- Thumbnail -->
                <div class="aspect-w-16 aspect-h-9 bg-gray-200 dark:bg-gray-700 rounded-t-lg overflow-hidden">
                    @if($resource->thumbnail_path)
                        <img 
                            src="{{ Storage::url($resource->thumbnail_path) }}" 
                            alt="{{ $resource->title }}"
                            class="w-full h-48 object-cover"
                        >
                    @else
                        <div class="w-full h-48 flex items-center justify-center text-gray-400">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    @endif
                </div>
                
                <!-- Content -->
                <div class="p-4">
                    <h3 class="font-semibold text-lg mb-2 line-clamp-2 dark:text-white">
                        <a href="{{ route('resources.show', $resource) }}" class="hover:text-blue-500 transition-colors">
                            {{ $resource->title }}
                        </a>
                    </h3>
                    
                    <p class="text-gray-600 dark:text-gray-300 text-sm mb-3 line-clamp-2">
                        {{ Str::limit($resource->description, 100) }}
                    </p>
                    
                    <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400">
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                            </svg>
                            {{ $resource->download_count }}
                        </span>
                        
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            {{ number_format($resource->rating, 1) }}
                        </span>
                        
                        <span>{{ $resource->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $resources->links() }}
    </div>

    <!-- Empty State -->
    @if($resources->isEmpty())
        <div class="text-center py-12">
            <svg class="w-24 h-24 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">No resources found</h3>
            <p class="mt-2 text-gray-500 dark:text-gray-400">
                @if($search || $category)
                    Try adjusting your search filters
                @else
                    Be the first to upload a resource!
                @endif
            </p>
        </div>
    @endif
</div>