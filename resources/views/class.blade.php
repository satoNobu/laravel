{{-- tailwindの読み込み --}}
<link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
@php
    $isActive = true;
    $hasError = true;
@endphp

<span @class([
    'p-4',
    'font-bold' => $isActive,
    'text-gray-500' => ! $isActive,
    'bg-red' => $hasError,
])>class</span>

<span class="p-4 text-gray-500 bg-red">class</span>