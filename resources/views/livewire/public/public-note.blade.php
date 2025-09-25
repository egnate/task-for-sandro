<div class="space-y-8">
    <!-- Hero Section -->
    <div class="text-center mb-12">
        @if($note->is_pinned)
            <div class="inline-flex items-center px-4 py-2 bg-amber-100 text-amber-800 rounded-full text-sm font-medium mb-4">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                </svg>
                Pinned Note
            </div>
        @endif

        <div class="flex items-center justify-center space-x-3 text-sm text-emerald-600 mb-6">
            <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></div>
            <span class="font-medium">Published {{ $note->created_at->format('M j, Y') }}</span>
            <span class="text-gray-400">•</span>
            <span class="text-gray-500">{{ $note->updated_at->diffForHumans() }}</span>
        </div>
    </div>

    <!-- Main Article -->
    <article class="bg-white/80 backdrop-blur-xl rounded-3xl overflow-hidden shadow-xl border border-gray-200/50">
        <!-- Header Image -->
        @if($note->image_path)
            <div class="relative overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200">
                <img src="{{ Storage::url($note->image_path) }}"
                     alt="{{ $note->title }}"
                     class="w-full h-80 sm:h-96 lg:h-[28rem] object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent"></div>
            </div>
        @endif

        <!-- Content -->
        <div class="p-8 sm:p-12 lg:p-16">
            <!-- Title -->
            <header class="mb-12">
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-900 mb-6 leading-tight">
                    {{ $note->title ?: 'Untitled Note' }}
                </h1>

                <!-- Metadata -->
                <div class="flex flex-wrap items-center gap-6 text-sm">
                    <div class="flex items-center px-3 py-1.5 bg-emerald-50 text-emerald-700 rounded-xl">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        Public Note
                    </div>


                    <div class="flex items-center text-gray-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Last updated {{ $note->updated_at->format('M j, Y \a\t g:i A') }}
                    </div>
                </div>
            </header>

            <!-- Content Body -->
            <div class="prose prose-lg prose-emerald max-w-none">
                @if($note->content)
                    <div class="text-gray-800 text-lg leading-relaxed whitespace-pre-wrap font-['Inter',system-ui,sans-serif]">
                        {{ $note->content }}
                    </div>
                @else
                    <div class="text-center py-16">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <p class="text-gray-500 text-lg italic">This note has no content yet.</p>
                    </div>
                @endif
            </div>

            <!-- Author Actions -->
            @auth
                @if($note->user_id === auth()->id())
                    <div class="mt-12 pt-8 border-t border-gray-200">
                        <div class="flex items-center justify-center">
                            <a href="{{ route('notes.edit', $note) }}"
                               class="inline-flex items-center px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-2xl transition-all duration-200 shadow-sm hover:shadow-md">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Edit This Note
                            </a>
                        </div>
                    </div>
                @endif
            @endauth
        </div>
    </article>

    <!-- Copy Link -->
    <div class="flex justify-center">
        <div class="inline-flex items-center bg-gray-50 rounded-lg border border-gray-200 overflow-hidden text-xs">
            <input type="text"
                   value="{{ url()->current() }}"
                   readonly
                   class="px-3 py-2 bg-transparent text-gray-500 focus:outline-none select-all text-xs w-48">
            <button onclick="copyToClipboard()"
                    class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 transition-all duration-300 relative overflow-hidden group">
                <span class="copy-text flex items-center">
                    <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                    Copy Link
                </span>
                <span class="copied-text hidden flex items-center">
                    <svg class="w-3 h-3 mr-1.5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Copied!
                </span>
            </button>
        </div>
    </div>

    <script>
        // Modern copy to clipboard with better feedback
        function copyToClipboard() {
            const input = document.querySelector('input[readonly]');
            const button = document.querySelector('button[onclick="copyToClipboard()"]');
            const copyText = button.querySelector('.copy-text');
            const copiedText = button.querySelector('.copied-text');

            if (navigator.clipboard && window.isSecureContext) {
                // Use modern Clipboard API
                navigator.clipboard.writeText(input.value).then(() => {
                    showCopySuccess(copyText, copiedText, button);
                }).catch(err => {
                    console.error('Failed to copy text: ', err);
                    fallbackCopyTextToClipboard(input, copyText, copiedText, button);
                });
            } else {
                // Fallback for older browsers
                fallbackCopyTextToClipboard(input, copyText, copiedText, button);
            }
        }

        function fallbackCopyTextToClipboard(input, copyText, copiedText, button) {
            input.select();
            input.setSelectionRange(0, 99999);

            try {
                document.execCommand('copy');
                showCopySuccess(copyText, copiedText, button);
            } catch (err) {
                console.error('Failed to copy text: ', err);
            }
        }

        function showCopySuccess(copyText, copiedText, button) {
            // Add success animation
            button.classList.add('scale-95');
            setTimeout(() => button.classList.remove('scale-95'), 150);

            copyText.classList.add('hidden');
            copiedText.classList.remove('hidden');

            // Enhanced styling for success state
            button.classList.add('bg-emerald-500', 'hover:bg-emerald-600', 'text-white', 'shadow-md');
            button.classList.remove('bg-gray-100', 'hover:bg-gray-200', 'text-gray-600');

            setTimeout(() => {
                copyText.classList.remove('hidden');
                copiedText.classList.add('hidden');
                button.classList.remove('bg-emerald-500', 'hover:bg-emerald-600', 'text-white', 'shadow-md');
                button.classList.add('bg-gray-100', 'hover:bg-gray-200', 'text-gray-600');
            }, 2000);
        }

        // Web Share API support
        function shareViaWebAPI() {
            if (navigator.share) {
                navigator.share({
                    title: '{{ $note->title ?: "Untitled Note" }}',
                    text: 'Check out this note: {{ $note->title ?: "Untitled Note" }}',
                    url: '{{ url()->current() }}'
                }).catch(err => {
                    console.log('Error sharing:', err);
                });
            } else {
                // Fallback to copy URL
                copyToClipboard();
            }
        }

        // Hide native share button if Web Share API is not supported
        document.addEventListener('DOMContentLoaded', function() {
            if (!navigator.share) {
                const shareButton = document.querySelector('.share-native');
                if (shareButton) {
                    shareButton.style.display = 'none';
                }
            }
        });
    </script>
</div>