<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'tag', 'title', 'subtitle', 'page_image', 'meta_description', 'reverse_direction'
    ];


    /**
     * 定义文章与标签之间多对多的关联关系
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function posts()
    {
        return $this->belongsToMany('App\Post', 'post_tag_pivot');
    }

    /**
     * 将Tags存入数据库
     * @param array $tags
     */
    public static function addNeededTags(array $tags)
    {
        if(0 === count($tags)) {
            return;
        }

        $found = static::whereIn('tag', $tags)->lists('tag')->all();

        foreach(array_diff($tags, $found) as $tag) {
            static::create([
               'tag' => $tag,
                'title' => $tag,
                'subtitle' => 'Subtitle for '.$tag,
                'page_image' => '',
                'meta_description' => '',
                'reverse_direction' => false,
            ]);
        }
    }

    public static function layout($tag, $default='blog.layouts.index')
    {
        $layout = static::whereTag($tag)->pluck('layout');
        return $layout ?: $default;
    }

}
