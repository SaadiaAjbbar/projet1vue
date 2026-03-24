<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = Favorite::with('question', 'question.user')
            ->where('user_id', Auth::id())
            ->get();

        return response()->json($favorites);
    }

    public function toggle($questionId)
    {
        $userId = Auth::id();

        $favorite = Favorite::where('user_id', $userId)
            ->where('question_id', $questionId)
            ->first();

        if ($favorite) {
            $favorite->delete();
            return response()->json(['message' => 'Removed from favorites']);
        }

        Favorite::create([
            'user_id' => $userId,
            'question_id' => $questionId
        ]);

        return response()->json(['message' => 'Added to favorites']);
    }
}
