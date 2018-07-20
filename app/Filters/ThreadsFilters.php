<?php
namespace App\Filters;

use App\User;

class ThreadsFilters extends Filters
{
    protected $filters = ['by', 'popularity'];

    public function by($username)
    {
        $user = User::where('name', $username)->firstOrFail();
        return $this->builder->where('user_id', $user->id);
    }

    public function popularity()
    {
        // 清空其他的order by条件
        $this->builder->getQuery()->orders = [];
        // select `threads`.*, (select count(*) from `replies` where `threads`.`id` = `replies`.`thread_id`) as `replies_count` from `threads` order by `replies_count` desc

        return $this->builder->orderBy('replies_count', 'desc');
    }
}