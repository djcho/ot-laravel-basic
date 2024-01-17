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
                    <p>{{$article->created_at}}</p>
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
