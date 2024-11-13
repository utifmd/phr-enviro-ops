<?php

namespace App\Livewire\Workorders;

use App\Exports\WorkOrderExport;
use App\Livewire\Actions\GetStep;
use App\Livewire\Actions\RemoveUserCurrentPost;
use App\Livewire\Forms\PostForm;
use App\Models\ImageUrl;
use App\Models\Information;
use App\Models\Order;
use App\Models\Post;
use App\Models\WorkOrder;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use Milon\Barcode\DNS2D;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/* TODO:
 * - populate these forms to show view
 * - print the data with qrcode
 * - create operator table relation with vehicle, and driver
 * */
class Show extends Component
{
    private DNS2D $codeGenerator;
    private RemoveUserCurrentPost $removeUserCurrentPost;

    public PostForm $postForm;
    public Information $information;
    public Order $order;
    public Collection $tripPlans;

    public ?string $userId = null;
    public string $postId;
    public string $generatedWoNumber;
    public string $qrBase64Data;
    public array $steps;
    public int $stepAt;
    public bool $disabled;

    public function __construct()
    {
        $user = auth()->user();
        $getStep = new GetStep($user);
        $this->removeUserCurrentPost = new RemoveUserCurrentPost();
        $this->codeGenerator = new DNS2D();
        if ($currentPost = $user->currentPost ?? false) {

            $this->userId = $user->getAuthIdentifier();
            $this->postId = $currentPost->post_id;
        }
        $this->steps = $getStep->getSteps();
        $this->stepAt = $getStep->getStepAt();
        $this->disabled = in_array(4, $this->steps) &&
            $this->stepAt != 4;
        $this->disabled = true;
    }

    public function mount(Post $post): void
    {
        $this->postForm->setPostModel($post);
        $this->information = $post->information;
        $this->order = $post->ordersDetail;
        $this->tripPlans = $post->tripPlans;

        $this->setQrCode($post->information->vehicle->plat);
    }

    private function setQrCode(string $platNumber): void
    {
        $this->generatedWoNumber = "VT-WO-". date('YmdHis');
            // str_pad($count, 3, 0, STR_PAD_LEFT);
        $this->qrBase64Data = $this->codeGenerator->getBarcodePNG(
            $this->generatedWoNumber, 'QRcode', 10, 10
        );
    }

    public function finish(): void
    {
        try {
            DB::beginTransaction();
            $this->removeUserCurrentPost->execute($this->userId);
            $posted = Post::query()->find($this->postId);
            $posted->title = $this->generatedWoNumber;
            $posted->description = $this->information->operator->name;
            $posted->save();

            $path = 'images/barcodes/'.$this->generatedWoNumber.'.png';
            $imageUrl = [
                'path' => $path,
                'url' => asset($path),
                'post_id' => $this->postId
            ];
            ImageUrl::query()->create($imageUrl);

            DB::commit();
        } catch (\Throwable $exception) {

            Log::error($exception->getMessage());
            DB::rollBack();
        }
        session()->flash(
            'message', 'Workorder successfully published.'
        );
        $this->redirectRoute(
            WorkOrder::ROUTE_NAME.'.index', navigate: true
        );
    }

    public function export(): BinaryFileResponse
    {
        $workOrderExport = new WorkOrderExport(
            $this->postForm->postModel,
            $this->generatedWoNumber,
            $this->qrBase64Data
        );
        $this->disabled = false;
        $filename = $this->generatedWoNumber.'.xlsx';
        return Excel::download($workOrderExport, $filename);
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        return view('livewire.workorders.show');
    }
}
