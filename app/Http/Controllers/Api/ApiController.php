<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;

class ApiController extends Controller
{
    // CREATE API
    public function createStudent(Request $request){

        //VALIDATION
        $request->validate([
            "name" => "required",
            "email"=> "required|email|unique:students",
            "phone_no"=> "required",
            "gender"=> "required",
            "age"=> "required"
        ]);

        // CREATE data
        $student = new Student();
        $student->name = $request->name;
        $student->email = $request->email;
        $student->phone_no = $request->phone_no;
        $student->gender = $request->gender;
        $student->age = $request->age;
        $student->save();

        // send response
        return response()->json([
            "status"=> 1,
            "message"=> "Student Created Successfully",
        ]);
    }

    //LIST API
    public function listStudent(){

        $students = Student::get();      
        return response()->json([
            "Status" => 1,
            "Message" => "Listing Students",
            "Data" => $students

        ]);
    }

    // GET SINGLE API

    public function getSingleStudent($id){

        if(Student::where("id",$id)->exists()){
            $student_detail = Student::where("id",$id)->first();
            return response()->json([
                "Status" => 1,
                "Message" => "Single Student List",
                "Data" => $student_detail
            ]);

        } else {
            return response()->json([

                "Status"=> 0,
                "Message" => "Student Not Found!!"
            ], 404);
        }
    }

    // UPDATE API
    public function updateStudent(Request $request, $id){

        if(Student::where("id",$id)->exists()){

            $student = Student::find($id);

            $student->name = !empty($request->name) ? $request->name : $student->name;
            $student->email = !empty($request->email) ? $request->email : $student->email;
            $student->phone_no = !empty($request->phone_no) ? $request->phone_no : $student->phone_no;
            $student->gender = !empty($request->gender) ? $request->gender : $student->gender;
            $student->age = !empty($request->age) ? $request->age : $student->age;

            $student->save();

            return response()->json([
                "Status" => 1,
                "Message" => "Succesfully Student updated!!",
                "Data" => $student
            ]);

           

        }else{
            return response()->json([

                "Status"=> 0,
                "Message" => "Student Not Updated!!"
            ], 404);

        }


    }

    // DELETE API
    public function deleteStudent($id){

        if(Student::where("id",$id)->exists()){

            $student = Student::find($id);
            $student->delete();
            return response()->json([
                "Status" => 1,
                "Message" => "Succesfully Student Deleted!!",
                
            ]);

        }else{
            return response()->json([
                "Status"=> 0,
                "Message" => "Student Not Found!!"
            ], 404);
        }
    }
}
