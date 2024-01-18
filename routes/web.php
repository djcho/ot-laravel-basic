<?php

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/articles/create', function () {
    return view('articles/create');
})->name('articles.create');

Route::post('/articles', function(Request $request){
    //비어있지 않고, 문자열이고, 255자 제한
    $input = $request->validate([
        'body' =>[
            'required',
            'string',
            'max:255'
        ]
    ]);

    /* 기본 PHP를 이용한 방법
    $host = config('database.connections.mysql.host');
    $dbname = config('database.connections.mysql.database');
    $username = config('database.connections.mysql.username');
    $password = config('database.connections.mysql.password');

    //pdo(PHP Data Object)
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    //쿼리 준비
    $stmt = $conn->prepare("INSERT INTO articles (body, user_id) VALUES (:body, :userId)");

    //쿼리 값 설정
    $stmt->bindValue(':body', $input['body']) ;
    $stmt->bindValue(':userId', Auth::id());

    //실행
    $stmt->execute();
    */

    /* DB 파사드 이용하는 방법
    DB::insert("INSERT INTO articles (body, user_id) VALUES (:body, :userId)",
    [
        'body' => $input['body'],
        'userId' => Auth::id()
    ]);
    */

    /* 쿼리 빌더를 이용하는 방법 => 직접 쿼리 작성 불필요
    DB::table('articles')->insert([
        'body' => $input['body'],
        'user_id' => Auth::id()
    ]);
    */

    /* Eloquent ORM 을 이용하는 방법 */
    // $article = new Article();
    // $article->body = $input['body'];
    // $article->user_id = Auth::user()->id;
    // $article->save();

    Article::create([
        'body' => $input['body'],
        'user_id'=> Auth::user()->id
    ]);

    return redirect()->route('articles.index');

})->name('articles.store');

Route::get('articles', function(Request $request){
    $articles = Article::with('user')
    ->latest()
    ->paginate();

    return view('articles.index',
    [
        'articles' => $articles,
    ]);
})->name('articles.index');

//Route Model Binding
Route::get('articles/{article}', function(Article $article) {
    return view('articles.show', ['article' => $article]);
})->name('articles.show');


Route::get('articles/{article}/edit', function(Article $article){
    return view('articles.edit', ['article' => $article]);
})->name('articles.edit');

Route::patch('articles/{article}', function(Article $article, Request $request){
    $input = $request->validate([
        'body' =>[
            'required',
            'string',
            'max:255'
        ]
    ]);

    $article->body = $input['body'];
    $article->save();

    return redirect()->route('articles.index');
})->name('articles.update');

Route::delete('article/{article}', function(Article $article) {
    $article->delete();
    return redirect()->route('articles.index');
})->name('articles.delete');
