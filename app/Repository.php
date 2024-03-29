<?php

namespace Starred;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Starred\Contracts\ModelInterface;

/**
 * Class Repository
 * @todo    add repository starred date
 * @package Starred
 */
class Repository extends Model implements ModelInterface
{
    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'repositories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'name', 'full_name', 'url', 'description'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('Starred\User', 'repository_user');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function allTags()
    {
        return $this->belongsToMany('Starred\Tag');
    }

    /**
     * @param int $user_id
     *
     * @return Collection
     */
    public function tags($user_id)
    {
        $repository_id = $this->id;

        $tags = \DB::table('users')
            ->where('users.id', '=', $user_id)
            ->join('repository_user', function ($join) use ($repository_id) {
                $join->on('repository_user.user_id', '=', 'users.id')
                    ->where('repository_user.repository_id', '=', $repository_id);
            })
            ->join('repository_tag', 'repository_tag.repository_id', '=', 'repository_user.repository_id')
            ->join('tags', 'repository_tag.tag_id', '=', 'tags.id')
            ->select('tags.id', 'tags.title')
            ->get();

        return Collection::make($tags)->sortBy('title');
    }
}
