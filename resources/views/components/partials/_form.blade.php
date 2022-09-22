@props(['action'])

<form class="row" action="{{ $action }}" method="post">
    {{ $method }}

    @csrf

    {{ $slot }}
</form>
