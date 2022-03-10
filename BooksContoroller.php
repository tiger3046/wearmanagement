<?php 

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Book;
use Validator;
use Auth;

class BooksContoroller extends Controller
{
    //更新
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function update(Request $request){
        //バリデーション
        $validator = Validator::make($request -> all(),[
            'id' => 'required',
            'item_name' => 'required|min:3|max:255',
            'item_color' => 'required',
            'item_amount' => 'required|max:6',
            'published' => 'required',
            ]);
            
        // バリデーションエラー
        if($validator->fails()){
            return redirect('/')
            ->withInput()
            ->withErrors($Validator);
        }
        
        
        //データ更新
        $books = Book::where('user_id' ,Auth::user()->id)->find($request->id);
        $books->item_name = $request -> item_name;
        #$books->item_number = $request -> item_number;
        $books->item_color = $request -> item_color;
        $books->item_amount = $request -> item_amount;
        $books->published = $request -> published;
        $books -> save();
        return redirect('/');
    }
    //登録
    public function store(Request $request){
        //バリデーション
        $validator = Validator::make($request -> all(),[
            'item_name' => 'required|min:3|max:255',
            'item_color' => 'required',
            'item_amount' => 'required|max:6',
            'published' => 'required',
            ]);
        //バリデーションエラー
        if ($validator->fails()){
            return redirect('/')
            ->withInput()
            ->withErrors($validator);
        }
        $file = $request->file('item_img'); //file取得
        if( !empty($file) ){                //fileが空かチェック
            $filename = $file->getClientOriginalName();   //ファイル名を取得
            $move = $file->move('./upload/',$filename);  //ファイルを移動：パスが“./upload/”の場合もあるCloud9
        }else{
            $filename = "";
        }

        //Eloquentモデル(登録処理)
        $books = new Book;
        $books->user_id = Auth::user()->id;
        $books->item_name = $request->item_name;
        #$books->item_number = $request->item_number;
        $books->item_color = $request->item_color;
        $books->item_amount = $request->item_amount;
        $books->item_img = $filename;
        $books->published = $request->published;
        $books->save();
        return redirect('/')->with('message','登録が完了しました！');
    }
    public function index(Request $request){
    
        $books = Book::where('user_id' ,Auth::user()->id)
        ->orderBy('item_color','asc')
        ->orderBy('item_name','asc')
        ->paginate(10);
        return view('books',['books' => $books]);
        
    }
    
    public function edit($book_id) {
        $books = Book::where('user_id' ,Auth::user()->id)->find($book_id);
        //{books}id 値を取得 => Book $books id 値の1レコード取得
        return view('booksedit', ['book' => $books]);
    
    }  
    public function destroy(Book $book) {
    //
    $book->delete();
    return redirect('/');
    
    }
    
    
    
    
} 

