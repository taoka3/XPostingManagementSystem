@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded-2xl shadow-sm border border-slate-200">
    <h2 class="text-2xl font-bold mb-6 text-center text-slate-800">新規会員登録</h2>

    <form action="{{ route('register') }}" method="POST" class="space-y-6">
        @csrf
        <div>
            <label for="name" class="block text-sm font-medium text-slate-700 mb-2">お名前</label>
            <input
                type="text"
                name="name"
                id="name"
                class="w-full p-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                value="{{ old('name') }}"
                required
                autofocus>
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-slate-700 mb-2">メールアドレス</label>
            <input
                type="email"
                name="email"
                id="email"
                class="w-full p-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                value="{{ old('email') }}"
                required>
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

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-2">パスワード（確認）</label>
            <input
                type="password"
                name="password_confirmation"
                id="password_confirmation"
                class="w-full p-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                required>
        </div>

        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-xl transition-all transform active:scale-95">
            登録する
        </button>
    </form>

    <div class="mt-6 text-center text-sm text-slate-500">
        すでにアカウントをお持ちですか？ <a href="{{ route('login') }}" class="text-blue-600 hover:underline">ログイン</a>
    </div>
</div>
@endsection