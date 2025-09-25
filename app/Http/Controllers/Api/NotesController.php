<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class NotesController extends Controller
{
    /**
     * Display a listing of the authenticated user's notes.
     * Pinned notes appear first.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Note::where('user_id', auth()->id())
            ->orderByRaw("JSON_EXTRACT(data, '$.is_pinned') IS NOT NULL AND JSON_EXTRACT(data, '$.is_pinned') = true DESC")
            ->orderByDesc('created_at');

        // Apply pinned filter if requested
        if ($request->has('is_pinned') && $request->boolean('is_pinned')) {
            $query->whereRaw("JSON_EXTRACT(data, '$.is_pinned') = true");
        }

        $notes = $query->get()->map(function ($note) {
            return [
                'id' => $note->id,
                'title' => $note->title,
                'content' => $note->content,
                'slug' => $note->slug,
                'is_published' => $note->is_published,
                'is_pinned' => $note->is_pinned,
                'image_path' => $note->image_path,
                'created_at' => $note->created_at,
                'updated_at' => $note->updated_at,
            ];
        });

        return response()->json([
            'data' => $notes,
            'total' => $notes->count(),
        ]);
    }

    /**
     * Store a newly created note.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'nullable|string',
                'is_published' => 'boolean',
                'is_pinned' => 'boolean',
                'image_path' => 'nullable|string',
            ]);

            $note = Note::create([
                'user_id' => auth()->id(),
                'is_published' => $validated['is_published'] ?? false,
                'data' => [
                    'title' => $validated['title'],
                    'content' => $validated['content'] ?? '',
                    'is_pinned' => $validated['is_pinned'] ?? false,
                    'image_path' => $validated['image_path'] ?? null,
                ]
            ]);

            // Generate slug if published
            if ($note->is_published && empty($note->slug)) {
                $note->generateSlug();
                $note->save();
            }

            return response()->json([
                'data' => [
                    'id' => $note->id,
                    'title' => $note->title,
                    'content' => $note->content,
                    'slug' => $note->slug,
                    'is_published' => $note->is_published,
                    'is_pinned' => $note->is_pinned,
                    'image_path' => $note->image_path,
                    'created_at' => $note->created_at,
                    'updated_at' => $note->updated_at,
                ],
                'message' => 'Note created successfully',
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        }
    }

    /**
     * Display the specified published note by slug (public endpoint).
     */
    public function show(string $slug): JsonResponse
    {
        $note = Note::bySlug($slug)
            ->published()
            ->first();

        if (!$note) {
            return response()->json([
                'message' => 'Note not found',
            ], 404);
        }

        return response()->json([
            'data' => [
                'id' => $note->id,
                'title' => $note->title,
                'content' => $note->content,
                'slug' => $note->slug,
                'is_published' => $note->is_published,
                'is_pinned' => $note->is_pinned,
                'image_path' => $note->image_path,
                'created_at' => $note->created_at,
                'updated_at' => $note->updated_at,
                'author' => [
                    'id' => $note->user->id,
                    'name' => $note->user->name,
                ],
            ],
        ]);
    }
}