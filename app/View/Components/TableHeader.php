<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TableHeader extends Component
{
    /**
     * Create a new component instance.
     */

    public $columns;
    public $sortBy;
    public $sortOrder;
    public $routeName;
    public $isSorted;


    public function __construct($columns = [], $isSorted = false, $sortBy = null, $sortOrder = null, $routeName = '')
    {
    
        $this->columns = $columns;
        $this->isSorted = $isSorted;
        $this->sortBy = $sortBy;
        $this->sortOrder = $sortOrder;
        $this->routeName = $routeName;

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.table-header');
    }
}
