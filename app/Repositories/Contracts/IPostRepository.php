<?php

namespace App\Repositories\Contracts;

use App\Models\Post;
use Illuminate\Pagination\LengthAwarePaginator;

interface IPostRepository
{
    function addPost(array $request): ?Post;
    function getPostById(string $postId): ?Post;
    // function getPostByUserId(string $userId): ?Post;
    function countLoadPostBy(?string $userId, ?string $status): int;
    function pagedPosts(?string $idsWellName): LengthAwarePaginator;
    function pagedPostByUserId(string $userId): LengthAwarePaginator;
    function updatePost(string $post_id, array $request): ?Post;
    function removePost(string $post_id): bool;

    function async(): void;
    function await(): void;
    function cancel(?int $toLevel): void;
}
