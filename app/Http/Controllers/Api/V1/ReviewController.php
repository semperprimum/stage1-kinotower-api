<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Api\V1\Film;
use App\Models\Api\V1\Review;
use App\Models\Api\V1\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(User $user)
    {
            $reviews = $user->reviews()
                ->with('film:id,name')
                ->select('id', 'film_id', 'message', 'is_approved', 'created_at')
                ->get();

            $data = [
                'reviews' => $reviews->map(function ($review) {
                    return [
                        'id' => $review->id,
                        'film' => [
                            'id' => $review->film->id,
                            'name' => $review->film->name,
                        ],
                        'message' => $review->message,
                        'is_approved' => $review->is_approved,
                        'created_at' => $review->created_at,
                    ];
                }),
            ];

            return response($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'film_id' => ['required', Rule::exists("films", "id")],
            'message' => ['required', 'min:4', 'max:1024']
        ]);

        $userId = auth()->id();

        $review = Review::create([
            'film_id' => $request->film_id,
            'user_id' => $userId,
            'message' => $request->message
        ]);
        $film = Film::find($request->film_id);

        return \response([
            'id' => $review->id,
            'film' => [
                'id' => $film->id,
                'name' => $film->name,
            ],
            'message' => $request->message,
            'isApproved' => $review->is_approved,
            'createdAt' => $review->created_at
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(Film $film)
    {
        if (!$film) {
            return \response([
                "message" => "not found"
            ], 404);
        }

        $reviews = $film->reviews()->with('user')->get();

        $reviewsData = $reviews->map(function ($review) {
            return [
                'id' => $review->id,
                'user' => [
                    'id' => $review->user->id,
                    'fio' => $review->user->fio,
                ],
                'message' => $review->message,
                'created_at' => $review->created_at->toISOString(),
            ];
        });

        return response()->json([
            'reviews' => $reviewsData,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user, Review $review)
    {
        if ($review->user_id != $user->id) {
            return response([
                'message' => 'Access denied'
            ]);
        }

        if ($user->id == auth()->id() && $review->user_id == $user->id) {
            $review->delete();
            return response([
               'status' => 'success'
            ]);
        }
    }
}

