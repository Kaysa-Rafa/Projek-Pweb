<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-start">
            <div>
                <h2 class="font-semibold text-xl text-gray-900 dark:text-white leading-tight">
                    {{ $resource->title }}
                </h2>
                <div class="flex items-center space-x-4 mt-2 text-sm text-gray-600 dark:text-gray-400">
                    <span class="badge-primary">{{ $resource->category->name }}</span>
                    <span>By {{ $resource->user->username }}</span>
                    <span>{{ $resource->created_at->diffForHumans() }}</span>
                    @if(!$resource->is_approved)
                        <span class="badge-warning">Pending Approval</span>
                    @endif
                    @if($resource->is_featured)
                        <span class="badge-warning">Featured</span>
                    @endif
                </div>
            </div>
            <div class="flex space-x-2">
                @auth
                    @if(auth()->id() === $resource->user_id || auth()->user()->isModerator())
                        <a href="{{ route('resources.edit', $resource) }}" class="btn-secondary">
                            Edit
                        </a>
                    @endif
                @endauth
                <a href="{{ route('resources.index') }}" class="btn-outline">
                    Back to Resources
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Resource Details -->
                    <div class="card p-6">
                        <div class="prose dark:prose-invert max-w-none">
                            <h3 class="text-lg font-semibold mb-4">Description</h3>
                            <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $resource->description }}</p>
                            
                            @if($resource->installation_instructions)
                                <h3 class="text-lg font-semibold mt-6 mb-4">Installation Instructions</h3>
                                <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $resource->installation_instructions }}</p>
                            @endif
                        </div>
                    </div>

                    <!-- Screenshots/Images -->
                    @if($resource->thumbnail_path)
                        <div class="card p-6">
                            <h3 class="text-lg font-semibold mb-4">Preview</h3>
                            <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-4">
                                <img src="{{ Storage::url($resource->thumbnail_path) }}" 
                                     alt="{{ $resource->title }}"
                                     class="max-w-full h-auto rounded">
                            </div>
                        </div>
                    @endif

                    <!-- Comments Section -->
                    <div class="card p-6">
                        <h3 class="text-lg font-semibold mb-4">Comments</h3>
                        <livewire:comment-section :resource="$resource" />
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Download Card -->
                    <div class="card p-6">
                        <div class="text-center">
                            @if($resource->canBeDownloadedBy(auth()->user()))
                                <a href="{{ route('resources.download', $resource) }}" 
                                   class="btn-primary w-full mb-4"
                                   onclick="return confirm('Are you sure you want to download this resource?')">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4-4m0 0L8 8m4-4v12"/>
                                    </svg>
                                    Download Resource
                                </a>
                            @else
                                <button disabled class="btn-secondary w-full mb-4 opacity-50 cursor-not-allowed">
                                    Download Unavailable
                                </button>
                            @endif
                            
                            <div class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                                <div class="flex justify-between">
                                    <span>File Size:</span>
                                    <span class="font-medium">{{ number_format($resource->file_size / 1024, 2) }} KB</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Version:</span>
                                    <span class="font-medium">{{ $resource->version }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Downloads:</span>
                                    <span class="font-medium">{{ $resource->download_count }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Views:</span>
                                    <span class="font-medium">{{ $resource->view_count }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Rating:</span>
                                    <span class="font-medium flex items-center">
                                        <svg class="w-4 h-4 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                        {{ number_format($resource->rating, 1) }} ({{ $resource->rating_count }})
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Author Info -->
                    <div class="card p-6">
                        <h3 class="text-lg font-semibold mb-4">Uploaded By</h3>
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-hive-100 dark:bg-hive-900 rounded-full flex items-center justify-center">
                                <span class="font-semibold text-hive-600 dark:text-hive-400">
                                    {{ substr($resource->user->username, 0, 2) }}
                                </span>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900 dark:text-white">{{ $resource->user->username }}</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $resource->user->resources()->count() }} resources
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Tags -->
                    @if($resource->tags->count())
                        <div class="card p-6">
                            <h3 class="text-lg font-semibold mb-4">Tags</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($resource->tags as $tag)
                                    <span class="badge-primary">{{ $tag->name }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>