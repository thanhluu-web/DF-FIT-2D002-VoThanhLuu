{{-- @props(['columns','isSorted', 'sortBy', 'sortOrder', 'routeName']) --}}

@foreach ($columns as $field => $label)
@php
    $disable = '';
    $cursor = '';
    $style = '';
    $isCurrentSort = $sortBy === $field;

    $nextOrder = ($isCurrentSort && $sortOrder === 'asc') ? 'desc' : 'asc';
    $icon = '';

    if ($isSorted !== '' && $sortBy == $field) { 
        $icon = $sortOrder === 'asc' ? ' ▲' : ' ▼';
    }

    $href=route($routeName, ['sort_by' => $field, 'sort_order' => $nextOrder]);
    
    if(in_array($field,['stt','image','action'])){
        $disable = 'onclick="return false;"';
        $cursor = 'cursor-not-allowed';
        $href = '#';
        $style = 'pointer-events:none;';
    }

@endphp
<th>
    <a style="{{$style}}" 
    {!! $disable ?? '' !!}
    href="{{$href}}"
    class="text-dark"
    >
        {{ $label }}{!! $icon !!}
    </a>
</th>
@endforeach
