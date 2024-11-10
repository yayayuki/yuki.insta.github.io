<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    private $comment;

    public function __construct(Comment $comment){
        $this->comment = $comment;
    }

    # To save a comment
    public function store(Request $request, $post_id){

        $request->validate(
            [   // RULES
                'comment_body' . $post_id => 'required|max:150'
                // 'comment_body' . $post_id is from name="comment_body{{ $post->id }}" in comments.blade.php
                // 'comment_body' . $post_id is to specify ID of the post
            ],
            [   // ERROR MESSAGES
                'comment_body' . $post_id . '.required' => 'You cannot submit an empty comment.',
                'comment_body' . $post_id . '.max' => 'The comment must not have more than 150 characters.'
            ]
        );

        $this->comment->body    = $request->input('comment_body' . $post_id); 
        $this->comment->user_id = Auth::user()->id;
        $this->comment->post_id = $post_id;
        $this->comment->save();

        return redirect()->route('post.show', $post_id);
    }

    public function destroy($id){
        $this->comment->destroy($id);

        return redirect()->back();
    }
}
  