<?php

namespace Dealskoo\Comment\Tests;

use Dealskoo\Comment\Traits\Commentable;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use Commentable;

    protected $fillable = ['title'];
}
