<?php

namespace App\Livewire\PostWo;

use App\Models\Post;
use App\Repositories\Contracts\IDBRepository;
use App\Utils\PostTypeEnum;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected IDBRepository $dbRepos;

    #[Layout('layouts.app')]
    public function render(): View
    {
        $posts = Post::query()
            ->where('type', '=', PostTypeEnum::POST_WO_TYPE->value)->paginate();

        return view('livewire.workorders.index', compact('posts'))
            ->with('i', $this->getPage() * $posts->perPage());
    }

    public function booted(IDBRepository $dbRepos): void
    {
        $this->dbRepos = $dbRepos;
    }

    public function delete(Post $post): void
    {
        try {
            unlink(public_path($post->imageUrl->path));

        } catch (\Throwable $throwable){
            Log::error($throwable->getMessage());

        } finally {
            $post->delete();
        }
        $this->redirectRoute('workorders.index', navigate: true);
    }
}
