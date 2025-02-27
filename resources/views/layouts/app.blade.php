<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" xmlns:livewire="http://www.w3.org/1999/html">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">

    @can(\App\Policies\UserPolicy::IS_NOT_GUEST_ROLE)
        <livewire:layout.sidebar />
    @endcan
    <div class="min-h-screen sm:ml-64 bg-gray-100">

        @can(\App\Policies\UserPolicy::IS_NOT_GUEST_ROLE)
            <livewire:layout.topbar />
        @endcan
            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    <!-- Listener Alpine.js -->
        <script>
            document.addEventListener('scroll-to-section', (event) => {
                const id = event.detail.id;
                const element = document.getElementById(id);
                if (element) {
                    element.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start',
                    });
                }
            });
            document.addEventListener('scroll-to-top', () => {
                console.log('scroll-to-top')
                window.scrollTo({
                    'behavior': 'smooth', top: 0
                })
            });
            document.addEventListener('scroll-to-bottom', () => {
                console.log('scroll-to-top')
                window.scrollTo({
                    'behavior': 'smooth', top: document.body.scrollHeight
                })
            });
        </script>
    </body>
</html>
