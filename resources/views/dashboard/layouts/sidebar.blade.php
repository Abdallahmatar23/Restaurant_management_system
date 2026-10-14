@php
    $role = auth()->user()->role;

    // [العنوان، الأيقونة، اسم الـ route، الأدوار المسموحة]
    $menu = [
        ['Dashboard',     'bi-speedometer2',   'dashboard',          ['admin', 'waiter', 'cashier']],
        ['Kitchen View',  'bi-fire',           'kitchen.index',      ['admin', 'kitchen_staff']],
        ['Orders',        'bi-receipt',        'orders.index',       ['admin', 'waiter', 'cashier']],
        ['Reservations',  'bi-calendar-check', 'reservations.index', ['admin', 'waiter']],
        ['Tables',        'bi-grid-3x3-gap',   'tables.index',       ['admin', 'waiter']],
        ['Billing',       'bi-cash-coin',      'billing.index',      ['admin', 'cashier']],
        ['Menu',          'bi-journal-text',   'sections.index',     ['admin']],
        ['Offers',        'bi-tags',           'offers.index',       ['admin']],
        ['Create User',   'bi-person-plus',    'users.create',       ['admin']],
        ['Reports',       'bi-bar-chart-line', 'reports.index',      ['admin']],
    ];
@endphp

<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="{{ route('dashboard') }}" class="brand-link">
            <span class="brand-text fw-light">{{ config('app.name') }}</span>
        </a>
    </div>

    <div class="sidebar-wrapper">
        <nav class="mt-2" aria-label="Main navigation">
            <ul class="nav sidebar-menu flex-column" role="menu" id="navigation">
                @foreach ($menu as [$title, $icon, $route, $roles])
                    @if (in_array($role, $roles) && Route::has($route))
                        <li class="nav-item">
                            <a href="{{ route($route) }}"
                               class="nav-link {{ request()->routeIs($route) ? 'active' : '' }}">
                                <i class="nav-icon bi {{ $icon }}"></i>
                                <p>{{ $title }}</p>
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </nav>
    </div>
</aside>
