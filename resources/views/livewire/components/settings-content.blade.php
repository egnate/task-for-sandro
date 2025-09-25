<div class="p-8">
    <!-- Tab Navigation -->
    <div class="flex border-b border-gray-200 mb-6">
        <button
            wire:click="setActiveTab('profile')"
            class="px-4 py-2 text-sm font-medium border-b-2 transition-colors {{ $activeTab === 'profile' ? 'border-emerald-500 text-emerald-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}"
        >
            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            Profile
        </button>
        <button
            wire:click="setActiveTab('password')"
            class="px-4 py-2 text-sm font-medium border-b-2 transition-colors {{ $activeTab === 'password' ? 'border-emerald-500 text-emerald-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}"
        >
            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
            </svg>
            Security
        </button>
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

    <!-- Profile Tab -->
    @if($activeTab === 'profile')
        <form wire:submit="updateProfile" class="bg-white rounded-2xl border border-gray-200 p-6 space-y-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Profile Information</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                    <input
                        type="text"
                        wire:model="name"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-colors @error('name') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror"
                        placeholder="Enter your name"
                    >
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input
                        type="email"
                        wire:model="email"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-colors @error('email') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror"
                        placeholder="Enter your email"
                    >
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end space-x-3 pt-4 border-t border-gray-100">
                <x-buttons.secondary type="button" wire:click="$dispatch('close-modal')" size="small">
                    Cancel
                </x-buttons.secondary>
                <x-buttons.primary type="submit" size="small">
                    Save Changes
                </x-buttons.primary>
            </div>
        </form>
    @endif

    <!-- Password Tab -->
    @if($activeTab === 'password')
        <form wire:submit="updatePassword" class="bg-white rounded-2xl border border-gray-200 p-6 space-y-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Change Password</h3>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Current Password</label>
                <input
                    type="password"
                    wire:model="current_password"
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-colors @error('current_password') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror"
                    placeholder="Enter current password"
                >
                @error('current_password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                <input
                    type="password"
                    wire:model="new_password"
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-colors @error('new_password') border-red-300 focus:border-red-500 focus:ring-red-500/20 @enderror"
                    placeholder="Enter new password"
                >
                @error('new_password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror

                @if($new_password)
                    <div class="mt-4">
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-gray-600 font-medium">Password Strength</span>
                            <span class="font-medium {{ $passwordStrength < 50 ? 'text-red-500' : ($passwordStrength < 75 ? 'text-yellow-500' : 'text-green-500') }}">
                                @if($passwordStrength < 50)
                                    Weak
                                @elseif($passwordStrength < 75)
                                    Medium
                                @else
                                    Strong
                                @endif
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="h-2.5 rounded-full transition-all duration-300 {{ $passwordStrength < 50 ? 'bg-red-500' : ($passwordStrength < 75 ? 'bg-yellow-500' : 'bg-green-500') }}" style="width: {{ $passwordStrength }}%"></div>
                        </div>
                    </div>
                @endif
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                <input
                    type="password"
                    wire:model="new_password_confirmation"
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-colors"
                    placeholder="Confirm new password"
                >
            </div>

            <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                <p class="font-medium text-gray-900 mb-3">Password Requirements</p>
                <ul class="space-y-2 text-sm">
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mr-3 {{ strlen($new_password) >= 8 ? 'text-green-500' : 'text-gray-400' }}" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="{{ strlen($new_password) >= 8 ? 'text-green-700' : 'text-gray-600' }}">At least 8 characters</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mr-3 {{ preg_match('/[A-Z]/', $new_password) ? 'text-green-500' : 'text-gray-400' }}" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="{{ preg_match('/[A-Z]/', $new_password) ? 'text-green-700' : 'text-gray-600' }}">One uppercase letter</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mr-3 {{ preg_match('/[a-z]/', $new_password) ? 'text-green-500' : 'text-gray-400' }}" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="{{ preg_match('/[a-z]/', $new_password) ? 'text-green-700' : 'text-gray-600' }}">One lowercase letter</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mr-3 {{ preg_match('/[0-9]/', $new_password) ? 'text-green-500' : 'text-gray-400' }}" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="{{ preg_match('/[0-9]/', $new_password) ? 'text-green-700' : 'text-gray-600' }}">One number</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mr-3 {{ preg_match('/[^a-zA-Z0-9]/', $new_password) ? 'text-green-500' : 'text-gray-400' }}" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="{{ preg_match('/[^a-zA-Z0-9]/', $new_password) ? 'text-green-700' : 'text-gray-600' }}">One special character</span>
                    </li>
                </ul>
            </div>

            <div class="flex justify-end space-x-3 pt-4 border-t border-gray-100">
                <x-buttons.secondary type="button" wire:click="$dispatch('close-modal')" size="small">
                    Cancel
                </x-buttons.secondary>
                <x-buttons.primary type="submit" size="small">
                    Update Password
                </x-buttons.primary>
            </div>
        </form>
    @endif
</div>