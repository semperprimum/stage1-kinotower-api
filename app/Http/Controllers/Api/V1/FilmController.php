<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\FilmCollection;
use App\Http\Resources\FilmResource;
use App\Models\Api\V1\Film;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FilmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'size' => 'nullable|integer|min:1',
            'sortBy' => 'nullable|in:name,year,rating',
            'sortDir' => 'nullable|in:asc,desc',
            'country' => 'nullable|integer',
            'category' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 400);
        }

        $size = $request->input('size', 10);
        $sortBy = $request->input('sortBy', 'name');
        $sortDir = $request->input('sortDir', 'asc');
        $country = $request->input('country');
        $category = $request->input('category');

        $query = Film::query();

        // Join the ratings table to get the average rating
        $query->leftJoin('ratings', 'films.id', '=', 'ratings.film_id')
            ->select('films.*', \DB::raw('avg(ratings.ball) as rating'));

        if ($country) {
            $query->whereHas('country', function ($query) use ($country) {
                $query->where('country_id', $country);
            });
        }

        if ($category) {
            $query->whereHas('categories', function ($query) use ($category) {
                $query->where('category_id', $category);
            });
        }

        // Use the calculated rating to sort the films
        if ($sortBy === 'rating') {
            $query->orderBy('rating', $sortDir);
        } else {
            $query->orderBy($sortBy, $sortDir);
        }

        $films = $query->groupBy('films.id')
            ->paginate($size);

        return new FilmCollection($films);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Film $film)
    {
        $film->load('country', 'categories');
        return new FilmResource($film);
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
    public function destroy(string $id)
    {
        //
    }
}
