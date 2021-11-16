<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request; //Requestクラスをインポート

class TodoController extends Controller
{

  /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
   // TodoモデルがDBにあるtodoの中身を全て取得し、$todosにいれる
      $todos = Todo::all();
   // $todosをcompact()の中に入れ、todo.indexの中で$todosを呼べるようにする
      return view('todo.index', compact('todos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
     // create.phpの中身を表示する処理
        return view('todo.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

 // storeメソッドにリクエストで送られてきた内容でtodo登録する
    public function store(Request $request) //引数にRequestをタイプヒンティング(型宣言)で渡し、インスタンス作成する
    {
      $todo = new Todo(); //DIを経由してクラスが生成される
      $todo->title = $request->input('title');
      $todo->save();

   // 登録が完了したら一覧画面に登録完了のメッセージをつけて遷移する
   // with('リレーション名')⇒リレーション(DB上のテーブルを関連づけるもの)取得時に使う
      return redirect('todos')->with(
      'status',
      $todo->title . 'を登録しました!'
      );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id) //リクエストで送られてきた$idを取得
    {
      $todo = Todo::find($id); //$idの内容を変数$todoに入れる
   // 取得したtodoをshow.blade.phpに表示する
   //compact('todo') == array('todo'=>$todo)
      return view('todo.show', compact('todo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id) //リクエストで送られてきた$idを取得
    {
      $todo = Todo::find($id); //$idの内容を変数$todoに入れる
      // 取得したtodoをedit.blade.phpに表示する
      //compact('todo') == array('todo'=>$todo)
      return view('todo.edit', compact('todo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

 // updateメソッドにリクエストで送られてきた内容でtodoを更新する
    public function update(Request $request, $id)  //引数にRequestをタイプヒンティング(型宣言)で渡し、インスタンス作成する
    {
      $todo = Todo::find($id); //Requestで送られてきたtodoを取得
      $todo->title = $request->input('title'); //変更内容取得
      $todo->save(); //変更内容保存
   // 更新が完了したら一覧画面に更新完了のメッセージをつけて遷移する
      return redirect('todos')->with(
      'status',
      $todo->title . 'を更新しました!'
  );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) //リクエストで送られてきた$idを取得
    {
      $todo = Todo::find($id); //$idの内容を変数$todoに入れる
      $todo->delete(); //$todoを削除
   // with('リレーション名')⇒リレーション(DB上のテーブルを関連づけるもの)取得時に使う
      return redirect('todos')->with(
      'status',
      $todo->title . 'を削除しました!'
      );
    }

}
