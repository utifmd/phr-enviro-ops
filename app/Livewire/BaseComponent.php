<?php

namespace App\Livewire;

use Livewire\Component;

abstract class BaseComponent extends Component
{
    public function scrollToTop(): void
    {
        $this->dispatch('scroll-to-top');
    }

    public function scrollToBottom(): void
    {
        $this->dispatch('scroll-to-bottom');
    }

    public function scrollTo($elementId): void
    {
        // Set target element ID
        // $this->targetElement = $elementId;

        // Emit browser event to scroll
        $this->dispatch(
            'scroll-to-section', ['id' => $elementId]
        );
    }
}
