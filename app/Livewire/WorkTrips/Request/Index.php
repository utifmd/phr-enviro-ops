<?php

namespace App\Livewire\WorkTrips\Request;

use App\Models\Post;
use App\Repositories\Contracts\IPostRepository;
use App\Service\Contracts\IWellService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected IWellService $service;
    protected LengthAwarePaginator $posts;
    public string $date;

    public function boot(IWellService $service): void
    {
        $this->service = $service;
        $this->date = date('Y-m-d');
    }

    public function mount(): void
    {
        $this->iniPosts();
    }

    public function hydrate(): void
    {
        $this->iniPosts();
    }

    public function onDateChange(): void
    {
        $this->iniPosts();
    }

    public function delete(Post $post): void
    {
        $post->delete();

        $this->redirectRoute('work-trips.index', navigate: true);
    }

    private function iniPosts(): void
    {
        $this->posts = $this->service->pagedWellPostBy($this->date);
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
