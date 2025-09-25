<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Note;

class PublicNote extends Component
{
    public Note $note;

    public function mount($slug)
    {
        // Find note by slug and ensure it's published
        $this->note = Note::where('is_published', true)
            ->whereJsonContains('data->slug', $slug)
            ->firstOrFail();
    }

    public function render()
    {
        return view('livewire.public.public-note')->layout('layouts.public');
    }
}