<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoritesController
{

    /**
     * Get current user favorites list.
     */
    public function userFavorites()
    {
        return Auth::user()->favorites()->paginate(15);
    }

    /**
     * Add a book to favorites list.
     */
    public function create(Request $request)
    {
        Auth::user()->favorites()->attach([$request->input('id')]);
        return response('Added!', 201);
    }

    /**
     * Get specific user favorites list.
     * @param $id
     */
    public function get($id) {
        return User::find($id)->favorites;
    }

    /**
     * Delete a book from favorites list.
     */
    public function delete($id)
    {
        Auth::user()->favorites()->detach([$id]);

        return response('Deleted!', 202);
    }

}