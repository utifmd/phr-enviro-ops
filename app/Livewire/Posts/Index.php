<?php

namespace App\Livewire\Posts;

use App\Models\Post;
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
        $posts = Post::paginate();

        return view('livewire.post.index', compact('posts'))
            ->with('i', $this->getPage() * $posts->perPage());
    }

    public function delete(Post $post): void
    {
        $post->delete();

        $this->redirectRoute('posts.index', navigate: true);
    }
}
