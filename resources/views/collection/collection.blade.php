@php
    $ary_numbers = [1,2,3,4,5,6,7,8,9,10];
    $ary_empty = [];
    $parent_value = '親から渡される値'
@endphp

@each('collection.show', $ary_numbers, 'number')

<p>---------</p>
@each('collection.show', $ary_empty, 'empty', 'collection.empty')