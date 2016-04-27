<?php

namespace Starred;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Token
 * @package Starred
 */
class Token extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tokens';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'token', 'auth'];
}
