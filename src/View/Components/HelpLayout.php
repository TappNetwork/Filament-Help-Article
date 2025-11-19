<?php

namespace Tapp\FilamentHelp\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class HelpLayout extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?string $title = null
    ) {
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('filament-help::layouts.help');
    }
}

