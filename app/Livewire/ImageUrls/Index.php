<?php

namespace App\Livewire\ImageUrls;

use App\Models\ImageUrl;
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
        $imageUrls = ImageUrl::paginate();

        return view('livewire.image-url.index', compact('imageUrls'))
            ->with('i', $this->getPage() * $imageUrls->perPage());
    }

    public function delete(ImageUrl $imageUrl)
    {
        $imageUrl->delete();

        return $this->redirectRoute('image-urls.index', navigate: true);
    }
}
