<?php

namespace App\Livewire\Account\Notes;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Note;
use Illuminate\Support\Facades\Storage;

class Edit extends Component
{
    use WithFileUploads;

    public Note $note;
    public $title = '';
    public $content = '';
    public $is_pinned = false;
    public $is_published = false;
    public $image;
    public $currentImage = null;
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

    public function mount(Note $note)
    {
        // Ensure user owns the note
        if ($note->user_id !== auth()->id()) {
            abort(404);
        }

        $this->note = $note;
        $this->title = $note->title;
        $this->content = $note->content;
        $this->is_pinned = $note->is_pinned;
        $this->is_published = $note->is_published;
        $this->currentImage = $note->image_path;
    }

    public function updatedImage()
    {
        $this->uploading = true;
        $this->validate(['image' => 'image|max:2048']);
        $this->uploading = false;
    }

    public function removeCurrentImage()
    {
        if ($this->currentImage) {
            Storage::disk('public')->delete($this->currentImage);
            $this->currentImage = null;
        }
    }

    public function update()
    {
        $this->validate();

        // Handle image upload
        $imagePath = $this->currentImage;
        if ($this->image) {
            // Delete old image if exists
            if ($this->currentImage) {
                Storage::disk('public')->delete($this->currentImage);
            }
            $imagePath = $this->image->store('notes', 'public');
        }

        // Update note
        $wasPublished = $this->note->is_published;

        $this->note->update([
            'is_published' => $this->is_published,
            'data' => [
                'title' => $this->title,
                'content' => $this->content,
                'is_pinned' => $this->is_pinned,
                'image_path' => $imagePath,
                'slug' => $this->note->slug, // Keep existing slug
            ]
        ]);

        // Generate slug if newly published
        if ($this->is_published && !$wasPublished && empty($this->note->slug)) {
            $this->note->generateSlug();
            $this->note->save();
        }

        session()->flash('success', 'Note updated successfully!');

        return $this->redirect(route('notes.index'), navigate: true);
    }

    public function delete()
    {
        // Delete image if exists
        if ($this->note->image_path) {
            Storage::disk('public')->delete($this->note->image_path);
        }

        $this->note->delete();

        session()->flash('success', 'Note deleted successfully!');

        return $this->redirect(route('notes.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.account.notes.edit')->layout('layouts.account');
    }
}