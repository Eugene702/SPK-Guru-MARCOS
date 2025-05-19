<?php

namespace App\View\Components\Admin\TeacherData;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TableData extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public $gurus,
        public $opsiKelas,
        public $mataPelajarans
    ){}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.teacher-data.table-data');
    }
}
