<!--resources/views/books.blade.php-->
<!-- resources/views/books.blade.php -->
@extends('layouts.app')
@section('content')
    <!-- Bootstrapの定形コード… -->
    <div class="card-body">
        <div class="card-title">
            購入服情報
        </div>

        <!-- バリデーションエラーの表示に使用-->
        @include('common.errors')
        <!-- バリデーションエラーの表示に使用-->

        <!-- 本のタイトル -->
        <form enctype="multipart/form-data" action="{{ url('books') }}" method="POST" class="form-horizontal">
            @csrf
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="book" class="col-sm-3 control-label">アイテム名</label>
                    <select type="text" name="item_name" class="form-control">
                    <option value = "アウター">アウター</option>
                    <option value = "スウェット">スウェット</option>
                    <option value = "パーカー">パーカー</option>
                    <option value = "パンツ">パンツ</option>
                    <option value = "ティーシャツ">ティーシャツ</option>
                    <option value = "シャツ">シャツ</option>
                    <option value = "ニット">ニット</option>
                    <option value = "スカート">スカート</option>
                    <option value = "ワンピース">ワンピース</option>
                    <option value = "その他">その他</option>
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label for="amount" class="col-sm-3 control-label">金額</label>
                    <input type="text" name="item_amount" class="form-control">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="published" class="col-sm-3 control-label">購入日</label>
                    <input type="date" name="published" class="form-control">
                </div>
                <div class="form-group col-md-6">
                    <label for="color" class="col-sm-3 control-label">色</label>
                    <select type="text" name="item_color" class="form-control">
                    <option value="黒">黒</option>
                    <option value="赤">赤</option>
                    <option value="白">白</option>
                    <option value="青">青</option>
                    <option value="黄色">黄色</option>
                    <option value="グレー">グレー</option>
                    <option value="紫">紫</option>
                    <option value="ベージュ">ベージュ</option>
                    <option value="その他">その他</option>
                    </select>
                </div>
            </div>
                <div class="col-sm-6">
                    <label>画像</label>
                    <input type="file" name="item_img">
                </div>
            
            <!-- 本 登録ボタン -->
            <div class="form-row">
                <div class="col-sm-offset-3 col-sm-6">
                    <button type="submit" class="btn btn-primary">
                    登録する
                    </button>
                </div>
            </div>
        </form>
    </div>
    @if (session('message'))
        <div>
            {{session('message')}}
        </div>
    @endif
    <!--合計金額用変数を定義-->
    <?php
        $total = 0;
        $sum = 0;
        $this_date = "";
        $on_date = "";
    ?>
    <!-- Book: 既に登録されてる本のリスト -->
     <!-- 現在の本 -->
    @if (count($books) > 0)
        <div class="card-body">
            <div class="card-body">
                <table class="table table-striped task-table">
                    <!-- テーブルヘッダ -->
                    <thead>
                        <th>購入服一覧</th>
                        <th>&nbsp;</th>
                    </thead>
                    <!-- テーブル本体 -->
                    <tbody>
                        @foreach ($books as $book)
                            <tr>
                                <!-- 本タイトル -->
                                <td class="table-text">
                                    <div>{{ $book->item_name }}</div>
                                    <div>{{ $book->item_amount }}円 </div>
                                <!--合計金額を計算-->    
                                    <?php
                                        $sum =$sum + $book->item_amount;
                                        $on_date = date('m');
                                        $this_date = date('m',strtotime($book->published));
                                        if ($on_date == $this_date):
                                            $total = $total + $book->item_amount;
                                        endif;
                                    ?>
                                    <div> <img src="upload/{{$book->item_img}}" width="100"></div>
                                </td>

                                <!-- 本: 更新ボタン -->
                                <td>
                                    <form action="{{ url('booksedit/'.$book->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">
                                            更新
                                        </button>
                                    </form>
                                </td>

                                <!-- 本: 削除ボタン -->
                                <td>
                                    <form action="{{ url('book/'.$book->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger">
                                            削除
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- 合計金額を表示-->
        <div class="card-body">
            <div class="card-body">
                <tr>
                    <td class="table-text">
                        <div class="form-row">
                        <div class="form-group col-md-6">    
                        <div><font size ="5"> 今月の合計金額 </font></div>    
                        <div><font size ="5"> {{ $total }}円 </font></div>
                        </div>
                        </div>
                        <div class="form-row">
                        <div class="form-group col-md-6">    
                        <div><font size ="5"> 合計金額 </font></div>
                        <div><font size ="5">{{ $sum  }}円</font></div>
                        </div>
                        </div>
                    </td>
                </tr>
            </div>
        </div> 
        
        <div class="row">
            <div class="col-md-4 offset-md-4">
                {{ $books->links() }}
            </div>
        </div>
        
    @endif
    
    
           
@endsection

