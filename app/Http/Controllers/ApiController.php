<?php

namespace App\Http\Controllers;
use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    public function getAllStudents() {
        // logic to get all students goes here
        $students=student::all('id','name','course')->toJson(JSON_PRETTY_PRINT);
        return response($students, 200);
      }

      public function createStudent(Request $request) {
        // logic to create a student record goes here
        $rules=[
            'name'=>'required|min:3',
            'course'=>'required'
          ];
          $validator=Validator::make($request->all(),$rules);
        //  $validator = Validator::make($request->all(),$rules);
          if($validator->fails()){
            return response()->json($validator->errors(),400);
          }
        $student = new Student;
        $student->name = $request->name;
        $student->course = $request->course;
        $student->save();

        return response()->json([
            "message" => "student record created"
        ], 201);
  }


      public function getStudent($id) {
        // logic to get a student record goes here
        if(Student::where('id',$id)->exists()){
            $student=Student::where('id',$id)->get()->toJson(JSON_PRETTY_PRINT);
            return(response($student,200));
        }
        else {
            return response()->json(["message"=>"student not found"],404);
        }
      }

      public function updateStudent(Request $request, $id) {
        // logic to update a student record goes here
        if (Student::where('id', $id)->exists()) {
            $student = Student::find($id);
            $student->name = is_null($request->name) ? $student->name : $request->name;
            $student->course = is_null($request->course) ? $student->course : $request->course;
            $student->save();

            return response()->json([
                "message" => "records updated successfully"
            ], 200);
            } else {
            return response()->json([
                "message" => "Student not found"
            ], 404);

        }
      }

      public function deleteStudent ($id) {
        // logic to delete a student record goes
        if(Student::where('id',$id)->exists()){
            $student=Student::find($id);
            $student->delete();
            return response()->json([
                "message"=>"student deleted"],202);
            }
        else {
          return response()->json([
          "message" => "Student not found"
        ], 404);
      }

        }

        }


