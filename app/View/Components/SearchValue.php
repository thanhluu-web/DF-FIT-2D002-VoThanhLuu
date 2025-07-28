<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SearchValue extends Component
{
    /**
     * Create a new component instance.
     */
    public $keyword;
    public $columns;
    public $searchColumn;
    public $routeName;

    public $dataSeached;

    public function __construct($keyword,$columns,$searchColumn,$routeName, $dataSeached)
    {
     
        $this -> keyword = $keyword;
        $this -> columns = $columns;
        $this -> searchColumn = $searchColumn;
        $this-> routeName = $routeName;
        $this -> dataSeached =$dataSeached;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.search-value');
    }
}
