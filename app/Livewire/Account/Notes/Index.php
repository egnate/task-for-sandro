<?php

namespace App\Livewire\Account\Notes;

use Livewire\Component;
use App\Models\Note;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $filterPublished = 'all'; // 'all', 'published'
    public $filterPinned = 'all'; // 'all', 'pinned', 'unpinned'

    protected $queryString = ['search', 'filterPublished', 'filterPinned'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterPublished()
    {
        $this->resetPage();
    }

    public function updatingFilterPinned()
    {
        $this->resetPage();
    }

    public function deleteNote($noteId)
    {
        $note = Note::where('user_id', auth()->id())->findOrFail($noteId);
        $note->delete();

        session()->flash('success', 'Note deleted successfully!');
    }

    public function togglePin($noteId)
    {
        $note = Note::where('user_id', auth()->id())->findOrFail($noteId);
        $note->is_pinned = !$note->is_pinned;
        $note->save();

    }

    public function togglePublish($noteId)
    {
        $note = Note::where('user_id', auth()->id())->findOrFail($noteId);
        $note->is_published = !$note->is_published;

        if ($note->is_published && empty($note->slug)) {
            $note->generateSlug();
        }

        $note->save();

        session()->flash('success', $note->is_published ? 'Note published!' : 'Note unpublished!');
    }

    public function getNotes()
    {
        $query = Note::where('user_id', auth()->id())
            ->orderByRaw("JSON_EXTRACT(data, '$.is_pinned') IS NOT NULL AND JSON_EXTRACT(data, '$.is_pinned') = true DESC")
            ->orderByDesc('created_at');

        // Apply search filter - using whereRaw for JSON search
        if (!empty($this->search)) {
            $searchTerm = strtolower($this->search);
            $query->where(function($q) use ($searchTerm) {
                $q->whereRaw("LOWER(JSON_EXTRACT(data, '$.title')) LIKE ?", ['%' . $searchTerm . '%'])
                  ->orWhereRaw("LOWER(JSON_EXTRACT(data, '$.content')) LIKE ?", ['%' . $searchTerm . '%']);
            });
        }

        // Apply published filter
        if ($this->filterPublished === 'published') {
            $query->where('is_published', true);
        }

        // Apply pinned filter
        if ($this->filterPinned === 'pinned') {
            $query->whereRaw("JSON_EXTRACT(data, '$.is_pinned') = true");
        } elseif ($this->filterPinned === 'unpinned') {
            $query->where(function($q) {
                $q->whereRaw("JSON_EXTRACT(data, '$.is_pinned') = false")
                  ->orWhereRaw("JSON_EXTRACT(data, '$.is_pinned') IS NULL");
            });
        }

        return $query->paginate(12);
    }

    public function render()
    {
        return view('livewire.account.notes.index', [
            'notes' => $this->getNotes()
        ])->layout('layouts.account');
    }
}