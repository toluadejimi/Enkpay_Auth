@props([
'method' => 'POST',
'action' => '#',
'hasFiles' => false
])

<form method="{{ $method === 'GET' ? 'GET' : 'POST' }}"
      action="{{ $action }}" {!! $hasFiles ? 'enctype="multipart/form-data"' : '' !!} {{ $attributes }}
>
    @csrf

    @if (! in_array($method, ['GET', 'POST']))
        @method($method)
    @endif

    {{ $slot }}
</form>
