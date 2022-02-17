<?php

namespace Dealskoo\Comment\Tests;

use Dealskoo\Comment\Traits\Commenter;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use Commenter;

    protected $fillable = ['name'];
}
