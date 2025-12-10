<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Letter Apps</title>
        <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg"/>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            .sidebar-collapsed {
                width: 5rem;
            }
            
            .sidebar-expanded {
                width: 16rem;
            }
            
            .content-collapsed {
                margin-left: 5rem;
            }
            
            .content-expanded {
                margin-left: 16rem;
            }
            
            .nav-text {
                opacity: 1;
                transition: opacity 0.2s;
            }
            
            .sidebar-collapsed .nav-text {
                opacity: 0;
                width: 0;
                overflow: hidden;
            }
            
            .sidebar-collapsed .nav-title {
                display: none;
            }
            
            .nav-item {
                position: relative;
            }
            
            .sidebar-collapsed .nav-item:hover .tooltip {
                opacity: 1;
                visibility: visible;
            }
            
            .tooltip {
                position: absolute;
                left: 100%;
                top: 50%;
                transform: translateY(-50%);
                margin-left: 0.5rem;
                padding: 0.5rem 1rem;
                background-color: #1f2937;
                color: white;
                border-radius: 0.5rem;
                white-space: nowrap;
                opacity: 0;
                visibility: hidden;
                transition: opacity 0.2s;
                z-index: 1000;
                font-size: 0.875rem;
            }
            
            .sidebar {
                transition: width 0.3s ease;
            }
            
            .main-content {
                transition: margin-left 0.3s ease;
            }
        </style>
    </head>
    <body class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
        <!-- Header - Fixed -->
        <header class="fixed top-0 left-0 right-0 bg-white shadow-md z-50 border-b border-gray-200">
            <div class="max-w-full mx-auto py-4 px-6 flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <!-- Toggle Sidebar Button -->
                    <button id="toggleSidebar" class="text-gray-600 hover:text-blue-600 focus:outline-none transition-colors p-2 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    
                    <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold flex items-center text-gray-800 hover:text-blue-600 transition-colors">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl mr-3 flex items-center justify-center shadow-lg">
                            <i class="fas fa-envelope text-white text-lg"></i>
                        </div>
                        <h1 class="bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">Letter Apps</h1>
                    </a>
                </div>
                
                @auth
                    <div class="flex items-center space-x-4">
                        <div class="hidden md:flex items-center space-x-3 px-4 py-2 bg-gray-50 rounded-lg">
                            <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center">
                                <span class="text-white font-semibold text-sm">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                            </div>
                            <span class="text-gray-700 font-medium">{{ Auth::user()->name }}</span>
                        </div>
                        <a href="{{ route('logout') }}" 
                           class="text-red-500 font-medium rounded-lg bg-white border-2 border-red-500 py-2 px-4 hover:bg-red-500 hover:text-white transition-all duration-200 flex items-center shadow-sm hover:shadow-md"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-right-from-bracket mr-2"></i> 
                            <span class="hidden sm:inline">Logout</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    </div>
                @endauth
            </div>
        </header>

        <main class="flex pt-20">
            <!-- Sidebar - Collapsible -->
            <nav id="sidebar" class="sidebar sidebar-expanded fixed left-0 top-20 h-[calc(100vh-5rem)] bg-white shadow-xl overflow-hidden z-40">
                <div class="h-full flex flex-col">
                    <!-- Navigation Title -->
                    <div class="px-6 py-6 border-b border-gray-200 nav-title">
                        <h2 class="text-sm font-bold text-gray-500 uppercase tracking-wider">Menu</h2>
                    </div>
                    
                    <!-- Navigation Items -->
                    <ul class="flex-1 space-y-1 px-3 py-4 overflow-y-auto overflow-x-hidden ">
                        <li class="nav-item">
                            <a id="dashboard" href="{{ route('admin.dashboard') }}" 
                               class="flex items-center px-4 py-3 text-gray-700 rounded-xl hover:bg-gradient-to-r hover:from-blue-50 hover:to-blue-100 hover:text-blue-600 font-medium transition-all duration-200 group relative {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-blue-50 to-blue-100 text-blue-600 shadow-sm' : '' }}">
                                <i class="fas fa-chart-pie text-xl w-6 group-hover:text-blue-600 {{ request()->routeIs('admin.dashboard') ? 'text-blue-600' : 'text-gray-400' }}"></i>
                                <span class="nav-text ml-4">Dashboard</span>
                                <span class="tooltip">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a id="users" href="{{ route('admin.users') }}" 
                               class="flex items-center px-4 py-3 text-gray-700 rounded-xl hover:bg-gradient-to-r hover:from-blue-50 hover:to-blue-100 hover:text-blue-600 font-medium transition-all duration-200 group relative {{ request()->routeIs('admin.users') ? 'bg-gradient-to-r from-blue-50 to-blue-100 text-blue-600 shadow-sm' : '' }}">
                                <i class="fas fa-users text-xl w-6 group-hover:text-blue-600 {{ request()->routeIs('admin.users') ? 'text-blue-600' : 'text-gray-400' }}"></i>
                                <span class="nav-text ml-4">Users</span>
                                <span class="tooltip">Users</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a id="siswa" href="{{ route('admin.siswa') }}" 
                               class="flex items-center px-4 py-3 text-gray-700 rounded-xl hover:bg-gradient-to-r hover:from-blue-50 hover:to-blue-100 hover:text-blue-600 font-medium transition-all duration-200 group relative {{ request()->routeIs('admin.siswa') ? 'bg-gradient-to-r from-blue-50 to-blue-100 text-blue-600 shadow-sm' : '' }}">
                                <i class="fas fa-graduation-cap text-xl w-6 group-hover:text-blue-600 {{ request()->routeIs('admin.siswa') ? 'text-blue-600' : 'text-gray-400' }}"></i>
                                <span class="nav-text ml-4">Siswa</span>
                                <span class="tooltip">Siswa</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a id="school" href="{{ route('admin.school') }}" 
                               class="flex items-center px-4 py-3 text-gray-700 rounded-xl hover:bg-gradient-to-r hover:from-blue-50 hover:to-blue-100 hover:text-blue-600 font-medium transition-all duration-200 group relative {{ request()->routeIs('admin.school') ? 'bg-gradient-to-r from-blue-50 to-blue-100 text-blue-600 shadow-sm' : '' }}">
                                <i class="fas fa-school text-xl w-6 group-hover:text-blue-600 {{ request()->routeIs('admin.school') ? 'text-blue-600' : 'text-gray-400' }}"></i>
                                <span class="nav-text ml-4">Sekolah</span>
                                <span class="tooltip">Sekolah</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a id="surat" href="{{ route('admin.surats') }}" 
                               class="flex items-center px-4 py-3 text-gray-700 rounded-xl hover:bg-gradient-to-r hover:from-blue-50 hover:to-blue-100 hover:text-blue-600 font-medium transition-all duration-200 group relative {{ request()->routeIs('admin.surats') ? 'bg-gradient-to-r from-blue-50 to-blue-100 text-blue-600 shadow-sm' : '' }}">
                                <i class="fas fa-envelope text-xl w-6 group-hover:text-blue-600 {{ request()->routeIs('admin.surats') ? 'text-blue-600' : 'text-gray-400' }}"></i>
                                <span class="nav-text ml-4">Surat</span>
                                <span class="tooltip">Surat</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a id="ijasa" href="{{ route('admin.surat-masuk.index') }}" 
                               class="flex items-center px-4 py-3 text-gray-700 rounded-xl hover:bg-gradient-to-r hover:from-blue-50 hover:to-blue-100 hover:text-blue-600 font-medium transition-all duration-200 group relative {{ request()->routeIs('admin.surat-masuk') ? 'bg-gradient-to-r from-blue-50 to-blue-100 text-blue-600 shadow-sm' : '' }}">
                                <i class="fas fa-certificate text-xl w-6 group-hover:text-blue-600 {{ request()->routeIs('admin.surat-masuk') ? 'text-blue-600' : 'text-gray-400' }}"></i>
                                <span class="nav-text ml-4">Surat Masuk</span>
                                <span class="tooltip">Surat Masuk</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a id="ijasa" href="{{ route('admin.ijasah.index') }}" 
                               class="flex items-center px-4 py-3 text-gray-700 rounded-xl hover:bg-gradient-to-r hover:from-blue-50 hover:to-blue-100 hover:text-blue-600 font-medium transition-all duration-200 group relative {{ request()->routeIs('admin.ijasah') ? 'bg-gradient-to-r from-blue-50 to-blue-100 text-blue-600 shadow-sm' : '' }}">
                                <i class="fas fa-certificate text-xl w-6 group-hover:text-blue-600 {{ request()->routeIs('admin.ijasah') ? 'text-blue-600' : 'text-gray-400' }}"></i>
                                <span class="nav-text ml-4">Ijasah</span>
                                <span class="tooltip">Ijasah</span>
                            </a>
                        </li>
                    </ul>
                    
                    <!-- Settings at Bottom -->
                    <div class="border-t border-gray-200 p-3">
                        <a id="settings" href="{{ route('admin.settings') }}" 
                           class="nav-item flex items-center px-4 py-3 text-gray-700 rounded-xl hover:bg-gradient-to-r hover:from-blue-50 hover:to-blue-100 hover:text-blue-600 font-medium transition-all duration-200 group relative {{ request()->routeIs('admin.settings') ? 'bg-gradient-to-r from-blue-50 to-blue-100 text-blue-600 shadow-sm' : '' }}">
                            <i class="fas fa-cog text-xl w-6 group-hover:text-blue-600 {{ request()->routeIs('admin.settings') ? 'text-blue-600' : 'text-gray-400' }}"></i>
                            <span class="nav-text ml-4">Settings</span>
                            <span class="tooltip">Settings</span>
                        </a>
                    </div>
                </div>
            </nav>
            
            <!-- Page Content -->
            <div id="mainContent" class="main-content content-expanded flex-1 px-4 min-h-screen">
                <div class="py-6">
                    {{ $slot }}
                </div>
                
                <!-- Footer -->
                <footer class="bg-white rounded-xl shadow-sm py-6 text-center text-sm text-gray-600 mt-8">
                    <div class="max-w-7xl mx-auto px-6">
                        <p class="font-medium">© {{ date('Y') }} <span class="text-blue-600">Kotechi Apps</span>. All rights reserved.</p>
                    </div>
                </footer>
            </div>  
        </main>

        <script>
            // Sidebar Toggle Functionality
            document.addEventListener('DOMContentLoaded', function() {
                const sidebar = document.getElementById('sidebar');
                const mainContent = document.getElementById('mainContent');
                const toggleBtn = document.getElementById('toggleSidebar');
                
                // Check if there's a saved state in localStorage
                const sidebarState = localStorage.getItem('sidebarCollapsed');
                if (sidebarState === 'true') {
                    sidebar.classList.remove('sidebar-expanded');
                    sidebar.classList.add('sidebar-collapsed');
                    mainContent.classList.remove('content-expanded');
                    mainContent.classList.add('content-collapsed');
                }
                
                toggleBtn.addEventListener('click', function() {
                    sidebar.classList.toggle('sidebar-collapsed');
                    sidebar.classList.toggle('sidebar-expanded');
                    mainContent.classList.toggle('content-collapsed');
                    mainContent.classList.toggle('content-expanded');
                    
                    // Save state to localStorage
                    const isCollapsed = sidebar.classList.contains('sidebar-collapsed');
                    localStorage.setItem('sidebarCollapsed', isCollapsed);
                });

                // Initialize tables on page load
                document.querySelectorAll('.custom-table').forEach(table => {
                    new CustomTable(table.id, {
                        itemsPerPage: 10,
                        searchable: true,
                        sortable: true
                    });
                });

                // Konfirmasi delete
                $(document).on('click', '.btn-delete', function () {
                    const id = $(this).data('id');
                    Swal.fire({
                        title: 'Yakin ingin menghapus?',
                        text: 'Data ini tidak dapat dikembalikan!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById(`delete-form-${id}`).submit();
                        }
                    });
                });

                // Toast notifications
                @if(session('success'))
                    window.Toast.fire({ icon: 'success', title: "{{ session('success') }}" });
                @endif

                @if(session('error'))
                    window.Toast.fire({ icon: 'error', title: "{{ session('error') }}" });
                @endif
            });
        </script>
    </body>
</html>