<?php

namespace App\Repositories;

use App\Mapper\Contracts\IPostMapper;
use App\Models\Post;
use App\Repositories\Contracts\IPostRepository;
use App\Utils\Constants;
use App\Utils\PostTypeEnum;
use App\Utils\WorkOrderStatusEnum;
use App\Utils\Contracts\IUtility;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
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

    public function generatePost(array $user, ?array $data = null): ?string
    {
        $post = [
            'type' => PostTypeEnum::POST_WELL_TYPE->value,
            'operator_id' => $user['operator_id'],
            'user_id' => $user['id'],
        ];
        if (!is_null($data)) {
            $post = array_merge($post, $data);
        }
        $posted = Post::query()->create($post);
        return $posted->id;
    }

    public function postByDateBuilder(string $date): Builder
    {
        return Post::query()->whereBetween('created_at', [
            Carbon::parse($date)->startOfDay(),
            Carbon::parse($date)->endOfDay(),
        ]);
    }

    public function arePostExistByDate(string $date): bool
    {
        return $this->postByDateBuilder($date)->exists();
    }

    public function arePostExistByDateAndArea(string $date, string $area): bool
    {
        return Post::query()->whereHas('user', function ($query) use ($area) {
            $query->where('area_name', $area);
        })
            ->whereBetween('created_at', [
                Carbon::parse($date)->startOfDay(),
                Carbon::parse($date)->endOfDay(),
            ])
            ->exists();

        /*return Post::query()
            ->join('users', 'users.id', '=', 'posts.user_id')
            ->where('users.area_name', '=', $area)
            ->whereDate('posts.created_at', $date)
            ->exists();*/
    }

    public function arePostExistByDateOrDatesAndArea($dateOrDates, string $area): bool
    {
        $builder = Post::query()->whereHas('user', function ($query) use ($area) {
            $query->where('area_name', $area);
        });
        if (is_array($dateOrDates)) {
            $builder
                ->whereDate('created_at', '>=', $dateOrDates[0], 'and')
                ->whereDate('created_at', '<=', $dateOrDates[count($dateOrDates) -1]);
        } else {
            $builder->whereBetween('created_at', [
                Carbon::parse($dateOrDates)->startOfDay(),
                Carbon::parse($dateOrDates)->endOfDay(),
            ]);
        }
        return $builder->exists();
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

    function getPostByDate(string $date): Collection
    {
        $builder = Post::query()->whereBetween('created_at', [
            Carbon::parse($date)->startOfDay(),
            Carbon::parse($date)->endOfDay(),
        ]);
        return $builder->get();
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
            $post->timeAgo = $this->utility->timeAgo($post->updated_at);
            // $post->transporter = trim(('('.($post->operator->department->short_name ?? 'NA').') '.$post->operator->prefix.' '.$post->operator->name.' '.$post->operator->postfix) ?? 'NA');
            $post->pendingCount = $this->utility->countWoPendingRequest($post);
            $post->desc = str_replace(';', ' ', $post->desc);
            return $post;
        });
    }

    function getPosts(): LengthAwarePaginator
    {
        $builder = Post::query()
            ->where('type', '=', PostTypeEnum::POST_WELL_TYPE->value)
            ->orderBy('created_at', 'desc')
            ->paginate();

        return $builder->through(function ($post){
            $post->timeAgo = $this->utility->timeAgo($post->updated_at);
            $post->pendingCount = $this->utility->countWtPendingRequest($post);
            $post->desc = str_replace(';', ' ', $post->desc);
            return $post;
        });
    }

    public function pagedPostByUserId(string $userId): LengthAwarePaginator
    {
        $builder = Post::query()
            ->where('title', '<>', Constants::EMPTY_STRING, 'and')
            ->where('user_id', '=', $userId, 'and')
            ->where('type', '=', PostTypeEnum::POST_WELL_TYPE->value)
            ->orderBy('created_at', 'desc')
            ->paginate();

        return $builder->through(function ($post){
            $post->timeAgo = $this->utility->timeAgo($post->updated_at);
            // $post->transporter = $this->utility->transporter($post->operator);
            $post->pendingCount = $this->utility->countWtPendingRequest($post);
            $post->desc = str_replace(';', ' ', $post->desc);
            return $post;
        });
    }

    function updatePost(array $request): ?Post
    {
        try {
            $model = Post::query()->find($request['id']);
            /*$model->title = $request['title'];
            $model->desc = $request['desc'];*/
            if(!$model->update($request)) return null;
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
