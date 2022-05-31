<?php

namespace Dealskoo\Comment\Models;

use Dealskoo\Comment\Events\CommentCreated;
use Dealskoo\Comment\Events\CommentDeleted;
use Dealskoo\Comment\Events\CommentUpdated;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Comment extends Model
{
    use HasFactory, SoftDeletes, Searchable;

    protected $appends = ['is_guest_comment'];

    protected $fillable = [
        'commenter_id',
        'commenter_type',
        'guest_name',
        'guest_email',
        'commentable_id',
        'commentable_type',
        'score',
        'comment',
        'approved',
        'parent_id'
    ];

    protected $casts = [
        'approved' => 'boolean'
    ];

    protected $dispatchesEvents = [
        'created' => CommentCreated::class,
        'updated' => CommentUpdated::class,
        'deleted' => CommentDeleted::class,
    ];

    protected $with = [
        'commenter'
    ];

    public function commenter()
    {
        return $this->morphTo();
    }

    public function commentable()
    {
        return $this->morphTo();
    }

    public function children()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function scopeApproved(Builder $builder)
    {
        return $builder->where('approved', true);
    }

    public function getIsGuestCommentAttribute()
    {
        return $this->isGuestComment();
    }

    public function isGuestComment()
    {
        return $this->commenter == null;
    }

    public function shouldBeSearchable()
    {
        return $this->approved;
    }

    public function toSearchableArray()
    {
        return $this->only([
            'guest_name',
            'guest_email',
            'score',
            'comment'
        ]);
    }
}
