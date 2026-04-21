<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'PasarDigital') }} - Home</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            @apply text-[#2C3E50]; /* Warna teks gelap */
        }
        /* Custom styles untuk warna hijau */
        .bg-pasardigital-green { @apply bg-[#1D8267]; }
        .text-pasardigital-green { @apply text-[#1D8267]; }
        .border-pasardigital-green { @apply border-[#1D8267]; }
        .btn-green {
            @apply bg-[#1D8267] text-white px-6 py-2 rounded-lg font-medium hover:bg-[#15614F] transition-colors;
        }
    </style>
</head>
<body class="antialiased bg-gray-50">

    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4 py-3 flex items-center justify-between">
            <div class="flex items-center">
                <img src="{{ asset('images/logo.png') }}" alt="PasarDigital Logo" class="h-8 mr-2">
                <span class="text-2xl font-bold text-pasardigital-green">PasarDigital</span>
            </div>

            <div class="flex-1 px-12 max-w-xl">
                <div class="relative">
                    <input type="text" placeholder="Temukan produk favoritmu" class="w-full border border-gray-300 rounded-full py-2 px-4 focus:ring-1 focus:ring-pasardigital-green focus:border-pasardigital-green">
                    <button class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-pasardigital-green">
                        <i class="fas fa-search"></i> </button>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <a href="#" class="text-pasardigital-green text-xl"><i class="fas fa-heart"></i></a>
                <div class="relative">
                    <a href="#" class="text-pasardigital-green text-xl"><i class="fas fa-shopping-cart"></i></a>
                    <span class="absolute -top-2 -right-3 bg-red-500 text-white text-[10px] font-bold rounded-full w-5 h-5 flex items-center justify-center">3</span>
                </div>
                <button class="btn-green">Masuk/Daftar</button>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="bg-gray-100 mt-12 py-8 border-t border-gray-200">
        <div class="container mx-auto px-4 text-center text-gray-600">
            <p>&copy; {{ date('Y') }} PasarDigital Indonesia. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://kit.fontawesome.com/your-kit-id.js" crossorigin="anonymous"></script>
</body>
</html>