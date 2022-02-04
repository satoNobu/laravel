<div>
    アラートだよ
</div>
<div class="alert alert-{{ $type }}">
    {{ $message }}
    <p>{{ $alertType }}</p>
</div>

<div {{ $attributes }}>
    <p>bbb</p>
</div>
<p>@@@@@@</p>
<span class="alert-title">{{ $title }}</span>
{{ $slot }}
{{ $type }}