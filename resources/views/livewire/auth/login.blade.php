<div>
    <h2 class="text-2xl font-bold mb-6 text-gray-900">Login</h2>

    @if (session()->has('success'))
        <div class="mb-4 p-4 rounded-xl border-l-4 border-green-500 bg-green-50 border border-green-200 shadow-sm">
            <div class="flex items-center">
                <div class="flex-shrink-0 mr-3">
                    <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </div>
                <div class="flex-1">
                    <p class="text-green-800 font-medium">
                        {{ session('success') }}
                    </p>
                </div>
                <button type="button" onclick="this.parentElement.parentElement.style.display='none'" class="text-green-600 hover:text-green-800 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    @endif

    <form wire:submit="submit">
        <div class="mb-4">
            <label for="email" class="block text-sm font-semibold mb-2 text-secondary">
                Email
            </label>
            <input
                type="email"
                id="email"
                wire:model="email"
                class="input-custom @error('email') error @enderror"
                placeholder="Enter your email"
            >
            @error('email')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password" class="block text-sm font-semibold mb-2 text-secondary">
                Password
            </label>
            <input
                type="password"
                id="password"
                wire:model="password"
                class="input-custom @error('password') error @enderror"
                placeholder="Enter your password"
            >
            @error('password')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6 flex items-center">
            <label class="group flex items-center cursor-pointer">
                <div class="relative">
                    <input
                        type="checkbox"
                        wire:model="remember"
                        class="sr-only peer"
                        id="remember"
                    >
                    <div class="w-5 h-5 rounded-md bg-surface border-2 border-custom peer-checked:bg-our-green peer-checked:border-our-green transition-all duration-200 peer-focus:ring-2 peer-focus:ring-our-green/30 peer-hover:border-our-green/50">
                        <svg class="w-full h-full text-white opacity-0 peer-checked:opacity-100 transition-opacity duration-200 p-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
                <span class="ml-3 text-sm text-secondary group-hover:text-primary transition-colors">Remember me</span>
            </label>
        </div>

        <x-buttons.primary-button
            type="submit"
            :fullWidth="true"
            class="mb-4"
        >
            Login
        </x-buttons.primary-button>
    </form>
</div>