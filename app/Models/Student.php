<?php

namespace App\Models;

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
    ];

    public static function validateAndAssign($request)
    {

        $request->validate([
            'index' => ['required', 'max:10'],
            'first' => ['required', 'max:15'],
            'last' => ['required', 'max:15'],
            'age' => ['required'],
            'description' => ['required']
        ]);


        $id = request('id');
        $index = request('index');
        $fname = request('first');
        $lname = request('last');
        $age = request('age');
        $desc = request('description');

        return [$id, $index, $fname, $lname, $age, $desc];
    }


    public static function updatedata($student, $returns)
    {

        $student->index_num = $returns[1];
        $student->first_name = $returns[2];
        $student->last_name = $returns[3];
        $student->age = $returns[4];
        $student->description = $returns[5];

        return $student;
    }

    public static function  updateResponse($returns)
    {
        return [
            'msg' => 'success',
            'student' => [
                "id" => $returns[0],
                "index_num" => $returns[1],
                "first_name" => $returns[2],
                "last_name" => $returns[3],
                "age" => $returns[4],
                "description" => $returns[5]
            ],
        ];
    }
}
