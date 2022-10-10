<?php
namespace App\Helpers\Services;

use App\Models\Student;
use Illuminate\Http\Request;


class StudentService
{
    public static function store($index, $first, $last, $age, $description, $image)
    {

        if (strtolower(request('first')) == "mohamed") {
            throw new \Exception("you guys not allowed");
        }

        return  Student::store(
            $index,
            $first,
            $last,
            $age,
            $description,
            $image
        );
    }



    public static function validateAndAssign($request)
    {
        $id = request('id');
        $index = request('index');
        $fname = request('first');
        $lname = request('last');
        $age = request('age');
        $desc = request('description');

        if (strtolower($fname) == "mohamed") {
            throw new \Exception("you guys not allowed");
        }

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
