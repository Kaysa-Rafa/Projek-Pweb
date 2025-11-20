<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-900 dark:text-white leading-tight">
                    Upload Resource
                </h2>
                <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">
                    Share your custom Warcraft 3 resources with the community
                </p>
            </div>
            <a href="{{ route('resources.index') }}" class="btn-outline">
                Back to Resources
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="card p-6">
                <form action="{{ route('resources.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Resource Title *
                        </label>
                        <input type="text" 
                               name="title" 
                               id="title" 
                               value="{{ old('title') }}"
                               required
                               class="input-primary"
                               placeholder="Enter a descriptive title for your resource">
                        @error('title')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Description *
                        </label>
                        <textarea name="description" 
                                  id="description" 
                                  rows="4" 
                                  required
                                  class="input-primary"
                                  placeholder="Describe your resource in detail...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Installation Instructions -->
                    <div>
                        <label for="installation_instructions" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Installation Instructions
                        </label>
                        <textarea name="installation_instructions" 
                                  id="installation_instructions" 
                                  rows="3"
                                  class="input-primary"
                                  placeholder="How to install and use this resource...">{{ old('installation_instructions') }}</textarea>
                        @error('installation_instructions')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Category *
                        </label>
                        <select name="category_id" id="category_id" required class="input-primary">
                            <option value="">Select a category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- File Upload -->
                    <div>
                        <label for="resource_file" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Resource File *
                        </label>
                        <input type="file" 
                               name="resource_file" 
                               id="resource_file" 
                               required
                               class="input-primary"
                               accept=".w3x,.w3m,.zip,.rar,.mdx,.mdl,.blp,.tga,.dds,.png,.jpg,.jpeg,.exe,.7z">
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            Supported formats: .w3x, .w3m, .zip, .rar, .mdx, .mdl, .blp, .tga, .dds, .png, .jpg, .jpeg, .exe, .7z
                        </p>
                        @error('resource_file')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Version -->
                    <div>
                        <label for="version" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Version
                        </label>
                        <input type="text" 
                               name="version" 
                               id="version" 
                               value="{{ old('version', '1.0') }}"
                               class="input-primary"
                               placeholder="1.0">
                        @error('version')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tags -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Tags
                        </label>
                        <div class="flex flex-wrap gap-2 mb-2">
                            @php
                                $commonTags = ['melee', 'rpg', 'td', 'arena', 'hero', 'custom', 'multiplayer', 'texture', 'model', 'icon', 'tool'];
                            @endphp
                            @foreach($commonTags as $tag)
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="tags[]" value="{{ $tag }}" class="rounded border-gray-300 text-hive-600 focus:ring-hive-500">
                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ $tag }}</span>
                                </label>
                            @endforeach
                        </div>
                        <input type="text" 
                               name="custom_tags"
                               class="input-primary"
                               placeholder="Add custom tags (comma separated)">
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            Select common tags or add your own
                        </p>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-600">
                        <a href="{{ route('resources.index') }}" class="btn-secondary">
                            Cancel
                        </a>
                        <button type="submit" class="btn-primary">
                            Upload Resource
                        </button>
                    </div>
                </form>
            </div>

            <!-- Upload Guidelines -->
            <div class="card p-6 mt-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Upload Guidelines</h3>
                <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Ensure your resource is original or you have permission to share it
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Provide clear installation instructions when necessary
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Test your resource before uploading
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Use descriptive titles and detailed descriptions
                    </li>
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>