<!DOCTYPE html>
<html lang="ar" class="h-full bg-white" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>YWG</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>


    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.0/dist/cdn.min.js"></script>

</head>

<body class="h-full bg-white text-cyan-900">
    <div class="min-h-full">
        <nav class="bg-teal-500">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <div class="flex items-center">
                        <div class="shrink-0">
                            <img src="{{ asset('images/لقطة شاشة 2025-10-01 232153.png') }}" alt="شعار شركتك"
                                class="size-8 rounded-full" /> {{-- تم إضافة rounded-full هنا --}}
                        </div>
                        <div class="hidden md:block">
                            <div class="ml-10 flex items-baseline space-x-4">
                                <x-nav-link href="/beneficiary" :active="request()->is('beneficiary')">
                                    المستفيدون
                                </x-nav-link>
                                <x-nav-link href="/patient" :active="request()->is('patient')">
                                    المرضى
                                </x-nav-link>
                                <x-nav-link href="/doctor" :active="request()->is('doctor')">
                                    الأطباء
                                </x-nav-link>
                                <x-nav-link href="/appointments" :active="request()->is('appointments')">
                                    المواعيد
                                </x-nav-link>
                                <x-nav-link href="/examination" :active="request()->is('examination')">
                                    الفحوصات
                                </x-nav-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <header class="relative bg-teal-600">
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold tracking-tight text-white">{{ $heading }}</h1>
            </div>
        </header>

        <div class="flex">
            <aside class="w-48 bg-teal-600 text-white min-h-screen">
                <div class="p-4 text-lg font-bold border-b border-teal-500">
                    القائمة
                </div>
                <nav class="mt-4 space-y-2">
                    <div>
                        <button type="button" class="w-full text-right px-4 py-2 hover:bg-teal-500 font-semibold">
                            المستفيدون
                        </button>
                        <div class="ml-4 mt-1 space-y-1">
                            <a href="{{ route('beneficiary.list') }}"
                                class="{{ request()->is('beneficiary/list') ? 'bg-teal-700' : '' }} block px-4 py-2 rounded hover:bg-teal-500">
                                القائمة
                            </a>
                            <a href="/beneficiary/create"
                                class="{{ request()->is('beneficiary/create') ? 'bg-teal-700' : '' }} block px-4 py-2 rounded hover:bg-teal-500">
                                إضافة
                            </a>
                        </div>
                    </div>

                    <div>
                        <button type="button" class="w-full text-right px-4 py-2 hover:bg-teal-500 font-semibold">
                            المرضى
                        </button>
                        <div class="ml-4 mt-1 space-y-1">
                            <a href="{{ route('patient.list') }}"
                                class="{{ request()->is('patient/list') ? 'bg-teal-700' : '' }} block px-4 py-2 rounded hover:bg-teal-500">
                                القائمة
                            </a>
                            <a href="{{ route('patient.create') }}"
                                class="{{ request()->is('patient/create') ? 'bg-teal-700' : '' }} block px-4 py-2 rounded hover:bg-teal-500">
                                إضافة
                            </a>
                        </div>
                    </div>

                    <div>
                        <button type="button" class="w-full text-right px-4 py-2 hover:bg-teal-500 font-semibold">
                            الأطباء
                        </button>
                        <div class="ml-4 mt-1 space-y-1">
                            <a href="{{ route('doctor.list') }}"
                                class="{{ request()->is('doctor/list') ? 'bg-teal-700' : '' }} block px-4 py-2 rounded hover:bg-teal-500">
                                القائمة
                            </a>
                            <a href="/doctor/create"
                                class="{{ request()->is('doctor/create') ? 'bg-teal-700' : '' }} block px-4 py-2 rounded hover:bg-teal-500">
                                إضافة
                            </a>
                        </div>
                    </div>
                </nav>
            </aside>

            <div class="flex-1">
                <main>
                    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>

    </div>
</body>

</html>
