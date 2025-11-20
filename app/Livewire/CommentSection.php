<?php

namespace App\Livewire;

use App\Models\Comment;
use App\Models\Resource;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CommentSection extends Component
{
    public Resource $resource;
    public $newComment = '';
    public $editCommentId = null;
    public $editCommentBody = '';

    protected $rules = [
        'newComment' => 'required|min:3|max:1000',
    ];

    public function postComment()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $this->validate();

        Comment::create([
            'body' => $this->newComment,
            'user_id' => Auth::id(),
            'resource_id' => $this->resource->id,
        ]);

        $this->newComment = '';
        $this->resource->refresh();

        session()->flash('message', 'Comment posted successfully!');
    }

    public function startEdit($commentId)
    {
        $comment = Comment::findOrFail($commentId);
        
        if ($comment->user_id !== Auth::id() && !Auth::user()->isModerator()) {
            abort(403);
        }

        $this->editCommentId = $commentId;
        $this->editCommentBody = $comment->body;
    }

    public function updateComment()
    {
        $comment = Comment::findOrFail($this->editCommentId);
        
        if ($comment->user_id !== Auth::id() && !Auth::user()->isModerator()) {
            abort(403);
        }

        $comment->update([
            'body' => $this->editCommentBody,
            'edited_at' => now(),
        ]);

        $this->cancelEdit();
        $this->resource->refresh();
    }

    public function cancelEdit()
    {
        $this->editCommentId = null;
        $this->editCommentBody = '';
    }

    public function deleteComment($commentId)
    {
        $comment = Comment::findOrFail($commentId);
        
        if ($comment->user_id !== Auth::id() && !Auth::user()->isModerator()) {
            abort(403);
        }

        $comment->delete();
        $this->resource->refresh();

        session()->flash('message', 'Comment deleted successfully!');
    }

    public function render()
    {
        $comments = $this->resource->comments()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.comment-section', [
            'comments' => $comments,
        ]);
    }
}