<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentStoreRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Student;
use Exception;
use  App\Helpers\Services\StudentService;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $students = Student::get();
        return view('student/index', ['students' => $students]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StudentStoreRequest $request)
    {
        try {

            $imageExtension = $request->file('image')->extension();
            $imgName = "user" . time() . "." . $imageExtension;
            $path = request('image')->storeAs(
                'public/images/users',
                $imgName
            );

            $student = StudentService::store(
                $request->get('index'),
                request('first'),
                request('last'),
                request('age'),
                request('description'),
                $imgName
            );

            $response = [
                'msg' => 'success',
                'student' => $student,
            ];
            return response()->json($response);
        } catch (Exception $err) {
            $response = [
                'message' =>  $err->getMessage(),
            ];
            return response()->json($response, 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $student = Student::query()->where('id', "=", $id)->first();
        return $student;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $returns = StudentService::validateAndAssign($request);
        $student =  Student::find($returns[0]);
        $student = StudentService::updatedata($student, $returns);
        $student->save();
        $response = StudentService::updateResponse($returns);
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Student::query()->where('id', '=', $id)->delete();
            $response = [
                "msg" => "success"
            ];
            return response()->json($response);
        } catch (Exception $exception) {
            $response = [
                "message" => $exception->getMessage()
            ];
            return response()->json($response, 422);
        }
    }
}
