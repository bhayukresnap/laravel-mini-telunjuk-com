<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Cesargb\Database\Support\CascadeDelete;
class Blog extends Model
{
    use CascadeDelete;
    protected $table = "blogs";
    protected $primaryKey = "id";
    protected $fillable = [
        'title','body','featuredImage','published_at'
    ];
    protected $cascadeDeleteMorph = ['meta','tags','thumbnail'];
    public function meta(){
    	return $this->morphOne('App\Meta', 'metaable');
    }

    public function tags()
    {
        return $this->morphToMany(\App\Tag::class, 'taggable')->withPivot('tag_id');
    }

    public function thumbnail(){
        return $this->morphOne('App\Thumbnail', 'imageable');
    }
}
