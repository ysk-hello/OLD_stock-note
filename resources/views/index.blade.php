@extends('layouts.app')

@push('js')
<script src="{{ asset('js/script.js') }}" defer></script>
@endpush

@push('css')
<!-- https://qiita.com/tbzgkzejyk1ef5s91wuf/items/7a78322dc6a220d34103 -->
<!-- https://stackoverflow.com/questions/35672485/what-is-the-difference-between-section-and-stack-in-blade -->
<link href="{{ asset('css/style.css') }}" rel="stylesheet">
@endpush

@section('content')
<?php
date_default_timezone_set('Asia/Tokyo');

if(isset($_GET['ym'])){
  $ym = $_GET['ym'];
}
else{
  $ym = date('Y-n');
}

$timestamp = strtotime('first day of ' . $ym); // 月の最初の日
if($timestamp === false){
  $ym = date('Y-n');
  $timestamp = strtotime('first day of ' . $ym);
}

// j: no zero
$today = date('Y-n-j');

// n: no zero
$this_month = date('Y-n', $timestamp);
$prev = date('Y-n', strtotime('-1 month', $timestamp));   // 第2引数を基準としたUnix時間
$next = date('Y-n', strtotime('+1 month', $timestamp));

$day_count = date('t', $timestamp);

// 0～6
$youbi = date('w', $timestamp);

$weeks = [];  // tr
$week = '';   // td
$week .= str_repeat('<td></td>', $youbi);

for($day = 1; $day <= $day_count; $day++, $youbi++){
  $date = $ym . '-' . $day;
  $argDay = new DateTime($date);
  // 祝日
  $holidays = Yasumi\Yasumi::create('Japan', (int)$argDay->format('Y'), 'ja_JP');

  if($today == $date){
    if($holidays->isHoliday($argDay)){
      $week .= '<td class="today holiday">';
    }
    else{
      $week .= '<td class="today">';
    }
  }
  else{
    if($holidays->isHoliday($argDay)){
      $week .= '<td class="holiday">';
    }
    else{
      $week .= '<td>';
    }
  }

  $week  .= $day . '</td>';

  // 週終わり、または、月終わり
  if($youbi % 7 == 6 || $day == $day_count){
    if($day == $day_count){
      $week .= str_repeat('<td></td>', 6 - $youbi % 7);
    }

    // tr
    $weeks[] = '<tr>' . $week . '</tr>';

    $week = '';
  }
}
?>

<div class="container">
    <div class="row justify-content-center">
        <!-- メイン -->
        <div id="main" class="col-md-7">
          <h2 class="mb-3">{{$currentDate}}</h2>
          <!-- フォーム -->
          <div id="article-form" class="mb-5">
            <!-- バリデーションエラー: ファイル読込 -->
            @include('common.errors')
            <!-- CSSグリッド: divを無駄に入れない。キャッシュをクリアする。 -->
            <form action="{{url('article')}}" method="POST" id="form">
              @csrf
              <!-- forとidを関連付け -->
              <label for="stockName" id="stockNameLabel">stock name</label>
              <input type="text" name="stock_name" id="stockName" value="{{old('stock_name', '')}}">
              <label for="stockText" id="stockTextLabel">stock text</label>
              <textarea name="stock_text" id="stockText" cols="50" rows="10">{{old('stock_text', '')}}</textarea>
              <button type="submit" class="btn btn-primary" id="submitButton">Add</button>
            </form>
          </div>
          <!-- リスト -->
          <div id="article-list" class="mb-5">
            @if(count($articles) > 0)
              <table it="article-table"class="table table-striped task-table">
                <tbody>
                  @foreach($articles as $article)
                    <tr>
                      <td class="table-text">
                        <b>{{$article->stock_name}}</b>
                        <p>{{$article->text}}</p>
                      </td>
                      <td id="edit-button">
                        <form action="{{url('article/edit/'.$article->id)}}" method="POST">
                          @csrf
                          <button type="submit" class="btn btn-primary">Edit</button>
                        </form>
                      </td>
                      <td id="delete-button">
                        <form action="{{url('article/'.$article->id)}}" method="POST" onSubmit="return confirm('Delete?');">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
              {{$articles->links()}}
            @endif
          </div>
        </div>
        <!-- サイド -->
        <div id="side" class="col-md-4 offset-md-1">
            <!-- カレンダー -->
            <div id="calendar">
                <h5 id="this-month">
                  <a href="?ym=<?php echo $prev; ?>"> < </a><div id="current-month"><?php echo $this_month; ?></div><a href="?ym=<?php echo $next; ?>"> > </a>
                </h5>
                <table class="table table-bordered" id="calendar-table">
                    <tr>
                        <th>Sun</th>
                        <th>Mon</th>
                        <th>Tue</th>
                        <th>Wed</th>
                        <th>Thir</th>
                        <th>Fri</th>
                        <th>Sat</th>
                    </tr>
                    <?php
                        foreach($weeks as $week){
                            echo $week;
                        }
                    ?>
                </table>
            </div>
            <!-- サイドバー -->
            <div id="sidebar">
              hello, world.
            </div>
        </div>
    </div>
</div>
@endsection
