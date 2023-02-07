@extends('layouts.app')

@push('css')
<link href="{{ asset('css/style.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container">
  <div id="article-form" class="mb-3">
     <!-- CSSグリッド: divを無駄に入れない。キャッシュをクリアする。 -->
    <form method="POST" id="searchForm">
      @csrf
      <!-- forとidを関連付け -->
      <label for="seachText" id="searchTextLabel">search text</label>
      <input type="text" name="search_text" id="searchText">
      <button type="submit" class="btn btn-primary" id="searchButton">Search</button>
    </form>
  </div>
  @if(count($articles) > 0)
      <ul>
      @foreach($articles as $article)
        <li>{{$article->created_at}} : {{$article->text}}</li>
      @endforeach
      </ul>
  @endif
</div>
@endsection
