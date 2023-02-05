@extends('layouts.app')

@push('css')
<link href="{{ asset('css/style.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container">
  <div id="article-form" class="mb-3">
    <!-- バリデーションエラー: ファイル読込 -->
    @include('common.errors')

    <!-- CSSグリッド: divを無駄に入れない。キャッシュをクリアする。 -->
    <form action="{{url('article/update')}}" method="POST" id="form">
      @csrf
      <!-- forとidを関連付け -->
      <label for="stockName" id="stockNameLabel">stock name</label>
      <input type="text" name="stock_name" id="stockName" value="{{old('stock_name', $article->stock_name)}}">
      <label for="stockText" id="stockTextLabel">stock text</label>
      <textarea name="stock_text" id="stockText" cols="50" rows="10">{{old('stock_text', $article->text)}}</textarea>
      <button type="submit" class="btn btn-primary" id="submitButton">Update</button>
      <!-- 隠し -->
      <input type="hidden" name="id" value="{{$article->id}}">
    </form>
  </div>
</div>
@endsection
