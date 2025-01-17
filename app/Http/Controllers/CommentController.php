<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Article;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function store(Request $request, Article $article)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        $comment = new Comment();
        $comment->article_id = $article->id;
        $comment->first_name = $request->first_name;
        $comment->last_name = $request->last_name;
        $comment->email = $request->email;
        $comment->message = $request->message;
        $comment->save();

        return redirect()->route('articles.show', $article->id)
            ->with('success', 'Votre commentaire a été soumis et attend validation.');
    }
}
