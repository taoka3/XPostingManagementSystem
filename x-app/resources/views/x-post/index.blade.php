@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
    <h2 class="text-lg font-semibold mb-6 flex items-center gap-2">
        <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 24 24">
            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.84 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
        </svg>
        新規投稿
    </h2>

    <form action="{{ route('x-post.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        <div>
            <label for="content" class="block text-sm font-medium text-slate-700 mb-2">投稿内容 (280文字以内)</label>
            <textarea
                name="content"
                id="content"
                rows="5"
                class="w-full p-4 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all resize-none"
                placeholder="今どうしてる？"
                required>{{ old('content') }}</textarea>
            <div id="char-count" class="text-xs text-slate-500 mt-1 text-right">0 / 280</div>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">画像 (最大4枚)</label>
            <div class="flex items-center justify-center w-full">
                <label for="images" class="flex flex-col items-center justify-center w-full h-32 border-2 border-slate-300 border-dashed rounded-xl cursor-pointer bg-slate-50 hover:bg-slate-100 transition-all">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <svg class="w-8 h-8 mb-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        <p class="mb-2 text-sm text-slate-500"><span class="font-semibold">クリックしてアップロード</span> またはドラッグ＆ドロップ</p>
                        <p class="text-xs text-slate-400">PNG, JPG, JPEG, WEBP (MAX. 5MB per file)</p>
                    </div>
                    <input id="images" name="images[]" type="file" multiple class="hidden" accept="image/*" />
                </label>
            </div>
            <div id="image-preview" class="grid grid-cols-4 gap-4 mt-4"></div>
        </div>

        <div>
            <label for="scheduled_at" class="block text-sm font-medium text-slate-700 mb-2">予約投稿日時 (空欄で即時投稿)</label>
            <input
                type="datetime-local"
                name="scheduled_at"
                id="scheduled_at"
                class="w-full p-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                value="{{ old('scheduled_at') }}">
        </div>

        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-xl transition-all transform active:scale-95">
            投稿する
        </button>
    </form>
</div>

<script>
    const content = document.getElementById('content');
    const charCount = document.getElementById('char-count');
    const images = document.getElementById('images');
    const imagePreview = document.getElementById('image-preview');

    content.addEventListener('input', () => {
        const length = content.value.length;
        charCount.innerText = `${length} / 280`;
        if (length > 280) {
            charCount.classList.add('text-red-500');
        } else {
            charCount.classList.remove('text-red-500');
        }
    });

    images.addEventListener('change', () => {
        imagePreview.innerHTML = '';
        const files = Array.from(images.files).slice(0, 4);
        files.forEach(file => {
            const reader = new FileReader();
            reader.onload = (e) => {
                const div = document.createElement('div');
                div.className = 'relative aspect-square rounded-lg overflow-hidden border border-slate-200';
                div.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
                imagePreview.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    });
</script>
@endsection