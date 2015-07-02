<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

use \DB;

class User extends Model implements AuthenticatableContract
{
    use Authenticatable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'login', 'avatar'];


    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    public function token()
    {
        return $this->hasOne('App\Token', 'id');
    }

    public function tags()
    {
        return $this->buildTagQuery()
            ->paginate();
    }

    public function repositories()
    {
        return $this->belongsToMany('App\Repository');
    }

    public function searchTags($keyword, $currentPage)
    {
        return $this->buildTagQuery()
            ->where('title', 'like', '%' . $keyword . '%')
            ->forPage($currentPage, $this->perPage)
            ->get();
    }

    public function searchRepositories($keyword, $currentPage)
    {
        return $this->repositories()
            ->where(function ($query) use ($keyword) {
                $query->where('full_name', 'like', '%' . $keyword . '%')
                    ->orWhere('description', 'like', '%' . $keyword . '%');

            })
            ->forPage($currentPage, $this->perPage)
            ->get();
    }

    private function buildTagQuery()
    {
        return DB::table('repository_user')
            ->where('repository_user.user_id', '=', $this->id)
            ->join('repository_tag', 'repository_tag.repository_id', '=', 'repository_user.repository_id')
            ->join('tags', 'repository_tag.tag_id', '=', 'tags.id')
            ->select('tags.id', 'tags.title')
            ->distinct();
    }
}
