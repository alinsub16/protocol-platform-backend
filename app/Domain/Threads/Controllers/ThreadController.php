<?php

namespace App\Domain\Threads\Controllers;

use App\Domain\Threads\Models\Thread;
use App\Domain\Threads\Resources\ThreadResource;
use Illuminate\Http\Request;

class ThreadController
{
    /**
     * GET /api/threads
     */
    public function index(Request $request)
    {
        $query = Thread::query()
            ->with(['user', 'protocol'])
            ->withCount(['comments']);

        // Search
        if ($request->filled('search')) {
            $query->where('title', 'like', "%{$request->search}%")
                  ->orWhere('body', 'like', "%{$request->search}%");
        }

        // Filter by protocol
        if ($request->filled('protocol_id')) {
            $query->where('protocol_id', $request->protocol_id);
        }

        // Sorting
        match ($request->sort) {
            'recent' => $query->latest(),
            'most_commented' => $query->orderByDesc('comments_count'),
            'most_voted' => $query->orderByDesc('votes_count'),
            default => $query->latest(),
        };

        return ThreadResource::collection(
            $query->paginate(10)
        );
    }

    /**
     * GET /api/threads/{thread}
     */
    public function show(Thread $thread)
    {
        $thread->load([
            'user',
            'protocol',
            'comments.user',
            'comments.replies.user',
        ]);

        return new ThreadResource($thread);
    }

    /**
     * POST /api/threads
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'protocol_id' => ['required', 'exists:protocols,id'],
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'tags' => ['nullable', 'array'],
        ]);

        $thread = Thread::create([
            ...$validated,
            'user_id' => 1, // replace with auth later
            'tags' => $validated['tags'] ?? [],
        ]);

        return new ThreadResource($thread);
    }

     /**
     * GET /search/threads
     */

    public function search(Request $request)
    {
        $q = $request->input('q');

        if (!$q || strlen($q) < 2) {
            return response()->json(['data' => []]);
        }

        $results = Thread::search($q)->get();

        return response()->json([
            'data' => $results
        ]);
    }
}