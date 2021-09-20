<?php

namespace App\Http\Controllers;

use App\Models\Employ;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class EmployController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $data=Employ::orderBy('id','DESC')->get();
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct">Edit</a>';
   
                $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('home');
    }
    // public function store(Request $request){
    //          $employ=new Employ();
    //          $employ->first_name=$request->first_name;
    //          $employ->last_name=$request->last_name;
    //          $employ->title=$request->title;
    //          $employ->salary=$request->salary;
    //          $employ->save();
    //     return response()->json(['success'=>'Product saved successfully.']);
    // }

    public function store(Request $request)
    {
        Employ::updateOrCreate(['id' => $request->employ_id],
            [   'first_name' => $request->first_name, 
                'last_name' => $request->last_name,
                'title' => $request->title,
                'salary' => $request->salary,
            ]);        
        return response()->json(['success'=>'Product saved successfully.']);
    }



    public function edit($id){
        $employ=Employ::where('id',$id)->first();
        return response()->json($employ);
    }
    public function delete($id){
        $employ=Employ::find($id)->delete();
        return response()->json($employ);
    }

}
