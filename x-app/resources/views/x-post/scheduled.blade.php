@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
    <h2 class="text-lg font-semibold mb-6 flex items-center gap-2">
        <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        予約投稿一覧
    </h2>

    @if($posts->isEmpty())
    <div class="text-center py-12">
        <p class="text-slate-500">予約中の投稿はありません。</p>
        <a href="{{ route('x-post.index') }}" class="text-blue-600 hover:underline mt-2 inline-block">新規投稿を作成する</a>
    </div>
    @else
    <div class="space-y-4">
        @foreach($posts as $post)
        <div class="p-4 rounded-xl border border-slate-200 flex justify-between items-start gap-4 hover:bg-slate-50 transition-all">
            <div class="flex-grow">
                <div class="text-xs font-semibold text-blue-600 mb-1">
                    {{ $post->scheduled_at->format('Y/m/d H:i') }}予定
                </div>
                <p class="text-slate-800 line-clamp-3 mb-2">{{ $post->content }}</p>
                @if($post->images && count($post->images) > 0)
                <div class="flex gap-2">
                    @foreach($post->images as $image)
                    <div class="w-12 h-12 rounded border border-slate-200 overflow-hidden">
                        <img src="{{ Storage::url($image) }}" class="w-full h-full object-cover">
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
            <form action="{{ route('x-post.destroy', $post) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 hover:text-red-700 p-2 transition-all" onclick="return confirm('本当に削除しますか？')">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
            </form>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection