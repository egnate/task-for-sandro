<div>
    <div class="mb-8">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">API Tokens</h1>
                <p class="text-gray-600 mt-2">Manage your API tokens for accessing your notes programmatically</p>
            </div>
        </div>

        <!-- Flash Messages -->
        @if(session()->has('success'))
            <div class="mb-6 p-4 rounded-xl border-l-4 border-green-500 bg-green-50 border border-green-200">
                <div class="flex">
                    <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="text-green-800 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- New Token Display -->
        @if($created_token)
            <div class="mb-6 p-6 rounded-xl border-2 border-emerald-200 bg-emerald-50">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center mb-3">
                            <svg class="w-5 h-5 text-emerald-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h3 class="text-lg font-semibold text-emerald-900">Token Created Successfully!</h3>
                        </div>
                        <p class="text-emerald-800 mb-4">
                            <strong>Important:</strong> This token will only be displayed once. Copy it now and store it securely.
                        </p>

                        <div class="bg-white rounded-lg border border-emerald-200 p-4 mb-4">
                            <label class="block text-sm font-medium text-emerald-700 mb-2">Token Name</label>
                            <p class="font-mono text-sm text-gray-900 mb-3">{{ $created_token['name'] }}</p>

                            <label class="block text-sm font-medium text-emerald-700 mb-2">API Token</label>
                            <div class="flex items-center space-x-2">
                                <input
                                    type="text"
                                    value="{{ $created_token['token'] }}"
                                    readonly
                                    class="flex-1 px-3 py-2 border border-emerald-300 rounded-lg font-mono text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                                    id="new-token-{{ $created_token['name'] }}"
                                >
                                <button
                                    onclick="copyToClipboard('new-token-{{ $created_token['name'] }}')"
                                    class="px-3 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors text-sm"
                                >
                                    Copy
                                </button>
                            </div>
                        </div>
                    </div>
                    <button
                        wire:click="dismissCreatedToken"
                        class="ml-4 text-emerald-600 hover:text-emerald-700"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        <!-- Create New Token Form -->
        <div class="bg-white rounded-2xl border border-gray-200 p-6 mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Create New Token</h3>

            <form wire:submit="createToken" class="flex items-end space-x-4">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Token Name</label>
                    <input
                        type="text"
                        wire:model="new_token_name"
                        placeholder="Enter api token name (e.g: sandro, egnate, main-api etc)"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-colors @error('new_token_name') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror"
                    >
                    @error('new_token_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <x-buttons.primary type="submit" size="small">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Create Token
                </x-buttons.primary>
            </form>
        </div>

        <!-- Existing Tokens -->
        <div class="bg-white rounded-2xl border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Your API Tokens</h3>
                <p class="text-gray-600 text-sm mt-1">These tokens allow access to your account via the API</p>
            </div>

            @if($this->tokens->count() > 0)
                <div class="divide-y divide-gray-200">
                    @foreach($this->tokens as $token)
                        <div class="p-6 flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 24 24" fill-rule="evenodd" clip-rule="evenodd">
                                        <path d="M16 1c-4.418 0-8 3.582-8 8 0 .585.063 1.155.182 1.704l-8.182 7.296v5h6v-2h2v-2h2l3.066-2.556c.909.359 1.898.556 2.934.556 4.418 0 8-3.582 8-8s-3.582-8-8-8zm-6.362 17l3.244-2.703c.417.164 1.513.703 3.118.703 3.859 0 7-3.14 7-7s-3.141-7-7-7c-3.86 0-7 3.14-7 7 0 .853.139 1.398.283 2.062l-8.283 7.386v3.552h4v-2h2v-2h2.638zm.168-4l-.667-.745-7.139 6.402v1.343l7.806-7zm10.194-7c0-1.104-.896-2-2-2s-2 .896-2 2 .896 2 2 2 2-.896 2-2zm-1 0c0-.552-.448-1-1-1s-1 .448-1 1 .448 1 1 1 1-.448 1-1z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900">{{ $token->name }}</h4>
                                    <div class="flex items-center space-x-4 text-sm text-gray-500">
                                        <span>Created {{ $token->created_at->diffForHumans() }}</span>
                                        <span>•</span>
                                        <span>Last used {{ $token->last_used_at ? $token->last_used_at->diffForHumans() : 'Never' }}</span>
                                    </div>
                                </div>
                            </div>

                            <button
                                wire:click="deleteToken({{ $token->id }})"
                                wire:confirm="Are you sure you want to delete this token? Applications using this token will no longer be able to access your account."
                                class="px-3 py-2 text-sm text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition-colors"
                            >
                                Delete
                            </button>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-12 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 24 24" fill-rule="evenodd" clip-rule="evenodd">
                            <path d="M16 1c-4.418 0-8 3.582-8 8 0 .585.063 1.155.182 1.704l-8.182 7.296v5h6v-2h2v-2h2l3.066-2.556c.909.359 1.898.556 2.934.556 4.418 0 8-3.582 8-8s-3.582-8-8-8zm-6.362 17l3.244-2.703c.417.164 1.513.703 3.118.703 3.859 0 7-3.14 7-7s-3.141-7-7-7c-3.86 0-7 3.14-7 7 0 .853.139 1.398.283 2.062l-8.283 7.386v3.552h4v-2h2v-2h2.638zm.168-4l-.667-.745-7.139 6.402v1.343l7.806-7zm10.194-7c0-1.104-.896-2-2-2s-2 .896-2 2 .896 2 2 2 2-.896 2-2zm-1 0c0-.552-.448-1-1-1s-1 .448-1 1 .448 1 1 1 1-.448 1-1z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">No API tokens</h3>
                    <p class="text-gray-500 mb-6">You haven't created any API tokens yet. Create one to get started with our API.</p>
                </div>
            @endif
        </div>

        <!-- API Documentation -->
        <div class="mt-8 bg-blue-50 rounded-2xl border border-blue-200 p-6">
            <h3 class="text-lg font-semibold text-blue-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                API Usage
            </h3>
            <div class="text-sm text-blue-800 space-y-3">
                <p><strong>Base URL:</strong> <code class="bg-white px-2 py-1 rounded font-mono">{{ rtrim(config('app.url'), '/') }}/api</code></p>
                <p><strong>Authentication:</strong> Include your token in the Authorization header</p>
                <div class="bg-white rounded-lg p-4 mt-3">
                    <code class="text-xs font-mono text-gray-800">
                        curl -H "Authorization: Bearer YOUR_TOKEN" {{ rtrim(config('app.url'), '/') }}/api/notes
                    </code>
                </div>
                <div class="text-xs text-blue-700 mt-3">
                    <p><strong>Available endpoints:</strong></p>
                    <ul class="list-disc list-inside space-y-1 mt-2">
                        <li><code>GET /api/notes</code> - List your notes</li>
                        <li><code>POST /api/notes</code> - Create a new note</li>
                        <li><code>GET /api/published/{slug}</code> - Get published note (public)</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copyToClipboard(elementId) {
    const element = document.getElementById(elementId);
    element.select();
    element.setSelectionRange(0, 99999);
    document.execCommand('copy');

    // Show feedback
    const button = element.nextElementSibling;
    const originalText = button.textContent;
    button.textContent = 'Copied!';
    button.classList.add('bg-green-600');
    button.classList.remove('bg-emerald-600');

    setTimeout(() => {
        button.textContent = originalText;
        button.classList.remove('bg-green-600');
        button.classList.add('bg-emerald-600');
    }, 2000);
}
</script>