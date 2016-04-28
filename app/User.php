<?php

namespace Starred;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

use \DB;

class User extends Model
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
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    public function token()
    {
        return $this->hasOne('Starred\Token', 'id');
    }

    public function tags()
    {
        return $this->buildTagQuery()
            ->paginate();
    }

    public function repositories()
    {
        return $this->belongsToMany('Starred\Repository');
    }

    public function jobs()
    {
        return DB::table('user_job')
            ->where('user_job.user_id', '=', $this->id)
            ->join('jobs', 'user_job.job_id', '=', 'jobs.id')
            ->select('jobs.id')->get();
    }

    public function attachJob($jobId)
    {
        return DB::table('user_job')
            ->insert([
                'user_id' => $this->id,
                'job_id' => $jobId
            ]);
    }

    public function detachJob($jobId)
    {
        return DB::table('user_job')
            ->where('job_id', '=', $jobId)
            ->delete();
    }

    public function searchTags($keyword, $currentPage = 0)
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
