{{-- <script>
  var jsValue = "def"
  window.onload = function(){
    // ページ読み込み時に実行したい処理
    jsValue = {{ Js::from($js_value) }};
  }
</script> --}}

<html>
    <body>
        <h1>Hello, {{ $last_name }}</h1>
        <h1>Hello, {{ $first_name }}</h1>
        <h1>Hello, @{{ name }}.</h1>
        {{-- @verbatim
          <div>JS, {{ jsValue }}.</div>
        @endverbatim --}}
        @isset($age)
          ageあり
        @endisset

        @empty($age)
          ageなし
        @endempty

        @if ($js_value)
          js_valueあり
        @else
          js_valueなし
        @endif
    </body>
</html>