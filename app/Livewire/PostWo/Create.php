<?php

namespace App\Livewire\PostWo;

use App\Livewire\Actions\GetRouteName;
use App\Livewire\Actions\SetRouteName;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Create extends Component
{
    public ?string $userId = null;
    public ?string $postId = null;

    public function __construct()
    {
        $user = auth()->user();
        $this->userId = $user->getAuthIdentifier();

        if ($currentPost = $user->currentPost ?? false){
            $this->postId = $currentPost->post_id;
        }
    }

    private function createPostAndRouteNameThenGetNewUser(): User
    {
        $post = Post::factory()->create([
            'user_id' => $this->userId
        ]);
        $this->postId = $post->id;
        $setRouteName = new SetRouteName();
        $setRouteName($post->id, $this->userId);

        return User::query()->find($this->userId);
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        $currentUser = null;
        $message = null;
        try {
            DB::beginTransaction();
            if (is_null($this->postId)) {
                $currentUser = $this->createPostAndRouteNameThenGetNewUser();
                $message = 'Personal PostWoInfo successfully created, please follow the next step!';
            }
            if (is_null($this->postId)) {
                $message = 'Post of user '.$this->userId.' not found';
            }
            $routeName = new GetRouteName();
            $this->redirectRoute(

                $routeName($currentUser), ["post" => $this->postId], navigate: true
            );
            DB::commit();
        } catch (\Throwable $exception) {
            $message = $exception->getMessage();
            DB::rollBack();
        }
        if (!is_null($message)) session()->flash(
            'message', $message
        );
        return view('livewire.workorders.create');
    }
}
