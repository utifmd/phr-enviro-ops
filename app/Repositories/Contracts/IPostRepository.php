<?php

namespace App\Repositories\Contracts;

use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface IPostRepository
{
    function generatePost(array $user, ?array $data): ?string;
    function arePostExistAt(string $date): bool;
    function arePostExistByAndArea(string $date, string $area): bool;
    function addPost(array $request): ?Post;
    function getPostById(string $postId): ?Post;
    function getPostByIdRaw(string $postId);
    // function getPostByUserId(string $userId): ?Post;
    function countLoadPostBy(?string $userId, ?string $status): int;
    function pagedPosts(?string $idsWellName): LengthAwarePaginator;
    function pagedPostByUserId(string $userId): LengthAwarePaginator;
    function updatePost(array $request): ?Post;
    function removePost(string $post_id): bool;

    function async(): void;
    function await(): void;
    function cancel(?int $toLevel): void;
}
