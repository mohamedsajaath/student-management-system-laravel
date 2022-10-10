<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'index_num',
        'first_name',
        'last_name',
        'age',
        'description',
        'std_image'
    ];





    public static function store($index, $first, $last, $age, $description,$image)
    {
        return Student::create([
            'index_num' => $index,
            'first_name' => $first,
            'last_name' =>  $last,
            'age' =>  $age,
            'description' => $description,
            'std_image' => $image,
        ]);
    }

    public static function validateAndAssign($request)
    {
        $id = request('id');
        $index = request('index');
        $fname = request('first');
        $lname = request('last');
        $age = request('age');
        $desc = request('description');

        if(strtolower($fname) == "mohamed"){
            throw new Exception("you guys not allowed");
        }

        return [$id, $index, $fname, $lname, $age, $desc];
    }


 
 
}
