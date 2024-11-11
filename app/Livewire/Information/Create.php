<?php

namespace App\Livewire\Information;

use App\Livewire\Actions\GetStep;
use App\Livewire\Actions\UpdateUserCurrentPost;
use App\Livewire\Forms\InformationForm;
use App\Models\Information;
use App\Models\Order;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Create extends Component
{
    private string $userId;

    public InformationForm $form;
    public string $postId;
    public array $steps;
    public int $stepAt;
    public bool $disabled;

    public function __construct()
    {
        $user = auth()->user();
        $this->userId = $user->getAuthIdentifier();
        $getStep = new GetStep($user);
        if ($currentPost = $user->currentPost ?? false){

            $this->postId = $currentPost->post_id;
        }
        $this->steps = $getStep->getSteps();
        $this->stepAt = $getStep->getStepAt();
        $this->disabled = in_array(Information::ROUTE_POS, $this->steps) &&
            $this->stepAt != Information::ROUTE_POS;
    }

    public function mount(Information $information): void
    {
        $build = Information::query()
            ->where('post_id', '=', $this->postId)
            ->get();

        $informationModel = $build->isNotEmpty()
            ? $build->first()
            : $information;

        $informationModel->post_id = $this->postId;
        $this->form->setInformationModel($informationModel);
    }

    public function save()
    {
        $this->form->store();

        return $this->redirectRoute('information.index', navigate: true);
    }

    public function addInformationThenNextToOrder(): void
    {
        $updateUserCurrentPost = new UpdateUserCurrentPost();

        $this->form->store();
        $userCurrentPost = [
            'steps' => '0;1;2',
            'step_at' => Order::ROUTE_POS,
            'url' => Order::ROUTE_NAME . '.create'
        ];
        $updateUserCurrentPost($this->userId, $userCurrentPost);
        session()->flash(
            'message', 'Information successfully submitted, please follow the next step!'
        );
        $this->redirectRoute($userCurrentPost['url'], navigate: true);
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        return view('livewire.information.create');
    }
}
