<?php

namespace App\Livewire\PostFacIn;

use App\Models\PostFac;
use App\Models\PostFacIn;
use App\Utils\ActNameEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
class Index extends Component
{
    use WithPagination;
    protected LengthAwarePaginator $detailsByArea;
    public string $date;

    public function mount(): void
    {
        $this->date = date('Y-m-d');
        $this->initWorkTripDetails();
    }

    public function hydrate(): void
    {
        $this->initWorkTripDetails();
    }

    private function initWorkTripDetails(): void
    {
        $this->detailsByArea = $this->detailsBuilderBy($this->date)->paginate();
    }
    private function detailsBuilderBy(?string $date = null): Builder
    {
        $builder = PostFac::query();

        if (!is_null($date)) {
            $builder->whereBetween('created_at', [
                Carbon::parse($date)->startOfDay(),
                Carbon::parse($date)->endOfDay(),
            ]);
        }
        $userAreaName = auth()->user()->area_name;
        return $builder
            ->where('type', ActNameEnum::Incoming->value)
            ->where('area_name', $userAreaName)
            ->orderByDesc('created_at');
    }
    public function onDateChange(): void
    {
        $this->initWorkTripDetails();
    }
    public function delete(PostFacIn $workTripDetail): void
    {
        $workTripDetail->delete();

        $this->redirectRoute('post-fac-in.index', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        $workTripDetails = $this->detailsByArea;

        return view('livewire.post-fac-in.index', compact('workTripDetails'))
            ->with('i', $this->getPage() * $workTripDetails->perPage());
    }
}
