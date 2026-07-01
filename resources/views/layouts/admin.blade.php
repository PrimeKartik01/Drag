<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body>
    <div class="app-shell">

        {{-- ── SIDEBAR OVERLAY ── --}}
        <div class="sidebar-overlay" onclick="toggleSidebar()"></div>

        {{-- ── SIDEBAR ── --}}
        <aside class="sidebar admin-core-ui">
            <div class="sidebar-header">
                <div class="sidebar-logo">
                    <x-icons.logo width="14" height="14" stroke="#fafafa" stroke-width="2.5" />
                </div>
                <div>
                    <div class="sidebar-brand-name">OIU</div>
                </div>
            </div>

            <div class="sidebar-content">
                <div class="nav-group-label">Overview</div>

                <a href="{{ route('admin.dashboard') }}"
                    class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <x-icons.home stroke-width="2" />
                    Dashboard
                </a>

                <div class="nav-sep"></div>
                <div class="nav-group-label">Manage</div>
                <a href="{{ route('subuser.index') }}"
                    class="nav-item {{ request()->routeIs('subuser.*') ? 'active' : '' }}">
                    <x-icons.users stroke-width="2" />
                    SubUser
                </a>

                <a href="{{ route('role.index') }}" class="nav-item {{ request()->routeIs('role.*') ? 'active' : '' }}">
                    <x-icons.user-shield stroke-width="2" />
                    Roles
                </a>

                <a href="{{ route('builder.index') }}"
                    class="nav-item {{ request()->routeIs('builder.*') ? 'active' : '' }}">
                    <x-icons.builder stroke-width="2" />
                    Builder
                </a>

                <a href="{{ route('township.index') }}"
                    class="nav-item {{ request()->routeIs('townships.*') ? 'active' : '' }}">
                    <x-icons.township stroke-width="2" />
                    Township
                </a>

            </div>

            <div class="sidebar-footer">
                <form action="{{ route('admin.logout') }}" method="POST" class="hidden" id="logout-form-sidebar">
                    @csrf
                </form>
                <div class="user-row" onclick="document.getElementById('logout-form-sidebar').submit();">
                    <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 2)) }}</div>
                    <div style="flex:1;min-width:0;">
                        <div class="user-name">{{ auth()->user()->name ?? 'Admin' }}</div>
                        <div class="user-email" style="color: #ef4444; font-weight: 500;">Click to Logout</div>
                    </div>
                    <x-icons.logout width="14" height="14" stroke="#ef4444" stroke-width="2"
                        style="flex-shrink:0" />
                </div>
            </div>
        </aside>

        {{-- ── MAIN ── --}}
        <div class="main-area">

            {{-- Topbar --}}
            <header class="topbar admin-core-ui">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <button class="icon-btn mobile-toggle" style="display: none;" onclick="toggleSidebar()">
                        <x-icons.menu stroke-width="2" />
                    </button>
                    <div class="breadcrumb">
                        @yield('breadcrumb')
                    </div>
                </div>
                <div class="topbar-right">
                    @yield('topbar-actions')

                    <form action="{{ route('admin.logout') }}" method="POST" style="margin: 0; padding: 0;">
                        @csrf
                        <button type="submit" class="btn btn-outline"
                            style="border-color:#fca5a5; color:#dc2626; margin-left:10px;">
                            <x-icons.logout stroke-width="2.5" />
                            <span class="hidden md:block">Logout</span>
                        </button>
                    </form>
                </div>
            </header>

            {{-- Flash --}}
            @if (session('success'))
                <div id="flash-message">
                    <div
                        style="width:20px;height:20px;border-radius:50%;background:#f0fdf4;border:1px solid #bbf7d0;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                        <x-icons.check width="10" height="10" stroke="#16a34a" stroke-width="3" />
                    </div>
                    <p style="font-size:13px;color:var(--foreground);flex:1;font-weight:500;">{{ session('success') }}
                    </p>
                    <button onclick="this.closest('#flash-message').remove()"
                        style="background:none;border:none;cursor:pointer;color:var(--muted-fg);display:flex;padding:0">
                        <x-icons.x width="14" height="14" stroke="currentColor" stroke-width="2" />
                    </button>
                </div>
            @endif

            @if (session('error'))
                <div id="flash-message">
                    <div
                        style="width:20px;height:20px;border-radius:50%;background:#fff1f2;border:1px solid #fecdd3;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                        <x-icons.x width="10" height="10" stroke="#dc2626" stroke-width="3" />
                    </div>
                    <p style="font-size:13px;color:var(--foreground);flex:1;font-weight:500;">{{ session('error') }}
                    </p>
                    <button onclick="this.closest('#flash-message').remove()"
                        style="background:none;border:none;cursor:pointer;color:var(--muted-fg);display:flex;padding:0">
                        <x-icons.x width="14" height="14" stroke="currentColor" stroke-width="2" />
                    </button>
                </div>
            @endif

            {{-- Content --}}
            <main class="page-content">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        setTimeout(() => {
            const f = document.getElementById('flash-message');
            if (f) {
                f.style.transition = 'opacity .3s, transform .3s';
                f.style.opacity = '0';
                f.style.transform = 'translateX(16px)';
                setTimeout(() => f.remove(), 300);
            }
        }, 4000);

        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('mobile-open');
            document.querySelector('.sidebar-overlay').classList.toggle('active');
        }
    </script>

    @stack('scripts')
</body>

</html>
