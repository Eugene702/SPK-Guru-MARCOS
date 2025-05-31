<?php

namespace App\View\Components\Teacher\Assessment;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AlreadyGradedTable extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public $gurus
    ){}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.teacher.assessment.already-graded-table');
    }
}
