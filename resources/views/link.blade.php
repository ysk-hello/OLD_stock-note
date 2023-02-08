@extends('layouts.app')

<!-- @push('js')
<script src="{{ asset('js/link.js') }}" defer></script>
@endpush -->

@push('css')
<link href="{{ asset('css/style.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container">
  <div id="article-form" class="mb-3">
     <!-- CSSグリッド: divを無駄に入れない。キャッシュをクリアする。 -->
    <form method="POST" id="linkForm" enctype="multipart/form-data">
      @csrf
      <input type="file" name="upfile" id="upfile" accept=".csv" require>
      <button type="submit" class="btn btn-primary" id="uploadButton">Upload</button>
    </form>
  </div>
  @if(count($links) > 0)
      <ul>
      @foreach($links as $link)
        <li><a href="{{$link['url']}}" target="_blank">{{$link['name']}}</a></li>
      @endforeach
      </ul>
  @endif
</div>
@endsection
