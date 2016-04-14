<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Console\Descriptor\MarkdownDescriptor;
use Carbon\Carbon;

class Post extends Model
{
    protected $dates = ['published_at'];
    // 在 Post 类的 $dates 属性后添加 $fillable 属性
    protected $fillable = [
        'title', 'subtitle', 'content_raw', 'page_image', 'meta_description','layout', 'is_draft', 'published_at',
    ];


    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;

        if(!$this->exists) {
            $this->setUniqueSlug($value, '');
        }
    }

    /**
     * 定义文章与标签之间多对多的关系
     */
    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'post_tag_pivot');
    }


    protected function setUniqueSlug($title, $extra)
    {
        $slug = str_slug($title . '-' . $extra); // 从给定字串产生一个对网址友善的「slug」

        if(static::whereSlug($slug)->exists()) {
            $this->setUniqueSlug($title, $extra + 1);
            return;
        }
        $this->attributes['slug'] = $slug;
    }

    /**
     * Set the HTML content automatically when the raw content is set
     * @param $value
     */
    public function setContentRowAttribute($value)
    {
        $markdown = new Markdowner();

        $this->attributes['content_raw'] = $value;
        $this->attributes['content_html'] = $markdown->toHTML($value);
    }

    public function syncTags(array $tags)
    {
        Tag::addNeededTags($tags);

        if(count($tags)) {
            $this->tags()->sync(
                Tag::whereIn('tag', $tags)->lists('id')->all()
            );
            return;
        }

        $this->tags()->detach();
    }

    public function getPublishDateAttribute($value)
    {
        return $this->published_at->format('M-j-Y');
    }

    public function getPublishTimeAttribute($value)
    {
        return $this->published_at->format('g:i A');
    }

    public function getContentAttribute($value)
    {
        return $this->content_raw;
    }

    /**
     * return URL to Post
     * @param Tag|null $tag
     */
    public function url(Tag $tag=null)
    {
        $url = url('blog/'.$this->slug);
        if($tag) {
            $url .= '?tag='.urlencode($this->tag);
        }

        return $url;
    }

    /**
     * Return array of tag links
     * @param string $base
     */
    public function tagLinks($base = '/blog?tag=%TAG%')
    {
        $tags = $this->tags()->lists('tag');
        $return = [];
        foreach($tags as $tag) {
            $url = str_replace('%TAG%', urlencode($tag), $base);
            $return[] = '<a href="' .$url.'">'.e($tag).'</a>';
        }
        return $return;
    }

    /**
     * Return next pot after this one or null
     * @param Tag|null $tag
     */
    public function newerPost(Tag $tag = null)
    {
        $query =
            static::where('published_at', '>', $this->published_at)
                ->where('published_at', '<=', Carbon::now())
                ->where('is_draft', 0)
                ->orderBy('published_at', 'asc');
        if ($tag) {
            $query = $query->whereHas('tags', function ($q) use ($tag) {
                $q->where('tag', '=', $tag->tag);
            });
        }

        return $query->first();
    }

    /**
     * Return older post before this one or null
     * @param Tag|null $tag
     */
    public function olderPost(Tag $tag = null) {
        $query =
            static::where('published_at', '<', $this->published_at)
                ->where('is_draft', 0)
                ->orderBy('published_at', 'desc');
        if ($tag) {
            $query = $query->whereHas('tags', function ($q) use ($tag) {
                $q->where('tag', '=', $tag->tag);
            });
        }

        return $query->first();
    }
}
