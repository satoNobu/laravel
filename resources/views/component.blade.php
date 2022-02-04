@php
  $msg="aaaa";
@endphp
component

<x-alert type="error" :msg="$msg" alert-type="danger" class="mt-4">

  <p>****************</p>
  <p>スロットに表示する内容</p>
  <p>****************</p>
  <x-slot name="title">
    スロットのタイトル
  </x-slot>
  <x-slot name="type">
    {{ $component->type }}
  </x-slot>
</x-alert>
<x-forms.input/>
{{-- <x-package-alert/> --}}
{{-- <x-package-input/> --}}

<p>-------</p>
<x-test>
  あわわわ
</x-test>
{{-- <x-nightshade::calendar/>
<x-nightshade::color-picker/> --}}