<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Darzi Pro</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,600;9..144,700&family=Inter:wght@400;500;600&display=swap"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style type="text/tailwindcss">
        @theme {
            --font-display: 'Fraunces', serif;
            --font-sans: 'Inter', sans-serif;
            --color-thread-teal: #0F5C56;
            --color-thread-teal-dark: #0A3F3B;
            --color-thread-gold: #C08829;
            --color-cloth: #FAF7F0;
        }

        body {
            font-family: var(--font-sans);
        }

        .font-display {
            font-family: var(--font-display);
        }

        .stitch-line {
            background-image: repeating-linear-gradient(90deg, currentColor 0, currentColor 6px, transparent 6px, transparent 12px);
            height: 2px;
            opacity: .5;
        }
    </style>
</head>

<body class="bg-[var(--color-thread-teal-dark)] min-h-screen flex items-center justify-center px-4">

    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <div
                class="w-14 h-14 rounded-xl bg-[var(--color-thread-gold)] mx-auto flex items-center justify-center font-display text-2xl font-bold text-[var(--color-thread-teal-dark)] mb-4">
                D</div>
            <h1 class="font-display text-2xl font-semibold text-white">Darzi Pro</h1>
            <p class="text-white/50 text-sm mt-1 tracking-wide">Tailor Shop Management — KPK Edition</p>
        </div>

        <div class="bg-[var(--color-cloth)] rounded-2xl shadow-2xl p-8">
            <!-- Session Messages (Replace your existing if/else block with this) -->
            @if (session('error'))
                <div
                    class="mb-5 px-4 py-3 rounded-lg bg-red-100 text-red-700 text-sm border border-red-200 flex items-center shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if (session('success'))
                <div
                    class="mb-5 px-4 py-3 rounded-lg bg-emerald-50 text-emerald-700 text-sm border border-emerald-200 flex items-center shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="mb-5 px-4 py-3 rounded-lg bg-red-50 text-red-700 text-sm ring-1 ring-red-200 shadow-sm">
                    <ul class="list-disc ml-4">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="text-[var(--color-thread-teal)] stitch-line mb-6 w-12"></div>
            <h2 class="font-display text-xl font-semibold text-[#1C2321] mb-1">Sign in to your dukan</h2>
            <p class="text-sm text-black/45 mb-6">Apna admin ya staff account use karain</p>

            <form method="POST" action="{{ route('login.attempt') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-black/70 mb-1.5">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full px-3.5 py-2.5 rounded-lg border border-black/10 bg-white focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)] text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-black/70 mb-1.5">Password</label>
                    <input type="password" name="password" required
                        class="w-full px-3.5 py-2.5 rounded-lg border border-black/10 bg-white focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)] text-sm">
                </div>
                <label class="flex items-center gap-2 text-sm text-black/60">
                    <input type="checkbox" name="remember" class="rounded border-black/20">
                    Mujhe yaad rakhain
                </label>
                <button type="submit"
                    class="w-full py-2.5 rounded-lg bg-[var(--color-thread-teal)] text-white font-semibold text-sm hover:bg-[var(--color-thread-teal-dark)] transition-colors">
                    Sign In
                </button>
            </form>

            <p class="text-xs text-black/40 text-center mt-6">
                Demo: admin@darzipro.pk / password
            </p>
        </div>
    </div>
    <script>
        setTimeout(function() {
            let alerts = document.querySelectorAll('.bg-red-100, .bg-emerald-50, .bg-red-50');
            alerts.forEach(alert => alert.style.display = 'none');
        }, 5000); // 5000ms = 5 seconds
    </script>
</body>

</html>
