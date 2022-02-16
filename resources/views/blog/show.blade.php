@extends('layouts.index')

@section('content')

{{-- ！テストできない方法 --}}
{{-- @if (date('md') ====  '1225')
  <h2>メリークリスマス</h2>
@endif --}}

{{-- @if (today()->format('md') === '1225') --}}
@if (today()->is('12-25'))
  <h2>メリークリスマス</h2>
@endif

<h1>{{ $blog->title }}</h1>
<div>{!! nl2br(e($blog->body)) !!}</div>

<p>書き手：{{ $blog->user->name }}</p>

<h2>コメント一覧</h2>
@foreach ($blog->comments()->oldest()->get() as $comment)
  <hr>
  <p>{{ $comment->name }} ({{ $comment->created_at }})</p>
  <p>{!! nl2br(e($comment->body)) !!}</p>
@endforeach

@endsection