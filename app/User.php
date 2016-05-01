<?php

namespace Starred;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class User extends Model implements \Illuminate\Contracts\Auth\Authenticatable
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function token()
    {
        return $this->hasOne('Starred\Token', 'id');
    }

    /**
     * @return mixed
     */
    public function tags()
    {
        return $this->buildTagQuery()
            ->paginate();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function repositories()
    {
        return $this->belongsToMany('Starred\Repository');
    }

    /**
     * @return mixed
     */
    public function jobs()
    {
        return DB::table('user_job')
            ->where('user_job.user_id', '=', $this->id)
            ->join('jobs', 'user_job.job_id', '=', 'jobs.id')
            ->select('jobs.id')->get();
    }

    /**
     * @param $jobId
     *
     * @return mixed
     */
    public function attachJob($jobId)
    {
        return DB::table('user_job')
            ->insert([
                'user_id' => $this->id,
                'job_id' => $jobId
            ]);
    }

    /**
     * @param $jobId
     *
     * @return mixed
     */
    public function detachJob($jobId)
    {
        return DB::table('user_job')
            ->where('job_id', '=', $jobId)
            ->delete();
    }

    /**
     * @param     $keyword
     * @param int $currentPage
     *
     * @return mixed
     */
    public function searchTags($keyword, $currentPage = 0)
    {
        return $this->buildTagQuery()
            ->where('title', 'like', '%' . $keyword . '%')
            ->forPage($currentPage, $this->perPage)
            ->get();
    }

    /**
     * @param $keyword
     * @param $currentPage
     *
     * @return mixed
     */
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

    /**
     * @return mixed
     */
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
