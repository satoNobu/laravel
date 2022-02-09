index
<div class="container">
  @foreach ($tests as $test)
    <p>{{ $test->id }}:{{ $test->name }}</p>
  @endforeach
</div>

{{ $tests->links() }}