<?php

namespace App\Livewire\Account\Notes;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Note;
use Illuminate\Support\Facades\Storage;

class Create extends Component
{
    use WithFileUploads;

    public $title = '';
    public $content = '';
    public $is_pinned = false;
    public $is_published = false;
    public $image;
    public $uploading = false;

    protected $rules = [
        'title' => 'required|string|max:255',
        'content' => 'nullable|string',
        'is_pinned' => 'boolean',
        'is_published' => 'boolean',
        'image' => 'nullable|image|max:2048', // 2MB max
    ];

    protected $messages = [
        'title.required' => 'Title is required.',
        'title.max' => 'Title cannot exceed 255 characters.',
        'image.image' => 'File must be an image.',
        'image.max' => 'Image size cannot exceed 2MB.',
    ];

    public function updatedImage()
    {
        $this->uploading = true;
        $this->validate(['image' => 'image|max:2048']);
        $this->uploading = false;
    }

    public function save()
    {
        $this->validate();

        // Handle image upload
        $imagePath = null;
        if ($this->image) {
            $imagePath = $this->image->store('notes', 'public');
        }

        // Create note
        $note = Note::create([
            'user_id' => auth()->id(),
            'is_published' => $this->is_published,
            'data' => [
                'title' => $this->title,
                'content' => $this->content,
                'is_pinned' => $this->is_pinned,
                'image_path' => $imagePath,
                'slug' => null, // Will be generated if published
            ]
        ]);

        // Generate slug if published
        if ($this->is_published) {
            $note->generateSlug();
            $note->save();
        }

        session()->flash('success', 'Note created successfully!');

        return $this->redirect(route('notes.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.account.notes.create')->layout('layouts.account');
    }
}