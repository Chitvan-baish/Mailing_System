<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SaveDraft;

class SaveDraftController extends Controller
{
    public function draft(Request $request){
        if($request->hasFile('attachment')){
            //get filename with the extension
            $filenameWithExt = $request->file('attachment')->getClientOriginalName();
            //get just filename
            $filename = pathinfo($filenameWithExt,PATHINFO_FILENAME);
            //get ext
            $extension = $request->file('attachment')->getClientOriginalExtension();


            //file name to store
            $fileNameToStore = $filename.'_'.time().'_'.$extension;

            //upload file

            $path = $request->file('attachment')->storeAs('public/attachment',$fileNameToStore);
            $path1 = $request->file('attachment')->storeAs('storage/attachment',$fileNameToStore);

        }else{
            $fileNameToStore = 'nofile.jpg';
        }

        $part = new SaveDraft();
        $part->from = $request->input('from');
        $part->to = $request->input('to');
        $part->cc= $request->input('cc');
        $part->bcc = $request->input('bcc');
        $part->attachment = $fileNameToStore;
        $part->subject = $request->input('subject');
        $part->body = $request->input('body');
        $part->save();
        return redirect('/home');
    }
}
