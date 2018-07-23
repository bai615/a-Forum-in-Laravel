<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Thread;
use Illuminate\Http\Request;
use App\Filters\ThreadsFilters;

class ThreadsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param null $channelSlug
     * @return \Illuminate\Http\Response
     */
    /*public function index($channelSlug = null)
    {
        //
        if ($channelSlug) {
            $channelId = Channel::where('slug', $channelSlug)->first()->id;
            $threads = Thread::where('channel_id', $channelId)->latest()->get();
        } else {
            $threads = Thread::latest()->get();
        }

        return view('threads.index', compact('threads'));
    }*/

    /**
     * @param Channel $channel
     * @param ThreadsFilters $filters
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Channel $channel, ThreadsFilters $filters)
    {
        $threads = $this->getThreads($channel, $filters);

        return view('threads.index', compact('threads'));
    }

    protected function getThreads(Channel $channel, ThreadsFilters $filters)
    {
        // 方法 with() 提前加载了我们后面需要用到的关联属性 channel
        $threads = Thread::with('channel')->latest()->filter($filters);

        if ($channel->exists) {
            $threads->where('channel_id', $channel->id);
        }

//        dd($threads->toSql());
        // select `threads`.*, (select count(*) from `replies` where `threads`.`id` = `replies`.`thread_id`) as `replies_count` from `threads` order by `created_at` desc, `replies_count` desc

        return $threads->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('threads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        request()->validate([
            'title' => 'required',
            'body' => 'required',
            'channel_id' => 'required|exists:channels,id',
        ]);

        $thread = Thread::create([
            'user_id' => auth()->id(),
            'channel_id' => request('channel_id'),
            'title' => request('title'),
            'body' => request('body'),
        ]);

        return redirect($thread->path());
    }

    /**
     * Display the specified resource.
     *
     * @param $channel
     * @param  \App\Thread $thread
     * @return \Illuminate\Http\Response
     */
    public function show($channel, Thread $thread)
    {
        //
//        return view('threads.show', compact('thread'));
        return view('threads.show', [
            'thread' => $thread,
            'replies' => $thread->replies()->paginate(10)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Thread $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Thread $thread
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thread $thread)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $channel
     * @param  \App\Thread $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy($channel, Thread $thread)
    {
        // 删除话题相关回复，也可以使用 deleting 事件删除
//        $thread->replies()->delete();

        /*if($thread->user_id != auth()->id()){
            // 只能删除自己创建的话题
            return back();
        }*/
//        if ($thread->user_id != auth()->id()) {
//            /*if (request()->wantsJson()) {
//                return response(['status' => 'Permission Denied'], 405);
//            }*/
//
//            abort(403, 'You do not have permission to do this.');
//        }

        $this->authorize('update', $thread);

        $thread->delete();

        if (request()->wantsJson()) {
            return response([], 204);
        }
        return redirect('/threads');
    }
}
