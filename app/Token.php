<?php

namespace Starred;

use Illuminate\Database\Eloquent\Model;
use Starred\Contracts\ModelInterface;

/**
 * Class Token
 * @package Starred
 */
class Token extends Model implements ModelInterface
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

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
}
