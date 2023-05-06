<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\FilmResource;
use App\Models\Api\V1\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::select('categories.id', 'categories.name', 'parent.name as parent_name', 'parent.id as parent_id')
            ->leftJoin('categories as parent', 'categories.parent_id', '=', 'parent.id')
            ->withCount(['films as filmCount'])
            ->get()
            ->map(function($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'parentCategory' => $category->parent_id ? [
                        'id' => $category->parent_id,
                        'name' => $category->parent_name,
                    ] : null,
                    'filmCount' => $category->filmCount,
                ];
            });

        return response()->json(['categories' => $categories]);
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
    public function show(string $id)
    {
        //
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
