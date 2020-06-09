<?php

namespace App\Http\Controllers;

use App\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $students = student::orderBy('id','desc')->paginate(5);

        //return $student;
        //dd($student);
        return view('student.list',compact('students'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
             //return $request;
             $student = new student([
                'nombre' => $request->post('txtFirstnombre'),
                'apellido' => $request->post('txtLastapellido'),
                'email' => $request->post('txtemail'),
                'direccion'=>$request->post('txtdireccion')
            ]);

          $student->save();
          return \Response::json($student);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
          // se trae el id
        //return "this is ".$id;
        $where = array('id' => $id);
        $student  = Student::where($where)->first();

        return \Response::json($student);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $student = Student::find($request->post('hdnStudentId'));
        $student->nombre = $request->post('txtFirstnombre');
        $student->apellido = $request->post('txtLastapellido');
        $student->email = $request->post('txtemail');
        $student->direccion = $request->post('txtdireccion');
        $student->update();
         return \Response::json($student);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
         //
         $student = Student::where('id',$id)->delete();
         return \Response::json($student);
    }
}
