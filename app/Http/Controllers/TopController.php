<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TopController extends Controller
{
  public function index(Request $request)
  {
    $sampleValue = "sample テキストです。";


    $records = DB::connection('mysql')->select("select * from items");
    // query 実行処理 実行結果を $records に代入
    // dd($records);
    // dd( $records[0]->name );
    // 処理をここで停止して引数に指定した値を確認する。

    //追加文（insert）
    // $insertResult = DB::connection("mysql")->insert("insert into items (id,name,price) values (null,'メロン',2000)");
    // dd($insertResult);


    //更新文（update）
    $updateResult = DB::connection("mysql")->update("update items set price = 600 where name = 'メロン'");
    dd($updateResult);


    //削除文（delete）
    // $deleteResult = DB::connection("mysql")->delete("delete from items where name = 'りんご'");
    // dd($deleteResult);

    return view("top/index", ["sampleValue" => $sampleValue]);
  }
}
