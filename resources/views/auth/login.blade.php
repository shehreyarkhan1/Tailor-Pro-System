<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Darzi Pro</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,600;9..144,700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
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
        body { font-family: var(--font-sans); }
        .font-display { font-family: var(--font-display); }
        .stitch-line {
            background-image: repeating-linear-gradient(90deg, currentColor 0, currentColor 6px, transparent 6px, transparent 12px);
            height: 2px; opacity: .5;
        }
    </style>
</head>
<body class="bg-[var(--color-thread-teal-dark)] min-h-screen flex items-center justify-center px-4">

    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <div class="w-14 h-14 rounded-xl bg-[var(--color-thread-gold)] mx-auto flex items-center justify-center font-display text-2xl font-bold text-[var(--color-thread-teal-dark)] mb-4">D</div>
            <h1 class="font-display text-2xl font-semibold text-white">Darzi Pro</h1>
            <p class="text-white/50 text-sm mt-1 tracking-wide">Tailor Shop Management — KPK Edition</p>
        </div>

        <div class="bg-[var(--color-cloth)] rounded-2xl shadow-2xl p-8">
            <div class="text-[var(--color-thread-teal)] stitch-line mb-6 w-12"></div>
            <h2 class="font-display text-xl font-semibold text-[#1C2321] mb-1">Sign in to your dukan</h2>
            <p class="text-sm text-black/45 mb-6">Apna admin ya staff account use karain</p>

            @if($errors->any())
                <div class="mb-5 px-4 py-3 rounded-lg bg-red-50 text-red-700 text-sm ring-1 ring-red-200">
                    {{ $errors->first() }}
                </div>
            @endif

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
</body>
</html>
