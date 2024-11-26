<?php

namespace App\Repositories;

use App\Mapper\Contracts\IPostMapper;
use App\Models\Post;
use App\Repositories\Contracts\IPostRepository;
use App\Utils\PostTypeEnum;
use App\Utils\WorkOrderStatusEnum;
use App\Utils\Contracts\IUtility;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class PostRepository implements IPostRepository
{
    private IPostMapper $mapper;
    private IUtility $utility;

    public function __construct(IPostMapper $mapper, IUtility $utility)
    {
        $this->mapper = $mapper;
        $this->utility = $utility;
    }

    function addPost(array $request): ?Post
    {
        $createdPost = Post::query()->create($request);
        $post = $this->mapper->fromBuilderOrModel($createdPost);

        if (is_null($post->id)) return null;
        return $post;
    }

    function getPostByIdRaw(string $postId)
    {
        return Post::query()->find($postId);
    }

    function getPostById(string $postId): ?Post
    {
        try {
            $post = Post::query()->find($postId)->get();
        } catch (Throwable $t) {
            Log::error($t->getMessage());
            return null;
        }
        return $post->first();
    }

    function countLoadPostBy(?string $userId = null, ?string $status = null): int
    {
        $builder = Post::query()
            ->leftJoin('work_orders', 'work_orders.post_id', '=', 'posts.id');

        if (!is_null($userId)){
            $builder->where('posts.user_id', '=', $userId);
        }
        if (!is_null($status)) {
            $builder->where('work_orders.status', '=', $status);
        }
        return $builder->count('posts.id');
    }

    function pagedPosts(?string $idsWellName = null): LengthAwarePaginator
    {
        $builder = Post::query();

        if (!is_null($idsWellName)) {
            $builder = $builder
                ->where('title', '=', $idsWellName, 'and')
                ->where('type', '=', PostTypeEnum::POST_WELL_TYPE->value);
        }
        $builder = $builder
            ->selectRaw('posts.*, (SELECT COUNT(w.id) FROM work_orders AS w WHERE w.post_id=posts.id AND w.status=?) AS pending_wo_length', [WorkOrderStatusEnum::STATUS_PENDING->value])
            ->orderByRaw('pending_wo_length DESC, posts.created_at DESC')
            ->paginate();

        return $builder->through(function ($post){
            $post->timeAgo = $this->utility->timeAgo($post->created_at);
            $post->transporter = trim(('('.($post->operator->department->short_name ?? 'NA').') '.$post->operator->prefix.' '.$post->operator->name.' '.$post->operator->postfix) ?? 'NA');
            $post->woPendingReqCount = $this->utility->countWoPendingRequest($post);
            $post->desc = str_replace(';', ' ', $post->desc);
            return $post;
        });
    }

    public function pagedPostByUserId(string $userId): LengthAwarePaginator
    {
        $builder = Post::query()
            ->where('user_id', '=', $userId, 'and')
            ->where('type', '=', PostTypeEnum::POST_WELL_TYPE->value)
            ->orderBy('created_at', 'desc')
            ->paginate();

        return $builder->through(function ($post){
            $post->timeAgo = $this->utility->timeAgo($post->created_at);
            $post->transporter = $this->utility->transporter($post->operator);
            $post->woPendingReqCount = $this->utility->countWoPendingRequest($post);
            $post->desc = str_replace(';', ' ', $post->desc);
            return $post;
        });
    }

    function updatePost(string $post_id, array $request): ?Post
    {
        try {
            $model = Post::query()->find($post_id);
            $model->title = $request['title'];
            $model->desc = $request['desc'];

            if(!$model->save()) return null;
            return $model
                ->get()
                ->first();

        } catch (Throwable $t){
            Log::error($t->getMessage());
            return null;
        }
    }

    function removePost(string $post_id): bool
    {
        try {
            $model = Post::query()->find($post_id);
            return $model->delete();
        } catch (Throwable $t) {
            Log::error($t->getMessage());
            return false;
        }
    }

    function async(): void
    {
        DB::beginTransaction();
    }

    function await(): void
    {
        DB::commit();
    }

    function cancel(?int $toLevel = null): void
    {
        DB::rollBack($toLevel);
    }
}
