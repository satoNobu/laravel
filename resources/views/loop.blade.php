@foreach ( $str_ary as $ary )
  @if ($loop->first)
      最初の値{{ $ary }}
  @endif
  <br>
  {{ $ary }} : 現在のindex:{{ $loop->index }} 現在の反復数:{{ $loop->iteration }} ネストレベル：{{ $loop->depth }}
  <br>
  @if ($loop->last)
    最後の値{{ $ary }}
  @endif
@endforeach
