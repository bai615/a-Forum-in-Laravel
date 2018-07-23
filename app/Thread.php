<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    //
    protected $guarded = []; // 意味所有属性均可更新，后期会修复此安全隐患
    protected $with = ['creator'];

    public function path()
    {
//        return '/threads/'.$this->id;
        return "/threads/{$this->channel->slug}/{$this->id}";
    }

    public function replies()
    {
        return $this->hasMany(Reply::class)
            ->withCount('favorites')
            ->with('owner');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');  // 使用 user_id 字段进行模型关联
    }

    public function addReply($reply)
    {
        $this->replies()->create($reply);
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

    protected static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub

        static::addGlobalScope('replyCount', function ($builder) {
            $builder->withCount('replies');
        });

        // 使用 deleting 事件删除话题相关回复
        static::deleting(function ($thread) {
            $thread->replies()->delete();
        });
    }
}
