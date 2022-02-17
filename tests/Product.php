<?php

namespace Dealskoo\Comment\Tests;

use Dealskoo\Comment\Traits\Commentable;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use Commentable;

    protected $fillable = ['name'];
}
