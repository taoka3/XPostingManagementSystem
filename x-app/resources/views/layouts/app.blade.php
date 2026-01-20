<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>X Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-900">
    <div class="min-h-screen flex flex-col">
        <header class="bg-white border-b border-slate-200 sticky top-0 z-10">
            <div class="max-w-4xl mx-auto px-4 h-16 flex items-center justify-between">
                <h1 class="text-xl font-bold text-slate-800">X Dashboard</h1>
                <nav class="flex items-center gap-6">
                    @auth
                    <div class="flex gap-4">
                        <a href="{{ route('x-post.index') }}" class="text-sm font-medium hover:text-blue-600 @if(Route::is('x-post.index')) text-blue-600 @endif">投稿</a>
                        <a href="{{ route('x-post.scheduled') }}" class="text-sm font-medium hover:text-blue-600 @if(Route::is('x-post.scheduled')) text-blue-600 @endif">予約一覧</a>
                    </div>
                    <div class="h-6 w-px bg-slate-200"></div>
                    <div class="flex items-center gap-4">
                        <span class="text-sm text-slate-600 font-medium">{{ Auth::user()->name }}</span>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-sm font-medium text-slate-500 hover:text-red-600 transition-all">ログアウト</button>
                        </form>
                    </div>
                    @else
                    <div class="flex gap-4">
                        <a href="{{ route('login') }}" class="text-sm font-medium text-slate-600 hover:text-blue-600">ログイン</a>
                    </div>
                    @endauth
                </nav>
            </div>
        </header>

        <main class="flex-grow py-8">
            <div class="max-w-4xl mx-auto px-4">
                @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
                @endif
                @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
                    {{ session('error') }}
                </div>
                @endif
                @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @yield('content')
            </div>
        </main>

        <footer class="py-6 border-t border-slate-200 bg-white mt-auto">
            <div class="max-w-4xl mx-auto px-4 text-center text-sm text-slate-500">
                &copy; {{ date('Y') }} X Dashboard
            </div>
        </footer>
    </div>
</body>

</html>