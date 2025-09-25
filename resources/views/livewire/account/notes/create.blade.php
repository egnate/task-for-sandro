<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-2xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">New Note</h1>
                    <p class="text-gray-500 text-sm">Capture your thoughts and ideas</p>
                </div>
            </div>
            <x-buttons.secondary href="{{ route('notes.index') }}" size="small">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back
            </x-buttons.secondary>
        </div>
    </div>

    <!-- Note Form -->
    <form wire:submit="save" class="space-y-8">
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
            <!-- Title Section -->
            <div class="p-8 border-b border-gray-50">
                <input type="text"
                       id="title"
                       wire:model="title"
                       placeholder="Untitled note"
                       class="w-full text-3xl font-bold text-gray-900 bg-transparent border-0 focus:ring-0 focus:outline-none placeholder:text-gray-300 @error('title') text-red-600 @enderror">
                @error('title')
                    <p class="mt-2 text-sm text-red-500 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Content Section -->
            <div class="p-8">
                <textarea id="content"
                          wire:model="content"
                          rows="16"
                          placeholder="Start writing your note..."
                          class="w-full text-lg text-gray-700 bg-transparent border-0 focus:ring-0 focus:outline-none placeholder:text-gray-400 leading-relaxed resize-none @error('content') text-red-600 @enderror"></textarea>
                @error('content')
                    <p class="mt-2 text-sm text-red-500 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>

        <!-- Toolbar -->
        <div class="flex items-center justify-between bg-white rounded-2xl border border-gray-100 shadow-sm p-4">
            <div class="flex items-center space-x-6">
                <!-- Image Upload -->
                @if($image)
                    <div class="flex items-center space-x-3">
                        <div class="relative">
                            <img src="{{ $image->temporaryUrl() }}" alt="Preview" class="w-16 h-16 object-cover rounded-xl">
                            <button type="button" wire:click="$set('image', null)"
                                    class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center hover:bg-red-600 transition-colors">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                        <span class="text-sm text-gray-500">Image attached</span>
                    </div>
                @else
                    <label for="image-upload" class="cursor-pointer">
                        <div class="flex items-center space-x-2 px-4 py-2 bg-gray-50 hover:bg-gray-100 rounded-xl transition-colors {{ $uploading ? 'opacity-50' : '' }}">
                            @if($uploading)
                                <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            @else
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            @endif
                            <span class="text-sm text-gray-600">{{ $uploading ? 'Uploading...' : 'Add image' }}</span>
                        </div>
                    </label>
                    <input type="file" id="image-upload" wire:model="image" accept="image/*" class="hidden" {{ $uploading ? 'disabled' : '' }}>
                @endif

                <!-- Options -->
                <div class="flex items-center space-x-4">
                    <!-- Pin Toggle -->
                    <button type="button" wire:click="$toggle('is_pinned')"
                            class="flex items-center space-x-2 px-3 py-2 rounded-xl transition-all {{ $is_pinned ? 'bg-purple-50 text-purple-700' : 'text-gray-500 hover:text-purple-600 hover:bg-purple-50' }}">
                        <svg class="w-4 h-4" fill="{{ $is_pinned ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                        </svg>
                        <span class="text-sm font-medium">{{ $is_pinned ? 'Pinned' : 'Pin' }}</span>
                    </button>

                    <!-- Publish Toggle -->
                    <button type="button" wire:click="$toggle('is_published')"
                            class="flex items-center space-x-2 px-3 py-2 rounded-xl transition-all {{ $is_published ? 'bg-emerald-50 text-emerald-700' : 'text-gray-500 hover:text-emerald-600 hover:bg-emerald-50' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        <span class="text-sm font-medium">{{ $is_published ? 'Public' : 'Private' }}</span>
                    </button>
                </div>

                @error('image')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Actions -->
            <div class="flex items-center space-x-3">
                <x-buttons.secondary href="{{ route('notes.index') }}" size="small">
                    Cancel
                </x-buttons.secondary>

                <x-buttons.primary type="submit" :loading="$uploading" size="small">
                    @if(!$uploading)
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    @endif
                    {{ $uploading ? 'Saving...' : 'Save Note' }}
                </x-buttons.primary>
            </div>
        </div>
        </div>
    </form>
</div>