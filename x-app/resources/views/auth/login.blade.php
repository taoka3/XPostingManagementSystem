@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded-2xl shadow-sm border border-slate-200">
    <h2 class="text-2xl font-bold mb-6 text-center text-slate-800">ログイン</h2>

    <form action="{{ route('login') }}" method="POST" class="space-y-6">
        @csrf
        <div>
            <label for="email" class="block text-sm font-medium text-slate-700 mb-2">メールアドレス</label>
            <input
                type="email"
                name="email"
                id="email"
                class="w-full p-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                value="{{ old('email') }}"
                required
                autofocus>
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-slate-700 mb-2">パスワード</label>
            <input
                type="password"
                name="password"
                id="password"
                class="w-full p-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                required>
        </div>

        <div class="flex items-center">
            <input type="checkbox" name="remember" id="remember" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
            <label for="remember" class="ml-2 text-sm text-slate-600">ログイン状態を保持する</label>
        </div>

        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-xl transition-all transform active:scale-95">
            ログイン
        </button>
    </form>

</div>
@endsection