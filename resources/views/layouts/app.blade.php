
 <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Gestion Athlètes')</title>

<!-- Tailwind CSS CDN (pour tester rapidement) -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<style>
    .sidebar {
        width: 250px;
        transition: all 0.3s;
    }
    .sidebar.collapsed {
        width: 80px;
    }
    .sidebar-link {
        transition: all 0.2s;
    }
    .sidebar-link:hover {
        background: rgba(59, 130, 246, 0.1);
        border-left: 4px solid #3b82f6;
    }
    .sidebar-link.active {
        background: rgba(59, 130, 246, 0.15);
        border-left: 4px solid #3b82f6;
        color: #3b82f6;
    }
</style>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar bg-white shadow-lg flex flex-col">
            <!-- Logo -->
            <div class="p-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h1 class="text-xl font-bold text-blue-600 sidebar-text">Sports Management</h1>
                    <button id="toggleSidebar" class="p-2 rounded-lg hover:bg-gray-100">
                        <i class="bi bi-list text-xl"></i>
                    </button>
                </div>
            </div>

<!-- Navigation -->
        <nav class="flex-1 overflow-y-auto p-4">
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('athletes.index') }}" 
                       class="sidebar-link flex items-center p-3 rounded-lg {{ request()->routeIs('athletes.*') ? 'active' : '' }}">
                        <i class="bi bi-person-badge text-xl"></i>
                        <span class="ml-3 sidebar-text">Athlètes</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('evenements.index') }}" 
                       class="sidebar-link flex items-center p-3 rounded-lg {{ request()->routeIs('evenements.*') ? 'active' : '' }}">
                        <i class="bi bi-calendar-event text-xl"></i>
                        <span class="ml-3 sidebar-text">Événements</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('encadrants.index') }}" 
                       class="sidebar-link flex items-center p-3 rounded-lg {{ request()->routeIs('encadrants.*') ? 'active' : '' }}">
                        <i class="bi bi-people text-xl"></i>
                        <span class="ml-3 sidebar-text">Encadrants</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('associations.index') }}" 
                       class="sidebar-link flex items-center p-3 rounded-lg {{ request()->routeIs('associations.*') ? 'active' : '' }}">
                        <i class="bi bi-building text-xl"></i>
                        <span class="ml-3 sidebar-text">Associations</span>
                    </a>
                </li>

                <li class="mt-auto">
                    <a href="{{ route('parametres.index') }}" 
                       class="sidebar-link flex items-center p-3 rounded-lg {{ request()->routeIs('parametres.*') ? 'active' : '' }}">
                        <i class="bi bi-gear text-xl"></i>
                        <span class="ml-3 sidebar-text">Paramètres</span>
                    </a>
                </li>
            </ul>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Header -->
        <header class="bg-white shadow-sm border-b border-gray-200">
            <div class="flex items-center justify-between px-6 py-4">
                <div>
                    <h2 class="text-2xl font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h2>
                    <p class="text-sm text-gray-500">@yield('page-description', '')</p>
                </div>
                <div class="flex items-center space-x-4">
                    <button class="p-2 rounded-lg hover:bg-gray-100">
                        <i class="bi bi-bell text-xl text-gray-600"></i>
                    </button>
                    <div class="flex items-center space-x-2">
                        <img src="https://ui-avatars.com/api/?name=Admin&background=3b82f6&color=fff" 
                             alt="Avatar" class="w-10 h-10 rounded-full">
                        <span class="text-sm font-medium">Admin</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="flex-1 overflow-y-auto p-6">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg flex items-center">
                    <i class="bi bi-check-circle-fill mr-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    <i class="bi bi-exclamation-triangle-fill mr-2"></i>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

<script>
    document.getElementById('toggleSidebar').addEventListener('click', function() {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('collapsed');
        
        const texts = document.querySelectorAll('.sidebar-text');
        texts.forEach(text => {
            text.style.display = sidebar.classList.contains('collapsed') ? 'none' : 'inline';
        });
    });
</script>
</body>
</html>