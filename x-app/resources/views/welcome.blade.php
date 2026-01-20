<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>X Dashboard - 効率的なSNS運用を実現</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-white text-slate-900 overflow-x-hidden">
    <!-- Navbar -->
    <header class="fixed w-full bg-white/80 backdrop-blur-md z-50 border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.84 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                </svg>
                <span class="text-xl font-bold tracking-tight">X Dashboard</span>
            </div>
            <nav class="hidden md:flex items-center gap-8">
                @auth
                <a href="{{ route('x-post.index') }}" class="text-sm font-semibold text-slate-600 hover:text-blue-600 transition-colors">ダッシュボード</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-sm font-semibold text-slate-600 hover:text-red-600 transition-colors">ログアウト</button>
                </form>
                @else
                <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-600 hover:text-blue-600 transition-colors">ログイン</a>
                @endauth
            </nav>
        </div>
    </header>

    <main>
        <!-- Hero Section -->
        <section class="pt-32 pb-20 lg:pt-48 lg:pb-32 bg-gradient-to-b from-blue-50 to-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-4xl sm:text-6xl font-extrabold text-slate-900 tracking-tight mb-8">
                    X（Twitter）の運用を<br><span class="text-blue-600 italic">スマートに</span>加速させる。
                </h2>
                <p class="text-lg sm:text-xl text-slate-600 max-w-2xl mx-auto mb-12">
                    予約投稿、複数画像アップロード、運用履歴の管理など、<br class="hidden sm:block">
                    あなたのX運用を効率化するためのシンプルで強力なツールです。
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    @auth
                    <a href="{{ route('x-post.index') }}" class="w-full sm:w-auto px-8 py-4 bg-blue-600 text-white text-lg font-bold rounded-full hover:bg-blue-700 transition-all shadow-xl shadow-blue-200">ダッシュボードへ</a>
                    @else
                    <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-4 bg-white text-slate-900 text-lg font-bold rounded-full border border-slate-200 hover:bg-slate-50 transition-all">ログイン</a>
                    @endauth
                </div>
                <div class="mt-20 relative px-4">
                    <div class="max-w-5xl mx-auto bg-slate-100 rounded-2xl p-2 shadow-2xl">
                        <div class="bg-white rounded-xl shadow-inner aspect-[16/9] flex items-center justify-center overflow-hidden border border-slate-200">
                            <!-- Dashboard Preview Simulation -->
                            <div class="w-full h-full p-8 flex flex-col gap-6 text-left">
                                <div class="h-8 w-48 bg-slate-100 rounded-md"></div>
                                <div class="flex gap-4">
                                    <div class="flex-grow space-y-4">
                                        <div class="h-32 bg-slate-50 border border-slate-200 rounded-xl relative">
                                            <div class="absolute bottom-4 right-4 h-4 w-12 bg-slate-200 rounded"></div>
                                        </div>
                                        <div class="h-12 bg-blue-600 rounded-xl w-32 ml-auto"></div>
                                    </div>
                                    <div class="w-64 space-y-4 hidden md:block">
                                        <div class="h-12 bg-slate-50 rounded-xl"></div>
                                        <div class="h-12 bg-slate-50 rounded-xl"></div>
                                        <div class="h-12 bg-slate-50 rounded-xl"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features -->
        <section class="py-24 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid md:grid-cols-3 gap-12 text-center">
                    <div class="p-8 rounded-3xl bg-slate-50 border border-slate-100">
                        <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-4">予約投稿</h3>
                        <p class="text-slate-600">投稿時間に合わせてPCを叩く必要はありません。あなたの望む時間に自動でツイートします。</p>
                    </div>
                    <div class="p-8 rounded-3xl bg-slate-50 border border-slate-100">
                        <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-4">最大4枚の画像</h3>
                        <p class="text-slate-600">強力なビジュアル訴求を。最新のAPIを活用し、複数画像の投稿もスムーズに行えます。</p>
                    </div>
                    <div class="p-8 rounded-3xl bg-slate-50 border border-slate-100">
                        <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.040L3 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622l-.382-3.040z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-4">確かな運用</h3>
                        <p class="text-slate-600">管理画面から予約状況を一目で把握。不必要な手間を省き、戦略的な運用に集中。 </p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="py-12 border-t border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-2">
                <svg class="w-6 h-6 text-slate-400" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.84 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                </svg>
                <span class="text-lg font-bold text-slate-400">X Dashboard</span>
            </div>
            <p class="text-slate-400 text-sm">
                &copy; {{ date('Y') }} X Dashboard. All rights reserved.
            </p>
        </div>
    </footer>
</body>

</html>