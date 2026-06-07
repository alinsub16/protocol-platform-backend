<?php

namespace App\Domain\Votes\Controllers;

use Illuminate\Http\Request;
use App\Domain\Votes\Models\Vote;

class VoteController
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'votable_id' => ['required', 'integer'],
            'votable_type' => ['required', 'string'], // Thread or Comment
            'value' => ['required', 'in:1,-1'],
        ]);

        $userId = 1; // replace with auth later

        $vote = Vote::where('user_id', $userId)
            ->where('votable_id', $validated['votable_id'])
            ->where('votable_type', $validated['votable_type'])
            ->first();

        //  CASE 1: No existing vote → create
        if (!$vote) {
            $vote = Vote::create([
                'user_id' => $userId,
                'votable_id' => $validated['votable_id'],
                'votable_type' => $validated['votable_type'],
                'value' => $validated['value'],
            ]);

            $this->syncCount($vote, +$validated['value']);

            return response()->json([
                'message' => 'Vote created',
                'data' => $vote
            ]);
        }

        //  CASE 2: Same vote → remove (toggle off)
        if ($vote->value == $validated['value']) {
            $this->syncCount($vote, -$vote->value);
            $vote->delete();

            return response()->json([
                'message' => 'Vote removed'
            ]);
        }

        // CASE 3: Switch vote (+1 ↔ -1)
        $oldValue = $vote->value;

        $vote->update([
            'value' => $validated['value']
        ]);

        $this->syncCount($vote, $validated['value'] - $oldValue);

        return response()->json([
            'message' => 'Vote updated',
            'data' => $vote
        ]);
    }

    /**
     * Update cached votes_count on model
     */
    private function syncCount(Vote $vote, int $delta)
    {
        $model = $vote->votable;

        if ($model) {
            $model->increment('votes_count', $delta);
        }
    }
}