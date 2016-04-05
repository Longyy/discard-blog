<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Post;
use App\Tag;
use Carbon\Carbon;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * 该任务会在我们想要获取文章所有字段填充文章表单时执行
 * Class PostFormFields
 * @package App\Jobs
 */
class PostFormFields extends Job implements SelfHandling
{
    // 文章ID
    protected $id;
    protected $fieldList = [
        'title' => '',
        'subtitle' => '',
        'page_image' => '',
        'content' => '',
        'meta_description' => '',
        'is_draft' => "0",
        'publish_date' => '',
        'publish_time' => '',
        'layout' => 'blog.layouts.post',
        'tags' => [],
    ];

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id = null)
    {
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $fields = $this->fieldList;

        if($this->id) {
            $fields = $this->fieldsFromModel($this->id, $fields);
        } else {
            $when = Carbon::now()->addHour();
            $fields['published_date'] = $when->format('M-j-Y');
            $fields['published_time'] = $when->format('g:i A');
        }

        foreach($fields as $fieldName => $fieldValue) {
            $fields[$fieldName] = old($fieldName, $fieldValue);
        }

        return array_merge(
            $fields,
            ['allTags' => Tag::lists('tag')->all()]
        );
    }

    protected function fieldsFromModel($id, array $fields)
    {
        $post = Post::findOrFail($id);
        $fieldNames = array_keys(array_except($fields, ['tags']));

        $fields = ['id' => $id];
        foreach($fieldNames as $field) {
            $fields[$field] = $post->{$field};
        }

        $fields['tags'] = $post->tags()->lists('tag')->all();

        return $fields;
    }
}
