<?php

namespace App\Http\Controllers;

use App\Models\employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Employee::get();
        return view('admin.project.employee.index')
            ->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('admin.project.employee.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Employee $employee)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'full_name' => 'required|',
                'company_id' => 'required',
                'email' => 'required|email|unique:employees,',
                'phone' => 'required'
            ]
        );

        if($validator->fails()){
            return redirect('/admin/employee')
                ->withErrors($validator)
                ->withInput();
        }

        $inputs = [];
        $inputs['full_name'] = $request['full_name'];
        $inputs['company_id'] = $request['company_id'];
        $inputs['email'] = $request->emails;
        $inputs['phone'] = $request['phone'];
        $inputs['updated_by'] = auth()->user()->email;
        $inputs['updated_at'] = Carbon::now();

        // Employees::insert($inputs);
        DB::table('employees')->insert($inputs);
        session()->flash('message',"You updated the record successfully.");

        return view('admin.project.employee.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employees  $employees
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        $data = Employee::where('id',$employee->id)->first();

        return view('admin.project.employee.show')
            ->with('data',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employees  $employees
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {

        $employee = Employee::where('id', $employee->id)->first();
        return view('admin.project.employee.edit')
            ->with('employees', $employee);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employees  $employees
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'full_name' => 'required|unique:employees,full_name,',
                'company_id' => 'required',
                'email' => 'required|email|unique:companies,'.$employee->id,
                'phone' => 'required'
            ]
        );

        if($validator->fails()){
            return redirect('/admin/employee/' . $employee->id . "/edit")
                ->withErrors($validator)
                ->withInput();
        }

        $inputs = [];
        $inputs['full_name'] = $request['full_name'];
        $inputs['company_id'] = $request['company_id'];
        $inputs['email'] = $request->email;
        $inputs['phone'] = $request['phone'];
        $inputs['updated_by'] = auth()->user()->email;
        $inputs['updated_at'] = Carbon::now();



        DB::table('employees')->where('id',$employee->id)->update($inputs);

        session()->flash('message',"You updated the record successfully.");

        return redirect('/admin/employee');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employees  $employees
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        Employee::where('id',$employee->id)->delete();
    }
}
