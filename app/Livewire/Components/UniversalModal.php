<?php

namespace App\Livewire\Components;

use Livewire\Component;

class UniversalModal extends Component
{
    public $showModal = false;
    public $modalType = '';
    public $modalTitle = '';
    public $modalData = [];
    public $modalSize = 'default'; // default, large, small, full

    protected $listeners = [
        'open-modal' => 'openModal',
        'close-modal' => 'closeModal',
        'modal-data-updated' => 'updateModalData'
    ];

    public function openModal($type, $title = '', $data = [], $size = 'default')
    {
        $this->modalType = $type;
        $this->modalTitle = $title;
        $this->modalData = $data;
        $this->modalSize = $size;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->modalType = '';
        $this->modalTitle = '';
        $this->modalData = [];
        $this->modalSize = 'default';

        // Dispatch close event for any listening components
        $this->dispatch('modal-closed');
    }

    public function updateModalData($data)
    {
        $this->modalData = array_merge($this->modalData, $data);
    }

    public function getModalSizeClass()
    {
        return match($this->modalSize) {
            'small' => 'max-w-md',
            'large' => 'max-w-4xl',
            'full' => 'max-w-7xl',
            default => 'max-w-2xl'
        };
    }

    public function render()
    {
        return view('livewire.components.universal-modal');
    }
}