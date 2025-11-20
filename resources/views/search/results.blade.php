<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-900 dark:text-white leading-tight">
                    Search Results
                </h2>
                <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">
                    @if(request('q'))
                        Searching for "{{ request('q') }}"
                    @else
                        Browse all resources
                    @endif
                </p>
            </div>
            <a href="{{ route('resources.index') }}" class="btn-outline">
                Back to Resources
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Search Info -->
            @if(request()->anyFilled(['q', 'category']))
                <div class="card p-4 mb-6">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Filters:</span>
                        
                        @if(request('q'))
                            <span class="badge-primary">
                                Search: "{{ request('q') }}"
                                <a href="{{ request()->fullUrlWithQuery(['q' => null]) }}" class="ml-1 text-xs">×</a>
                            </span>
                        @endif
                        
                        @if(request('category'))
                            @php $category = \App\Models\Category::find(request('category')); @endphp
                            @if($category)
                                <span class="badge-primary">
                                    Category: {{ $category->name }}
                                    <a href="{{ request()->fullUrlWithQuery(['category' => null]) }}" class="ml-1 text-xs">×</a>
                                </span>
                            @endif
                        @endif
                        
                        @if(request('sort') && request('sort') !== 'latest')
                            <span class="badge-primary">
                                Sort: {{ ucfirst(request('sort')) }}
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'latest']) }}" class="ml-1 text-xs">×</a>
                            </span>
                        @endif
                        
                        <a href="{{ route('search') }}" class="text-sm text-hive-600 dark:text-hive-400 hover:underline ml-auto">
                            Clear all filters
                        </a>
                    </div>
                </div>
            @endif

            <!-- Results -->
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
                        @if(request()->anyFilled(['q', 'category']))
                            Try adjusting your search terms or filters
                        @else
                            There are no resources available yet
                        @endif
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('resources.index') }}" class="btn-primary">
                            Browse All Resources
                        </a>
                        <a href="{{ route('resources.upload') }}" class="btn-outline">
                            Upload Resource
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>