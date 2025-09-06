<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SampleController extends Controller
{
  public function index(Request $request)
  {

    //追加文
    //     $insertResult = DB::connection("mysql")->insert("insert into users (id,email,name,password) values
    // (1,'oda@mail','織田信長','oda1'),
    // (2, 'toyotomi@mail', '豊臣秀吉','toyotomi2'),
    // (3, 'tokugawa@mail', '徳川家康', 'tokugawa3')");

    //     dd($insertResult);

    //削除文
    $deleteResult = DB::connection("mysql")->delete("delete from users where id = 2");
    dd($deleteResult);
  }
}
