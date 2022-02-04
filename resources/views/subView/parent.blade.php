@php
    $name = "山田";
    $age = 19;
@endphp

<p>parent</p>


@include('subView.childOne')

@include('subView.childOne', ['ex' => 'aaaaa'])

{{-- @include('subView.childFour', ['ex' => 'aaaaa']) --}}

@includeIf('subView.childFour', ['ex' => 'aaaaa'])

@includeWhen(false, 'subView.childTwo', ['ex' => 'aaaaa'])
@includeWhen(true, 'subView.childThree', ['ex' => 'aaaaa'])

<p>-----------</p>
@includeFirst(['subView.childFive','subView.childOne','subView.childSix'])