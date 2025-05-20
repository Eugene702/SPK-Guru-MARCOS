<?php

namespace App\View\Components\Admin\TeacherData;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CreateModal extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public $opsiKelas,
        public $mataPelajarans
    ){}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.teacher-data.create-modal');
    }
}
