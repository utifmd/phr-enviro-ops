<?php

namespace App\Livewire\Workorders;

use App\Models\Post;
use App\Utils\PostTypeEnum;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    #[Layout('layouts.app')]
    public function render(): View
    {
        $posts = Post::query()->where('type', '=', PostTypeEnum::POST_WO_TYPE->value)->paginate();

        return view('livewire.workorders.index', compact('posts'))
            ->with('i', $this->getPage() * $posts->perPage());
    }

    public function delete(Post $post): void
    {
        $post->delete();

        $this->redirectRoute('workorders.index', navigate: true);
    }
}
