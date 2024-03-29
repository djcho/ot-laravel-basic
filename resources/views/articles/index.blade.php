<!DOCTYPE html>
<html>
    <head>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="container p-5">
            <h1 class="text-2xl mb-5">글목록</h1>
            @foreach($articles as $article)
                <div class="bg-white border rounded mb-4 p-3">
                    <p>{{$article->body}}</p>
                    <p>{{$article->user->name}}</p>
                    <p><a href="{{route('articles.show', ['article' => $article->id])}}">{{$article->created_at->diffForHumans()}}</a></p>
                    <div class="flex flex-row">
                        <p class="mr-1"><a
                            href="{{route('articles.edit', ['article' => $article->id])}}"
                            class="button rounded bg-blue-500 px-2 py-1 text-xs text-white"
                            >
                            수정</a>
                        </p>
                        <form action="{{route('articles.delete', ['article' => $article->id])}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="py-1 px-3 bg-red-500 text-white rounded text-xs">삭제</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- <ul>
            @for($i=0; $i < $totalCount/$perPage; $i++)
            <li><a href="/articles?page={{$i+1}}&per_page={{$perPage}}">{{$i+1}}</a></li>
            @endfor
        </ul> --}}

        <div class="container p-5">
            {{ $articles->links() }}
        </div>
    </body>
</html>
