<?php

namespace Starred;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Starred\Contracts\ModelInterface;

/**
 * Class Tag
 * @package Starred
 */
class Tag extends Model implements ModelInterface
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tags';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function repositories()
    {
        return $this->belongsToMany('Starred\Repository');
    }

    /**
     * @param string $title
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public static function findOrCreate($title)
    {
        $title = Str::lower($title);

        if (!is_null($model = static::query()->where('title', '=', $title)->first())) {
            return $model;
        }

        return static::create([
            'title' => $title
        ]);
    }
}
