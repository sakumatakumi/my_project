<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{

  //登録画面
  public function index(Request $request)
  {
    // 非ログイン時はアカウント登録フォーム、ログイン時はログアウトボタンを表示するといった切り替えのため session に保存された login_id を取得
    $loginId = $request->session()->get("login_id", null);
    $variables = ["isLoginActive" => isset($loginId)];
    return view("login/index", compact("variables"));
  }

  //ログイン処理
  public function register(Request $request)
  {

    //form からの入力情報の取得
    $id = $request->input("id");
    $password = $request->input("password");

    /*同一 idの登録がすでに存在するかチェックするため、指定されたidをもとにDB　recordを取得
select count(*)は where 条件に合致するレコード数を取得 (SQL Query)*/
    $oldRecords = DB::connection('mysql')->select("select count(*) from users where id = '" . $id . "'");

    //sql queryに失敗した場合、処理失敗として終了
    if (count($oldRecords) == 0) {
      return response("処理中に問題が発生しました。<a href='/login'前のページへ戻る</a>");
    }

    //count(*)の値が0より大きい場合は同一idのrecordが存在しているため、処理を終了
    $record = (array)($oldRecords[0]);
    if ($record["count(*)"] > 0) {
      return response("処理中に問題が発生しました。<a href='/login'>前のページへ戻る</a>");
    }

    //ここまで正常に処理が進んだら既存のレコードも存在しないため、入力情報をもとにレコードを追加。
    DB::connection("mysql")->insert("insert into users (id,password) values ('" . $id . "','" . $password . "')");

    //ログインidを取得するため、保存したレコード情報を取得
    $records = DB::connection('mysql')->select("select * from users where id = '" . $id . "'");

    //recordsが取得できなかった場合、何らかのエラーが発生してるため、処理終了
    if (count($records) == 0) {
      return response("ユーザーデータの登録処理中に問題が発生しました。<a href='/login'>前のページへ戻る</a>");
    }

    //sessionにログインしている　user idを保存
    $request->session()->put("login_id", $records[0]->id);

    return response("登録が完了しました。<a href='/login'>前のページへ戻る</a>");
  }


  //ログイン処理
  public function sign_up(Request $request)
  {
    $id = $request->input("id");
    $password = $request->input("password");

    $records = DB::connection('mysql')->select("select * from users where id = '" . $id . "'and password= '" . $password . "'");

    if (count($records) == 0) {
      return response("処理中に問題が発生しました。<a href='/login'>前のページへ戻る</a>");
    }

    $request->session()->put("login_id", $records[0]->id);
    return response("ログインしました。<a href='/login'>前のページへ戻る</a>");
  }


  //ログアウト処理
  public function unregister(Request $request)
  {
    $request->session()->flush();
    return response("ログアウトが完了しました。<a href='/login'>前のページへ戻る</a>");
  }
}
