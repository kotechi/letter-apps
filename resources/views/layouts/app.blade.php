<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Letter Apps</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <!-- Font Awesome untuk ikon -->
    <body class="min-h-screen bg-gray-50">
        <!-- Header - Fixed -->
        <header class="fixed top-0 left-0 right-0 bg-white shadow-sm z-50">
            <div class="max-w-full mx-auto py-4 px-6 flex items-center justify-between">
                <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold flex items-center text-gray-800 hover:text-blue-600 transition-colors">
                    <div class="w-10 h-10 bg-blue-600 rounded-lg mr-3 flex items-center justify-center">
                        <i class="fas fa-envelope text-white text-lg"></i>
                    </div>
                    <h1>Letter Apps</h1>
                </a>
                
                @auth
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-600">Welcome, {{ Auth::user()->name }}</span>
                        <a href="{{ route('logout') }}" class="text-red-500 font-medium rounded-lg bg-white border border-red-500 py-2 px-4 hover:bg-red-500 hover:text-white transition-all duration-200 flex items-center"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-right-from-bracket mr-2"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    </div>
                @endauth
            </div>
        </header>

        <main class="flex pt-20">
            <nav class="rounded-xl fixed left-0 top-20 w-64 h-[calc(100vh-5rem)] bg-white shadow-lg py-4 overflow-y-auto">
                <div class="px-6 mb-8 mt-2">
                    <h2 class="text-lg font-semibold text-gray-500 uppercase tracking-wider">Navigation</h2>
                </div>
                <ul class="space-y-2 px-4">
                    <li>
                        <a id="dashboard" href="{{ route('admin.dashboard') }}" 
                        class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 font-medium transition-all duration-200 group {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-600 border-r-2 border-blue-600' : '' }}">
                            <i class="fas fa-chart-pie mr-3 text-lg group-hover:text-blue-600 {{ request()->routeIs('admin.dashboard') ? 'text-blue-600' : 'text-gray-400' }}"></i>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a id="users" href="{{ route('admin.users') }}" 
                        class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 font-medium transition-all duration-200 group {{ request()->routeIs('admin.users') ? 'bg-blue-50 text-blue-600 border-r-2 border-blue-600' : '' }}">
                            <i class="fas fa-users mr-3 text-lg group-hover:text-blue-600 {{ request()->routeIs('admin.users') ? 'text-blue-600' : 'text-gray-400' }}"></i>
                            Users
                        </a>
                    </li>
                    <li>
                        <a id="siswa" href="{{ route('admin.siswa') }}" 
                        class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 font-medium transition-all duration-200 group {{ request()->routeIs('admin.siswa') ? 'bg-blue-50 text-blue-600 border-r-2 border-blue-600' : '' }}">
                            <i class="fas fa-graduation-cap mr-3 text-lg group-hover:text-blue-600 {{ request()->routeIs('admin.siswa') ? 'text-blue-600' : 'text-gray-400' }}"></i>
                            Siswa
                        </a>
                    </li>
                    <li>
                        <a id="school" href="{{ route('admin.school') }}" 
                        class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 font-medium transition-all duration-200 group {{ request()->routeIs('admin.school') ? 'bg-blue-50 text-blue-600 border-r-2 border-blue-600' : '' }}">
                            <i class="fas fa-school mr-3 text-lg group-hover:text-blue-600 {{ request()->routeIs('admin.school') ? 'text-blue-600' : 'text-gray-400' }}"></i>
                            Sekolah
                        </a>
                    </li>
                    <li>
                        <a id="settings" href="{{ route('admin.settings') }}" 
                        class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 font-medium transition-all duration-200 group {{ request()->routeIs('admin.settings') ? 'bg-blue-50 text-blue-600 border-r-2 border-blue-600' : '' }}">
                            <i class="fas fa-cog mr-3 text-lg group-hover:text-blue-600 {{ request()->routeIs('admin.settings') ? 'text-blue-600' : 'text-gray-400' }}"></i>
                            Settings
                        </a>
                    </li>
                </ul>
            </nav>
            
            <!-- Page Content - Scrollable dengan margin left untuk sidebar -->
            <div class="flex-1 ml-64 px-6 min-h-screen">
                <div class="py-6">
                    {{ $slot }}
                </div>
                
                <!-- Footer -->
                <footer class="bg-white py-4 text-center text-sm text-gray-600 mt-8">
                    <div class="max-w-7xl mx-auto px-6">
                        © {{ date('Y') }} Letter Apps. All rights reserved.
                    </div>
                </footer>
            </div>
        </main>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                
                // Konfirmasi delete pakai SweetAlert
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

                // Toast sukses/error
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

