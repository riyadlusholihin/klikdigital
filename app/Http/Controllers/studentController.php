<?php

namespace App\Http\Controllers;

use App\studentModel;
use Dotenv\Result\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class studentController extends Controller
{
    public function getStudent()
    {
        $response = array(
            'status' => false,
            'results' => array(),
            'message' => "Opps,Something Wrong!",
        );

        try {
            $student = studentModel::where('deleted_at',null)->get();
            
            $response['results'] = $student;
            $response['status'] = count($response['results']) >=0;
            $response['message'] = $response['status']? "Success Show data student":"Failed Show data student";
        } catch (\Throwable $th) {
            $response['status'] = false;
            $response['results'] = $th->getTrace();
            $response['message'] = $th->getMessage();
            return response()->json($response,400);
        }
        return response()->json($response);
    }

    public function storeStudent(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'name' => 'required',
            'gender' => 'required|max:1',
            'email' => 'required|email|unique:student,email',
            'no_hp' => 'required|numeric|digits_between:11,16'
        ]);

        $response = array(
            'status' => false,
            'results' => array(),
            'message' => "Opps, Something wrong",
        );

        if ($validation->fails()) {
            $response['message'] = $validation->errors()->first();
            return response()->json($response);
        }

        try {
            $newStudent = new studentModel();
            $newStudent->name = $request->name;
            $newStudent->gender = $request->gender;
            $newStudent->email = $request->email;
            $newStudent->no_hp = $request->no_hp;

            $response['status'] = $newStudent->save();
            $response['results'] = studentModel::where('id',$newStudent->id)->first();
            $response['message'] = $response['status']?"Success Save Student":"Failed Save Student";
            return response()->json($response);
        } catch (\Throwable $th) {
            $response['status'] = false;
            $response['results'] = $th->getTrace();
            $response['message'] = $th->getMessage();
            return response()->json($response,400);
        }
        return response()->json($response);
    }

    public function showStudent($student_id)
    {
        $response = array(
            'status' => false,
            'results' => array(),
            'message' => "Opps, Something wrong",
        );

        try {
            $showStudent = studentModel::findOrFail($student_id);
            
            $response['results'] = $showStudent;
            $response['status'] = !empty($response['results']);
            $response['message'] = $response['status']?"Success get Data student":"failed get data student";
            return response()->json($response);
        } catch (\Throwable $th) {
            $response['status'] = false;
            $response['results'] = $th->getTrace();
            $response['message'] = $th->getMessage();
            return response()->json($response,400);
        }

        return response()->json($response);
    }

    public function updateStudent($student_id, Request $request)
    {
        $editStudent = studentModel::find($student_id);

        $validation = Validator::make($request->all(),[
            'name' => 'required',
            'gender' => 'required|max:1',
            'email' => 'required|email|unique:student,email,'.$editStudent->id,
            'no_hp' => 'required|numeric|digits_between:11,16'
        ]);

        $response = array(
            'status' => false,
            'results' => array(),
            'message' => "Opps, Something wrong",
        );

        if ($validation->fails()) {
            $response['message'] = $validation->errors()->first();
            return response()->json($response);
        }

        try {
            $editStudent->name = $request->name;
            $editStudent->gender = $request->gender;
            $editStudent->email = $request->email;
            $editStudent->no_hp = $request->no_hp;

            $response['status'] = $editStudent->save();
            $response['results'] = $response['status']? studentModel::find($editStudent->id):"Fail";
            $response['message'] = $response['status']? "Success update data student":"failed update data student";
            return response()->json($response);
        } catch (\Throwable $th) {
            $response['status'] = false;
            $response['results'] = $th->getTrace();
            $response['message'] = $th->getMessage();
            return response()->json($response,400);
        }
        return response()->json($response);
    }

    public function deleteStudent($student_id)
    {
        $response = array(
            'status' => false,
            'results' => array(),
            'message' => "Opps, Something wrong",
        );

        try {
            $deleteStudent = studentModel::find($student_id);
            $response['results'] = $deleteStudent->delete();
            $response['status'] = true;
            $response['message'] = "Success Delete Student";
            return response()->json($response);
        } catch (\Throwable $th) {
            $response['status'] = false;
            $response['results'] = $th->getTrace();
            $response['message'] = $th->getMessage();
            return response()->json($response,400);
        }
        return response()->json($response);
    }
}
