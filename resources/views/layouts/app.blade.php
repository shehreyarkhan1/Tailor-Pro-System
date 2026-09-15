<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — {{ env('APP_NAME', 'Darzi Pro') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600;9..144,700&family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap"
        rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>

    <style type="text/tailwindcss">
        @theme {
            --font-display: 'Fraunces', serif;
            --font-sans: 'Inter', sans-serif;
            --font-mono: 'JetBrains Mono', monospace;

            --color-ink: #1C2321;
            --color-cloth: #FAF7F0;
            --color-cloth-dim: #F1ECE0;
            --color-thread-teal: #0F5C56;
            --color-thread-teal-dark: #0A3F3B;
            --color-thread-gold: #C08829;
            --color-thread-gold-light: #E8B65A;
            --color-terracotta: #B23A2E;
            --color-leaf: #2F7D52;
        }

        body {
            font-family: var(--font-sans);
            background-color: var(--color-cloth);
            color: var(--color-ink);
        }

        .font-display {
            font-family: var(--font-display);
        }

        .font-mono {
            font-family: var(--font-mono);
        }

        /* Stitched thread divider — the signature motif */
        .stitch-line {
            background-image: repeating-linear-gradient(90deg, currentColor 0, currentColor 6px, transparent 6px, transparent 12px);
            height: 2px;
            opacity: 0.35;
        }

        /* Tape-measure tick pattern for sidebar rail */
        .tape-ticks {
            background-image: repeating-linear-gradient(180deg, rgba(232, 182, 90, 0.35) 0px, rgba(232, 182, 90, 0.35) 1px, transparent 1px, transparent 8px);
        }

        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-thumb {
            background: #d8cfb8;
            border-radius: 8px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        [x-cloak] {
            display: none !important;
        }

        /* Toast notification blink/pulse ring — draws the eye when a toast lands */
        @keyframes pulse-ring-error {
            0% {
                box-shadow: 0 0 0 0 rgba(178, 58, 46, 0.45);
            }

            70% {
                box-shadow: 0 0 0 8px rgba(178, 58, 46, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(178, 58, 46, 0);
            }
        }

        @keyframes pulse-ring-success {
            0% {
                box-shadow: 0 0 0 0 rgba(47, 125, 82, 0.45);
            }

            70% {
                box-shadow: 0 0 0 8px rgba(47, 125, 82, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(47, 125, 82, 0);
            }
        }

        @keyframes shake-once {

            10%,
            90% {
                transform: translateX(-1px);
            }

            20%,
            80% {
                transform: translateX(2px);
            }

            30%,
            50%,
            70% {
                transform: translateX(-3px);
            }

            40%,
            60% {
                transform: translateX(3px);
            }
        }

        .toast-blink-error {
            animation: pulse-ring-error 1.4s ease-out 2;
        }

        .toast-blink-success {
            animation: pulse-ring-success 1.4s ease-out 2;
        }

        .toast-shake {
            animation: shake-once 0.5s ease-in-out;
        }
    </style>
</head>

<body class="antialiased">
    <div class="min-h-screen flex" x-data="{ mobileOpen: false }">

        <!-- Mobile backdrop: tap outside the sidebar to close it -->
        <div x-show="mobileOpen" x-cloak @click="mobileOpen = false"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-30 bg-black/40 lg:hidden"></div>

        <!-- Sidebar -->
        <aside
            class="fixed inset-y-0 left-0 z-40 w-64 h-screen bg-[var(--color-thread-teal-dark)] text-white flex flex-col transform transition-transform duration-200 -translate-x-full lg:translate-x-0"
            :class="mobileOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">

            <div class="relative px-6 py-6 border-b border-white/10">
                <div class="absolute left-0 top-0 bottom-0 w-1.5 tape-ticks"></div>
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 rounded-lg bg-[var(--color-thread-gold)] flex items-center justify-center font-display text-xl font-bold text-[var(--color-thread-teal-dark)]">
                        D</div>
                    <div>
                        <p class="font-display text-lg font-semibold leading-tight">Darzi Pro</p>
                        <p class="text-[11px] uppercase tracking-widest text-white/50">KPK Tailor Suite</p>
                    </div>
                </div>
            </div>

            <nav class="flex-1 px-3 py-6 space-y-1 overflow-y-auto">
                @php
                    $nav = [
                        [
                            'route' => 'dashboard',
                            'label' => 'Dashboard',
                            'icon' =>
                                'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
                        ],
                        [
                            'route' => 'customers.index',
                            'label' => 'Customers',
                            'icon' =>
                                'M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 10-4-4 4 4 0 004 4zm6 0a4 4 0 10-4-4',
                        ],
                        [
                            'route' => 'orders.index',
                            'label' => 'Orders',
                            'icon' =>
                                'M9 2a1 1 0 00-1 1v1H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2V3a1 1 0 00-1-1H9zM8 11h8M8 15h5',
                        ],
                        [
                            'route' => 'invoices.index',
                            'label' => 'Billing',
                            'icon' =>
                                'M12 8c-1.657 0-3 .672-3 1.5S10.343 11 12 11s3 .672 3 1.5-1.343 1.5-3 1.5m0-6c1.11 0 2.08.402 2.599 1M12 6v1.5m0 9V18',
                        ],
                        [
                            'route' => 'staff.index',
                            'label' => 'Staff / Karigar',
                            'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
                        ],
                        [
                            'route' => 'style-categories.index',
                            'label' => 'Style Options',
                            'icon' =>
                                'M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h10a2 2 0 002-2v-2a2 2 0 00-2-2H9M7 21V9a2 2 0 012-2h2',
                        ],
                        [
                            'route' => 'users.index',
                            'label' => 'Users',
                            'icon' =>
                                'M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h10a2 2 0 002-2v-2a2 2 0 00-2-2H9M7 21V9a2 2 0 012-2h2',
                        ],
                    ];
                @endphp

                @foreach ($nav as $item)
                    @php $active = request()->routeIs($item['route']) || request()->routeIs(str($item['route'])->before('.').'.*'); @endphp
                    @if (Route::has($item['route']))
                        <a href="{{ route($item['route']) }}" @click="mobileOpen = false"
                            class="group relative flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition-colors
                              {{ $active ? 'bg-white/10 text-white' : 'text-white/60 hover:text-white hover:bg-white/5' }}">
                            @if ($active)
                                <span
                                    class="absolute left-0 top-1.5 bottom-1.5 w-1 rounded-r bg-[var(--color-thread-gold)]"></span>
                            @endif
                            <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
                            </svg>
                            {{ $item['label'] }}
                        </a>
                    @endif
                @endforeach
            </nav>

            <div class="px-4 py-4 border-t border-white/10">
                @if (Route::has('logout'))
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button
                            class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium text-white/60 hover:text-white hover:bg-white/5 transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Logout
                        </button>
                    </form>
                @endif
            </div>
        </aside>

        <div class="flex-1 flex flex-col min-w-0 lg:ml-64">
            <!-- Topbar -->
            <header class="sticky top-0 z-30 bg-[var(--color-cloth)]/90 backdrop-blur border-b border-black/5">
                <div class="h-16 px-4 sm:px-8 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <button @click="mobileOpen = !mobileOpen" class="lg:hidden p-2 rounded-lg hover:bg-black/5">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                        <div>
                            <h1 class="font-display text-xl sm:text-2xl font-semibold text-[var(--color-ink)]">
                                @yield('title', 'Dashboard')</h1>
                            @hasSection('subtitle')
                                <p class="text-xs text-black/45 mt-0.5">@yield('subtitle')</p>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="hidden sm:flex flex-col items-end">
                            <span class="text-sm font-medium">{{ auth()->user()->name ?? 'Guest' }}</span>
                            <span
                                class="text-[11px] text-black/40 uppercase tracking-wide">{{ auth()->user()->role ?? '' }}</span>
                        </div>
                        <div
                            class="w-9 h-9 rounded-full bg-[var(--color-thread-teal)] text-white flex items-center justify-center font-semibold text-sm">
                            {{ strtoupper(substr(auth()->user()->name ?? 'G', 0, 1)) }}
                        </div>
                    </div>
                </div>
            </header>

            <!-- Flash messages -->
            <!-- Toast Notifications -->
            <div x-data="{
                toasts: [],
                add(type, message, duration = 4500) {
                    const id = Date.now() + Math.random();
                    const toast = { id, type, title: type === 'success' ? 'Success' : 'Error', message, duration, remaining: duration, timer: null, startTime: null, paused: false };
                    this.toasts.push(toast);
                    this.startTimer(toast);
                },
                startTimer(toast) {
                    toast.startTime = Date.now();
                    toast.timer = setTimeout(() => this.remove(toast.id), toast.remaining);
                },
                pause(toast) {
                    toast.paused = true;
                    clearTimeout(toast.timer);
                    toast.remaining -= (Date.now() - toast.startTime);
                },
                resume(toast) {
                    toast.paused = false;
                    this.startTimer(toast);
                },
                remove(id) {
                    this.toasts = this.toasts.filter(t => t.id !== id);
                }
            }" x-init="@if(session('success'))
            add('success', @js(session('success')));
            @endif
            @if($errors->any())
            add('error', @js($errors->first()));
            @endif"
                class="fixed top-4 right-4 z-[100] w-full max-w-sm space-y-3 pointer-events-none">
                <template x-for="toast in toasts" :key="toast.id">
                    <div @mouseenter="pause(toast)" @mouseleave="resume(toast)"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-x-6 scale-95"
                        x-transition:enter-end="opacity-100 translate-x-0 scale-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-x-0 scale-100"
                        x-transition:leave-end="opacity-0 translate-x-2 scale-95"
                        :class="toast.type === 'error' ? 'toast-shake' : ''"
                        class="pointer-events-auto relative flex overflow-hidden rounded-xl bg-white shadow-lg ring-1 ring-black/5">
                        <!-- Left accent bar: instant visual signal without reading the icon -->
                        <div class="w-1 shrink-0"
                            :class="toast.type === 'success' ? 'bg-[var(--color-leaf)]' : 'bg-[var(--color-terracotta)]'">
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="flex items-start gap-3 px-4 py-3.5">
                                <div class="mt-0.5 shrink-0 w-5 h-5 rounded-full flex items-center justify-center"
                                    :class="toast.type === 'success' ?
                                        'bg-[var(--color-leaf)]/15 text-[var(--color-leaf)] toast-blink-success' :
                                        'bg-[var(--color-terracotta)]/15 text-[var(--color-terracotta)] toast-blink-error'">
                                    <svg x-show="toast.type === 'success'" class="w-3 h-3" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <svg x-show="toast.type === 'error'" class="w-3 h-3" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </div>

                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-[var(--color-ink)]" x-text="toast.title"></p>
                                    <p class="text-sm text-black/55 leading-snug mt-0.5" x-text="toast.message"></p>
                                </div>

                                <button @click="remove(toast.id)"
                                    class="shrink-0 text-black/30 hover:text-black/60 transition-colors">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <!-- Progress bar: freezes at current width on hover, resumes from there (not a jarring restart) -->
                            <div class="h-0.5 w-full bg-black/5">
                                <div class="h-full w-full origin-left"
                                    :class="toast.type === 'success' ? 'bg-[var(--color-leaf)]' :
                                        'bg-[var(--color-terracotta)]'"
                                    x-effect="
                            if (toast.paused) {
                                const pct = ($el.offsetWidth / $el.parentElement.offsetWidth) * 100;
                                $el.style.transition = 'none';
                                $el.style.width = pct + '%';
                            } else {
                                requestAnimationFrame(() => {
                                    $el.style.transition = `width ${toast.remaining}ms linear`;
                                    $el.style.width = '0%';
                                });
                            }
                        ">
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <main class="flex-1 px-4 sm:px-8 pb-10">
                @yield('content')
            </main>
        </div>
    </div>
</body>

</html>
