<?php

namespace App\Livewire\WorkTrips\Request;

use App\Models\Post;
use App\Repositories\Contracts\IPostRepository;
use App\Service\Contracts\IWellService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected IWellService $service;
    protected LengthAwarePaginator $posts;

    public function boot(IWellService $service): void
    {
        $this->service = $service;
    }

    public function mount(): void
    {
        $this->posts = $this->service->pagedWellPost();
    }

    public function delete(Post $post): void
    {
        $post->delete();

        $this->redirectRoute('work-trips.index', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        $posts = $this->posts;

        return view('livewire.work-trip.request.index', compact('posts'))->with(
            'i', $this->getPage() * $posts->perPage()
        );
    }
}
