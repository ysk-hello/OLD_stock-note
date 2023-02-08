<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function __construct(){
        // ログインしていない場合、ログイン画面へリダイレクト
        $this->middleware('auth');
    }

    public function link(Request $request){
        $links = [];

        if($request->isMethod('post')){
            $file = $request->file('upfile');
            $path = $file->path();

            $fp = fopen($path, 'r');
            while ($line = fgetcsv($fp)) {
                $name = mb_convert_encoding($line[1],"utf-8","sjis-win"); // シフトJISからUTF-8に変換
                array_push($links, ['name' => $name, 'url' => 'https://kabutan.jp/stock/chart?code=' . $line[0]]);
            }

            fclose($fp);
        }

        return view('link', ['links' => $links]);
    }
}
