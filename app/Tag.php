<?php namespace Starred;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tag extends Model
{
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

    public function repositories()
    {
        return $this->belongsToMany('Starred\Repository');
    }

    public static function findOrCreate($title)
    {
        $title = Str::lower($title);
        if (!is_null($model = static::query()->where('title', '=', $title)->first())) {
            return $model;
        } else {
            return static::create([
                'title' => $title
            ]);
        }
    }
}
