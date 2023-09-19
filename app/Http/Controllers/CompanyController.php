<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Company::get();
        return view('admin.project.company.index')
            ->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.project.company.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Company $company)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'email' => 'required|email|unique:companies,',
                'logo' => 'required|image|mimes:jpg,png,jpeg',
                'website' => 'required'
            ]
        );

        if ($validator->fails()) {
            return redirect('/admin/company')
                ->withErrors($validator)
                ->withInput();
        }




        $image_path = $request->file('image')->store('portfolio-images', 'public');

        $inputs = [];
        $inputs['name'] = $request['name'];
        $inputs['email'] = $request['emails'];
        $inputs['logo'] = $image_path;
        $inputs['website'] = $request['website'];
        $inputs['created_by'] = auth()->user()->email;
        $inputs['created_at'] = Carbon::now();

        DB::table('companies')->insert($inputs);

        session()->flush('message', "You saved the record successfully.");

        return redirect('admin/company');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        $data = Company::where('id', $company->id)->first();

        return view('admin.project.company.show')
            ->with('data', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        $company = Company::where('id', $company->id)->first();
        return view('admin.project.company.edit')
            ->with('company', $company);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {

        $id = $request->id;
        $hasFile = $request->hasFile('image');

        if($hasFile) {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'email' => 'required|email|unique:companies,' . $company->id,
                    'website' => 'required'
                ]
            );
        }

        else {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'email' => 'required|email|unique:companies',
                    'website' => 'required'
                ]
            );
        }



        if ($validator->fails()) {
            return redirect('/admin/company/')
                ->withErrors($validator)
                ->withInput();
        }

        if($hasFile) {
            Storage::delete('public/'. $company->logo);
            $image_path = $request->file('image')->store('portfolio-images','public');
        }



        $inputs = [];
        $inputs['name'] = $request['name'];
        $inputs['email'] = $request['email'];
        $inputs['logo'] =  $hasFile ? $image_path : $company->id;
        $inputs['website'] = $request['website'];
        $inputs['created_by'] = auth()->user()->email;
        $inputs['created_at'] = Carbon::now();

        Company::where('id',$company->id)->update($inputs);

        session()->flush('message', "You saved the record successfully.");

        return redirect('admin/company');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        Storage::delete('public/'. $company->logo);
        Company::where('id',$company->id)->delete();
        return response()->json('delete successfully');
    }
}
