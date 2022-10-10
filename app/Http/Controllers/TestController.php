<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;


class TestController extends Controller
{
    public static function index(Request $request){

        echo $request->file('image');
   
        $imageExtension = $request->file('image')->extension();
        $imgName = "user".time().".".$imageExtension;
        $path = request('image')->storeAs(
            'public/images/users',$imgName
        );
            echo $imageExtension;
       

        $test = new Test;
        $test->name=request('name');
        $test->image_link=$imgName;
        $test->save();
        

        return view('test/test',["msg" => "saved"]) ;
 
    }
}
