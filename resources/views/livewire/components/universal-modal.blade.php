<div>
    @if($showModal)
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4 animate-fadeIn"
             wire:click="closeModal">
            <div class="bg-white rounded-3xl shadow-2xl w-full {{ $this->getModalSizeClass() }} max-h-[90vh] overflow-hidden animate-modalSlideIn"
                 wire:click.stop>

                <!-- Modern Modal Header -->
                <div class="sticky top-0 bg-gradient-to-r from-white via-gray-50/80 to-white backdrop-blur-sm rounded-t-3xl px-8 py-6 border-b border-gray-100/80 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <!-- Dynamic Icon based on modal type -->
                            <div class="w-12 h-12 rounded-2xl flex items-center justify-center shadow-lg
                                        {{ $modalType === 'profile' ? 'bg-gradient-to-br from-blue-500 to-blue-600' : '' }}
                                        {{ $modalType === 'settings' ? 'bg-gradient-to-br from-gray-500 to-gray-600' : '' }}
                                        {{ $modalType === 'delete-confirm' ? 'bg-gradient-to-br from-red-500 to-red-600' : '' }}
                                        {{ !in_array($modalType, ['profile', 'settings', 'delete-confirm']) ? 'bg-gradient-to-br from-emerald-500 to-emerald-600' : '' }}">
                                @if($modalType === 'profile')
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                @elseif($modalType === 'settings')
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                @elseif($modalType === 'delete-confirm')
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                    </svg>
                                @else
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                @endif
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900">{{ $modalTitle }}</h2>
                                <p class="text-sm text-gray-500 capitalize">{{ $modalType }} management</p>
                            </div>
                        </div>
                        <button wire:click="closeModal"
                                class="p-3 hover:bg-gray-100 rounded-2xl transition-all duration-200 hover:scale-105 group">
                            <svg class="w-6 h-6 text-gray-400 group-hover:text-gray-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Content Area -->
                <div class="overflow-y-auto max-h-[calc(90vh-120px)]">
                    @if($modalType === 'settings')
                        <livewire:account.components.settings-content :data="$modalData" :key="'settings-'.now()" />
                    @else
                        <div class="p-8 text-center">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Content Loading</h3>
                            <p class="text-gray-500">Modal content for "{{ $modalType }}" is being prepared...</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>