<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Noticeboard;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class NoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $data = [];
        $data['notices'] = Noticeboard::all();
        //  dd($data);
        return view('admin.notice.noticeList', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        return view('admin.notice.addNotice');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'subject' => 'required',
            'description' => 'required',
            'dept' => 'required',
            'status' => 'required'
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
         }
         
         $noticeObj = new Noticeboard;

         $noticeObj->subject = $request->subject;
         $noticeObj->description = $request->description;
         $noticeObj->dept = $request->dept;
         $noticeObj->status = $request->status;

         $noticeObj->save();

         return redirect()->route('notice.index')->with('success', 'Notice added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show($id)
    {
        $data = [];
        $data['notice'] = Noticeboard::find($id);

        return view('admin.notice.noticeDetails', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     */
    public function edit($id)
    {
        $data = [];
        $data['notice'] = Noticeboard::find($id);
        return view('admin.notice.editNotice', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'subject' => 'required',
            'description' => 'required',
            'dept' => 'required',
            'status' => 'required'
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
         }
         
         $noticeObj = Noticeboard::find($id);

         $noticeObj->subject = $request->subject;
         $noticeObj->description = $request->description;
         $noticeObj->dept = $request->dept;
         $noticeObj->status = $request->status;

         $noticeObj->save();

         return redirect()->route('notice.index')->with('success', 'Notice Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        $noticeObj = Noticeboard::find($id);
        $noticeObj->delete();
        return redirect()->route('notice.index')->with('success', 'Notice Deleted Successfully');
    }

    public function calNotice(){
    
        $data = [];
        $allDept = Noticeboard::select('dept')->distinct('dept')->get();
  
        foreach($allDept as $dept){
            $dept = $dept->dept;
            $d = Noticeboard::where('dept', $dept)->count('dept');
            $depts[$dept] = $d;
        }
        
        $data['depts'] = $depts;
        $data['totalNotice'] = Noticeboard::all()->count();
    
        return view('admin.notice.calNotice', $data);
    }
}
