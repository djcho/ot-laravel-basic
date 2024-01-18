<html>
    <head>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="container p-5">
        <h1 class="text-2xl">글 수정</h1>
        <form action="{{route('articles.update', ['article' => $article->id])}}" method="POST" class="mt-3">
            @csrf
            @method('PATCH')
            <input type="text" name="body" class="block w-full mb-2 rounded" value="{{ old('body') ?? $article->body}}">
            @error('body')
                <p class="text-xs text-red-500 mb-3"> {{$message}} </p>
            @enderror
            <button class="py-1 px-3 bg-black text-white rounded text-xs">수정하기</button>
        </form>
        </div>
    </body>
</html>
