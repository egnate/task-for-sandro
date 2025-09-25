<div>
    <div class="mb-8">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">My Notes</h1>
                <p class="text-gray-600 mt-2">Manage your personal notes and ideas</p>
            </div>
            <x-buttons.primary href="{{ route('notes.create') }}" size="small" wire:navigate>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                New Note
            </x-buttons.primary>
        </div>

        <!-- Modern Search & Filters -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row gap-4">
                <!-- Modern Search Input with Live Feedback -->
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        @if(empty($search))
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        @else
                            <div wire:loading wire:target="search">
                                <svg class="animate-spin w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>
                            <div wire:loading.remove wire:target="search">
                                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <input type="text"
                           wire:model.live.debounce.300ms="search"
                           placeholder="Search your notes..."
                           class="w-full pl-12 pr-10 py-3.5 bg-white border border-gray-200 rounded-2xl shadow-sm hover:border-gray-300 focus:bg-white focus:ring-4 focus:ring-emerald-100 focus:border-emerald-400 transition-all duration-200 placeholder:text-gray-400">

                    @if(!empty($search))
                        <button wire:click="$set('search', '')"
                                class="absolute inset-y-0 right-0 pr-4 flex items-center">
                            <svg class="w-5 h-5 text-gray-400 hover:text-gray-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    @endif
                </div>

                <!-- Filter Pills -->
                <div class="flex items-center gap-3">
                    <!-- Published Filter Pills -->
                    <div class="flex bg-gray-100 rounded-xl p-1">
                        <button wire:click="$set('filterPublished', 'all')"
                                class="px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ $filterPublished === 'all' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}">
                            All
                        </button>
                        <button wire:click="$set('filterPublished', 'published')"
                                class="px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ $filterPublished === 'published' ? 'bg-white text-emerald-700 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            Published
                        </button>
                    </div>

                    <!-- Pinned Filter Toggle -->
                    <button wire:click="$set('filterPinned', {{ $filterPinned === 'pinned' ? "'all'" : "'pinned'" }})"
                            class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ $filterPinned === 'pinned' ? 'bg-purple-50 text-purple-700 border border-purple-200' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        <svg class="w-4 h-4 mr-2" fill="{{ $filterPinned === 'pinned' ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                        </svg>
                        Pinned
                    </button>

                </div>
            </div>
        </div>

        <!-- Flash Messages -->
        @if(session()->has('success'))
            <div class="mb-4 p-4 rounded-xl border-l-4 border-green-500 bg-green-50 border border-green-200">
                <div class="flex">
                    <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="text-green-800 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif
    </div>

    <!-- Search Results Indicator -->
    @if(!empty($search))
        <div class="mb-4 flex items-center justify-between">
            <p class="text-sm text-gray-600">
                Found <span class="font-semibold text-gray-900">{{ $notes->total() }}</span>
                {{ Str::plural('note', $notes->total()) }} matching
                "<span class="font-medium text-emerald-600">{{ $search }}</span>"
            </p>
            <button wire:click="$set('search', '')"
                    class="text-sm text-gray-500 hover:text-gray-700 underline">
                Clear search
            </button>
        </div>
    @endif

    <!-- Notes Grid -->
    @if($notes->count() > 0)
        <!-- Modern Notes Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            @foreach($notes as $note)
                <div class="group relative bg-white rounded-3xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-xl hover:border-gray-200 hover:-translate-y-1 transition-all duration-500 cursor-pointer {{ $note->is_pinned ? 'ring-2 ring-amber-100 bg-gradient-to-br from-amber-50/30 to-white' : '' }}"
                     onclick="Livewire.navigate('{{ route('notes.edit', $note) }}')">

                    <!-- Pinned Badge -->
                    @if($note->is_pinned)
                        <div class="absolute top-4 right-4 z-10">
                            <div class="flex items-center px-2.5 py-1 bg-amber-500 text-white rounded-full text-xs font-medium shadow-lg">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                                </svg>
                                Pinned
                            </div>
                        </div>
                    @endif

                    <!-- Image -->
                    @if($note->image_path)
                        <div class="aspect-video overflow-hidden bg-gradient-to-br from-gray-50 to-gray-100">
                            <img src="{{ Storage::url($note->image_path) }}"
                                 alt="{{ $note->title }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </div>
                    @endif

                    <div class="p-6">
                        <!-- Status Pills -->
                        <div class="flex items-center gap-2 mb-4">
                            @if($note->is_published)
                                <div class="inline-flex items-center px-2.5 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-medium">
                                    <div class="w-2 h-2 bg-emerald-500 rounded-full mr-2 animate-pulse"></div>
                                    Live
                                </div>
                            @endif
                        </div>

                        <!-- Title -->
                        @if($note->title)
                            <h3 class="text-xl font-bold text-gray-900 mb-3 leading-tight group-hover:text-emerald-700 transition-colors duration-300 line-clamp-2">
                                {{ $note->title }}
                            </h3>
                        @else
                            <h3 class="text-xl font-bold text-gray-400 mb-3 leading-tight italic">
                                Untitled Note
                            </h3>
                        @endif

                        <!-- Content Preview -->
                        @if($note->content)
                            <div class="text-gray-600 text-sm leading-relaxed mb-4">
                                <p class="line-clamp-4">
                                    {{ Str::limit(strip_tags($note->content), 150) }}
                                </p>
                            </div>
                        @endif

                        <!-- Footer -->
                        <div class="flex items-center justify-between mt-6 pt-4 border-t border-gray-100">
                            <div class="flex items-center text-xs text-gray-500">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $note->created_at->format('M j, Y') }}
                            </div>

                            <!-- Quick Actions -->
                            <div class="opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-x-2 group-hover:translate-x-0" onclick="event.stopPropagation()">
                                <div class="flex items-center gap-1">
                                    <!-- Pin Toggle -->
                                    <button wire:click="togglePin({{ $note->id }})"
                                            class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-amber-600 hover:bg-amber-50 rounded-full transition-all duration-200 hover:scale-110"
                                            title="{{ $note->is_pinned ? 'Unpin' : 'Pin' }}">
                                        <svg class="w-4 h-4" fill="{{ $note->is_pinned ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                                        </svg>
                                    </button>

                                    <!-- Publish Toggle -->
                                    <button wire:click="togglePublish({{ $note->id }})"
                                            class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-full transition-all duration-200 hover:scale-110"
                                            title="{{ $note->is_published ? 'Unpublish' : 'Publish' }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $note->is_published ? 'M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21' : 'M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z' }}"/>
                                        </svg>
                                    </button>

                                    @if($note->is_published)
                                        <!-- View Public -->
                                        <a href="{{ route('public.note', $note->slug) }}" target="_blank"
                                           class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-full transition-all duration-200 hover:scale-110"
                                           title="View Public">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                            </svg>
                                        </a>
                                    @endif

                                    <!-- Delete -->
                                    <button wire:click="deleteNote({{ $note->id }})"
                                            wire:confirm="Are you sure you want to delete this note?"
                                            class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-full transition-all duration-200 hover:scale-110"
                                            title="Delete">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Hover Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/5 to-blue-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none rounded-3xl"></div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $notes->links() }}
        </div>
    @else
        <!-- Modern Empty State -->
        <div class="flex flex-col items-center justify-center py-16">
            @if(!empty($search))
                <!-- No Search Results -->
                <div class="w-20 h-20 bg-gradient-to-br from-gray-50 to-gray-100 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No notes found</h3>
                <p class="text-gray-500 mb-8 text-center max-w-sm">
                    We couldn't find any notes matching "<span class="font-medium text-gray-700">{{ $search }}</span>"
                </p>
                <div class="flex items-center space-x-3">
                    <x-buttons.secondary wire:click="$set('search', '')" size="small">
                        Clear search
                    </x-buttons.secondary>
                    <x-buttons.primary href="{{ route('notes.create') }}" size="small" wire:navigate>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Create Note
                    </x-buttons.primary>
                </div>
            @elseif($filterPublished !== 'all' || $filterPinned !== 'all')
                <!-- No Filter Results -->
                <div class="w-20 h-20 bg-gradient-to-br from-amber-50 to-amber-100 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-10 h-10 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No notes match filters</h3>
                <p class="text-gray-500 mb-8">
                    Try adjusting your filters to see more notes
                </p>
                <x-buttons.secondary wire:click="$set('filterPublished', 'all'); $set('filterPinned', 'all')" size="small">
                    Reset filters
                </x-buttons.secondary>
            @else
                <!-- First Note -->
                <div class="w-20 h-20 bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-10 h-10 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Create your first note</h3>
                <p class="text-gray-500 mb-8 text-center max-w-sm">
                    Start capturing your thoughts, ideas, and inspirations in beautiful notes
                </p>
                <x-buttons.primary href="{{ route('notes.create') }}" wire:navigate>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Create Your First Note
                </x-buttons.primary>
            @endif
        </div>
    @endif
</div>