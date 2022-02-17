<?php

namespace Dealskoo\Comment\Traits;

use Dealskoo\Comment\Models\Comment;

trait Commenter
{
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commenter');
    }

    public function approvedComments()
    {
        return $this->comments()->where('approved', true);
    }

    public function comment($commentable, $message, $score = 0, $parent_id = null, $guest_name = null, $guest_email = null)
    {
        $comment = new Comment();
        $comment->fill([
            'commentable_id' => $commentable->getKey(),
            'commentable_type' => $commentable->getMorphClass(),
            'guest_name' => $guest_name,
            'guest_email' => $guest_email,
            'score' => $score,
            'comment' => $message,
            'parent_id' => $parent_id
        ]);
        return $this->comments()->save($comment);
    }
}
