<?php

namespace App\Livewire\Posts;

use App\Livewire\Actions\GetStep;
use App\Livewire\Forms\PostForm;
use App\Models\Information;
use App\Models\Order;
use App\Models\Post;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Show extends Component
{
    public PostForm $postForm;
    public Information $information;
    public Order $order;
    public Collection $tripPlans;

    public string $userId;
    public string $generatedWoNumber;

    public function __construct()
    {
        $user = auth()->user();
        $this->userId = $user->getAuthIdentifier();
    }
    public function mount(Post $post): void
    {
        $this->postForm->setPostModel($post);
        $this->information = $post->information;
        $this->order = $post->ordersDetail;
        $this->tripPlans = $post->tripPlans;
        $this->generatedWoNumber = $post->title;
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        return view('livewire.post.show');
    }
}
