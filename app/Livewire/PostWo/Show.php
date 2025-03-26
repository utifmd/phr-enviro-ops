<?php

namespace App\Livewire\PostWo;

use App\Exports\WorkOrderExport;
use App\Livewire\Forms\PostForm;
use App\Models\Information;
use App\Models\PostWoPlanOrder;
use App\Models\Post;
use App\Models\PostWo;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class Show extends Component
{
    public PostForm $postForm;
    public Information $information;
    public PostWoPlanOrder $planOrder;
    public Collection $planTrips;

    public string $userId;
    public string $generatedWoNumber;
    public string $imagePath;

    public function __construct()
    {
        $user = auth()->user();
        $this->userId = $user->getAuthIdentifier();
    }
    public function mount(Post $post): void
    {
        $this->postForm->setPostModel($post);
        $this->information = $post->information;
        $this->planOrder = $post->planOrder;
        $this->planTrips = $post->planTrips;
        $this->generatedWoNumber = $post->title;
        $this->imagePath = $post->imageUrl->path;
    }

    public function export(): BinaryFileResponse
    {
        $workOrderExport = new WorkOrderExport(
            $this->postForm->postModel,
            $this->generatedWoNumber,
            $this->imagePath, true
        );
        $filename = $this->generatedWoNumber.'.xlsx';
        return Excel::download($workOrderExport, $filename);
    }
    #[Layout('layouts.app')]
    public function render(): View
    {
        return view('livewire.'.PostWo::ROUTE_NAME.'.show');
    }
}
