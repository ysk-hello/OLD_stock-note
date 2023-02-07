<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    public function __construct(){
        // ログインしていない場合、ログイン画面へリダイレクト
        $this->middleware('auth');
    }

    public function index(Request $request){
        if($request->has(['ym', 'd'])){
            $date = $request->ym . '-' . $request->d;
        }
        else if($request->has('ym') && !$request->has('d')){
            $date = $request->ym . '-1';
        }
        else{
            $date = date('Y-n-j');
        }

        // https://qiita.com/hitochan/items/de54c4b41dea548d2f8b
        $articles = Article::where('user_id', Auth::id())
            ->whereDate('created_at', $date)
            ->orderBy('created_at', 'asc')->paginate(5);
        
        // 第二引数: view側での変数名 => controller側の変数
        return view('index', ['articles' => $articles, 'currentDate' => $date]);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'stock_name' => 'required',
            'stock_text' => 'required',
        ]);

        if($validator->fails()){
            return redirect('/')
                ->withInput()   // セッションに入力値を保存、フラッシュデータ
                ->withErrors($validator);    // エラー内容を$errorsに渡す
        }

        $article = new Article;
        $article->stock_name = $request->stock_name;
        $article->text = $request->stock_text;
        $article->user_id = Auth::id();
        $article->save();

        return redirect('/');
    }

    public function edit($article_id){
        $article = Article::where('user_id', Auth::id())->find($article_id);

        return view('article_edit', ['article' => $article]);
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'stock_name' => 'required',
            'stock_text' => 'required',
        ]);

        if($validator->fails()){
            return redirect('/article/edit/'.$request->id)
                ->withInput()   // セッションに入力値を保存、フラッシュデータ
                ->withErrors($validator);    // エラー内容を$errorsに渡す
        }

        $article = Article::where('user_id', Auth::id())->find($request->id);

        $article->stock_name = $request->stock_name;
        $article->text = $request->stock_text;
        $article->save();

        return redirect('/');
    }

    public function destroy(Article $article){
        $article->delete();

        return redirect('/');
    }

    public function search(Request $request){
        // あいまい検索
        $articles = Article::where('text', 'like', '%' . $request->search_text . '%')->get();

        return view('article_search', ['articles' => $articles]);
    }
}
