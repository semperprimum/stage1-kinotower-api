<?php

namespace App\Http\Resources;

use App\Models\Api\V1\Film;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FilmResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $reviews = $this->reviews;
        $reviewCount = $reviews->count();
        $ratings = $this->ratings;
        $ratingsCount = $ratings->count();
        $ratingsAvg = $ratingsCount ? number_format($ratings->avg('ball'), 1)  : null;

        return [
            'id' => $this->id,
            'name' => $this->name,
            'duration' => $this->duration,
            'year' => $this->year,
            'age' => $this->age,
            'linkImg' => $this->link_img,
            'linkKinopoisk' => $this->link_kinopoisk,
            'linkVideo' => $this->link_video,
            'createdAt' => $this->created_at,
            'country' => $this->country,
            'categories' => $this->categories->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                ];
            })->toArray(),
            "ratingAvg" => $ratingsAvg,
            "reviewCount" => $reviewCount,
        ];
    }
}
