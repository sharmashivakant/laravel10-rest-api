<?php

namespace App\Http\Controllers\Api;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;



class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();
        
        if($students->count() >0 ){
            return response()->json([
                'status' => 200,
                'students' => $students
            ],200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'No students found'
            ],404);
        }
        

    }

    public function store(Request  $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:191',
            'course' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'phone' => 'required|digits:10'

        ]);
        if($validator->fails()){

            return response()->json([
                'status' =>422,
                'errors' => $validator->messages()
            ],422);
        }else{
            $students =Student::create([
                'name' =>$request->name,
                'email' =>$request->email,
                'course' =>$request->course,
                'phone' =>$request->phone
            ]);
            if($students){
                return response()->json([
                    'status' =>200,
                    'message' => "Student has successfully"
                ],200);
            }else{
                return response()->json([
                    'status' =>500,
                    'message' => "Something went wrong"
                ],500);
            }
        }

    }

    public function show($id)
    {
        $students =Student::find($id);
        if($students){
            return response()->json([
                'status' =>200,
                'student' => $students
            ],200);
        }else{
            return response()->json([
                'status' =>404,
                'message' => "No Such students found"
            ],404);
        }
    }
    public function edit($id)
    {
        $students =Student::find($id);
        if($students){
            return response()->json([
                'status' =>200,
                'student' => $students
            ],200);
        }else{
            return response()->json([
                'status' =>404,
                'message' => "No Such students found"
            ],404);
        }
    }

    public function update(Request  $request,int $id)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:191',
            'course' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'phone' => 'required|digits:10'

        ]);
        if($validator->fails()){

            return response()->json([
                'status' =>422,
                'errors' => $validator->messages()
            ],422);
        }else{
            $students =Student::find($id);
           
            if($students){
                $students->update([
                    'name' =>$request->name,
                    'email' =>$request->email,
                    'course' =>$request->course,
                    'phone' =>$request->phone
                ]);
                return response()->json([
                    'status' =>200,
                    'message' => "Student Updated successfully"
                ],200);
            }else{
                return response()->json([
                    'status' =>404,
                    'message' => "No such student found"
                ],404);
            }
        }
    }

    public function destroy($id)
    {
        $students = Student::find($id);
        if($students){
            $students->delete();
            return response()->json([
                'status' =>200,
                'message' => "Student deleted successfully"
            ],200);
        }else{
            return response()->json([
                'status' =>404,
                'message' => "No such student found"
            ],404); 
        }
    }
}
