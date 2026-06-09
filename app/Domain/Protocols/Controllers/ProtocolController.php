<?php

namespace App\Domain\Protocols\Controllers;

use App\Domain\Protocols\Models\Protocol;
use App\Domain\Protocols\Resources\ProtocolResource;
use App\Domain\Threads\Models\Thread;
use Illuminate\Http\Request;

class ProtocolController
{
    /**
     * GET /api/protocols
     */
    public function index(Request $request)
    {
        $query = Protocol::query()
            ->with(['user'])
            ->withCount(['threads', 'reviews'])
            ->withAvg('reviews', 'rating');

        //  SEARCH
        if ($request->filled('search')) {
            $query->where('title', 'like', "%{$request->search}%")
                  ->orWhere('content', 'like', "%{$request->search}%");
        }

        // 🏷 FILTER BY TAG
       if ($request->filled('tag')) {
            $query->whereJsonContains('tags', $request->tag);
        }

        //  SORTING
        match ($request->sort) {
            'recent' => $query->latest(),
            'most_reviewed' => $query->orderByDesc('reviews_count'),
            'most_threads' => $query->orderByDesc('threads_count'),
            'top_rated' => $query->orderByDesc('avg_rating'),
            default => $query->latest(),
        };

        return ProtocolResource::collection(
            $query->paginate(10)
        );
    }

    /**
     * GET /api/protocols/{protocol}
     */
    public function show(Protocol $protocol)
    {
        $protocol->load([
            'user',
            'threads.user',
            'threads' => function ($query) {
                $query->withCount(['comments', 'votes']);
            },
            'reviews.user',
        ]);
        $protocol->loadCount(['threads', 'reviews']);
        $protocol->loadAvg('reviews', 'rating');

        return new ProtocolResource($protocol);
    }

    /**
     * GET /api/protocols/{protocol_id}/threads 
     */

    public function threads(Protocol $protocol)
        {
            $threads = $protocol->threads()
                ->with('user')
                ->withCount(['comments'])
                ->latest()
                ->paginate(10);

            $threads->getCollection()->transform(function ($thread) {
                return [
                    'id' => (string) $thread->id,
                    'title' => $thread->title,
                    'body' => $thread->body,
                    'tags' => $thread->tags ?? [],

                    // FLATTENED (matches Typesense style)
                    'user_id' => (string) $thread->user_id,
                    'user_name' => $thread->user?->name,

                    // optional alias if your frontend uses author
                    'author' => $thread->user?->name,
                    'votes_count' => $thread->votes_count,

                    'comments_count' => $thread->comments_count,
                    'created_at' => $thread->created_at?->timestamp,
                ];
            });

            return response()->json($threads);
        }

    /**
     * POST /api/protocols
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'tags' => ['nullable', 'array'],
        ]);

        $protocol = Protocol::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'tags' => $validated['tags'] ?? [],
            'user_id' => 1, // replace with auth later
            'rating' => 0,
        ]);

        return new ProtocolResource($protocol);
    }


    /**
     * GET /api/protocols
     */
    public function search(Request $request)
    {
        $q = $request->input('q');

        if (!$q || strlen($q) < 2) {
            return response()->json(['data' => []]);
        }

        $results = Protocol::search($q)->get();

        return response()->json([
            'data' => $results
        ]);
    }
}