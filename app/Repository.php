<?php namespace Starred;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use \DB;

/**
 * Class Repository
 * @todo add repository starred date
 * @package App
 */
class Repository extends Model
{
    /**
     * {@inheritdoc}
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * {@inheritdoc}
     *
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

    public function users()
    {
        return $this->belongsToMany('Starred\User');
    }

    public function allTags()
    {
        return $this->belongsToMany('Starred\Tag');
    }

    public function tags($user_id)
    {
        $repository_id = $this->id;

        $tags = DB::table('users')
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
