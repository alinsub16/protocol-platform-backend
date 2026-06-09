<?php

namespace App\Domain\Reviews\Controllers;

use Illuminate\Http\Request;
use App\Domain\Reviews\Models\Review;
use App\Domain\Reviews\Resources\ReviewResource;
use App\Domain\Protocols\Models\Protocol;

class ReviewController
{
    /**
     * GET /api/protocols/{protocol}/reviews
     */
    public function index(Protocol $protocol)
    {
        return ReviewResource::collection(
            $protocol->reviews()
                ->with('user')
                ->latest()
                ->get()
        );
    }

    /**
     * POST /api/reviews
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'protocol_id' => ['required', 'exists:protocols,id'],
        'rating' => ['required', 'integer', 'min:1', 'max:5'],
        'feedback' => ['nullable', 'string'],
    ]);

    $userId = 1;

    $review = Review::create([
        'protocol_id' => $validated['protocol_id'],
        'user_id' => $userId,
        'rating' => $validated['rating'],
        'feedback' => $validated['feedback'] ?? null,
    ]);

    $this->updateProtocolRating($review->protocol);

    return new ReviewResource(
        $review->load('user')
    );
}

    /**
     * PUT /api/reviews/{review}
     */
    public function update(Request $request, Review $review)
    {
        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'feedback' => ['nullable', 'string'],
        ]);

        $review->update($validated);

        $this->updateProtocolRating($review->protocol);

        return new ReviewResource(
            $review->fresh()->load('user')
        );
    }

    /**
     * DELETE /api/reviews/{review}
     */
    public function destroy(Review $review)
    {
        $protocol = $review->protocol;

        $review->delete();

        $this->updateProtocolRating($protocol);

        return response()->json([
            'message' => 'Review deleted successfully.'
        ]);
    }

    /**
     * Recalculate protocol stats
     */
    private function updateProtocolRating(Protocol $protocol): void
    {
        $reviews = $protocol->reviews();

        $protocol->update([
            'reviews_count' => $reviews->count(),
            'avg_rating' => round(
                $reviews->avg('rating') ?? 0,
                2
            ),
        ]);
    }
}