@php
$routeName = explode(
    '.',
    request()
        ->route()
        ->getName(),
)[0];
@endphp

<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SB {{ auth()->user()->role->name }} <sup>2</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item @if ($routeName === 'dashboard') active @endif">
        <a class="nav-link" href="{{ url('/') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Menu
    </div>

    @foreach ($menus as $menu)
        <!-- Nav Item - {{ Str::ucfirst($menu->name) }} -->
        <li class="nav-item @if ($routeName === $menu->slug) active @endif">
            <a class="nav-link" href="{{ url($menu->route) }}">
                <i class="fas fa-fw fa-{{ $menu->icon }}"></i>
                @php
                    $names = explode(' ', $menu->name);
                    
                    foreach ($names as $key => $name) {
                        $names[$key] = Str::ucfirst($name);
                    }
                    
                    $name = join(' ', $names);
                @endphp
                <span>{{ $name }}</span>
            </a>
        </li>
    @endforeach

    <!-- Divider -->
    <hr class="sidebar-divider">

</ul>
<!-- End of Sidebar -->
