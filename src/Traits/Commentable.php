<?php

namespace Dealskoo\Comment\Traits;

use Dealskoo\Comment\Models\Comment;

trait Commentable
{
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function approvedComments()
    {
        return $this->comments()->where('approved', true);
    }

    public function comment($commenter, $message, $score = 0, $parent_id = null, $guest_name = null, $guest_email = null)
    {
        $comment = new Comment();
        $comment->fill([
            'commenter_id' => $commenter ? $commenter->getKey() : null,
            'commenter_type' => $commenter ? $commenter->getMorphClass() : null,
            'guest_name' => $guest_name,
            'guest_email' => $guest_email,
            'score' => $score,
            'comment' => $message,
            'parent_id' => $parent_id
        ]);
        return $this->comments()->save($comment);
    }
}
