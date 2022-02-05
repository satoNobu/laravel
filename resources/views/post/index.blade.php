<form method="post" action={{ route("post.store")}}>
  @csrf
  <input type="text" name="title" id="title" value="{{ old("title")}}">
  <input type="submit" value="クリック">
</form>

@if ($errors->any())
  {{-- {{ dd($errors) }} --}}
  <ul>
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
  </ul>
@endif

@error('title')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror