<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StoreEmailData;
use Psy\Util\Str;
use Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\SendMail;
use App\SaveDraft;
use Illuminate\Support\Facades\Storage;
class EmailData extends Controller
{

    public function index(){
        $inboxes = StoreEmailData::all();
        $drafts = SaveDraft::all();
        return view('home',compact('inboxes','drafts'));
    }
    public function store(Request $request){

        //handle file upload
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

        $part = new StoreEmailData();
        $part->from = $request->input('from');
        $part->to = $request->input('to');
        $part->cc= $request->input('cc');
        $part->bcc = $request->input('bcc');
        $part->attachment = $fileNameToStore;
        $part->subject = $request->input('subject');
        $part->body = $request->input('body');

        if($fileNameToStore == 'nofile.jpg')
            $data = array(
                'from'=>$request->from,
                'to' => $request->to,
                'cc' => $request->cc,
                'bcc' => $request->bcc,
                'attachment'=>$fileNameToStore,
                'subject' => $request->subject,
                'body' => $request->body
            );
        if($fileNameToStore != 'nofile.jpg')
            $data = array(
                'from'=>$request->from,
                'to' => $request->to,
                'cc' => $request->cc,
                'bcc' => $request->bcc,
                'attachment' => $path1,
                'subject' => $request->subject,
                'body' => $request->body
            );

        if($data['to'] != '' and $data['cc'] != '' and $data['bcc'] != '')
            Mail::to($data['to'])->cc($data['cc'])->bcc($data['bcc'])->send(new SendMail($data));
        if($data['to'] != '' and $data['cc'] != '' and $data['bcc'] == '')
            Mail::to($data['to'])->cc($data['cc'])->send(new SendMail($data));
        if($data['to'] != '' and $data['cc'] == '' and $data['bcc'] == '')
            Mail::to($data['to'])->send(new SendMail($data));
        if($data['to'] == '' and $data['cc'] == '' and $data['bcc'] == '')
            return redirect('/home')->with('warning','message not sent');
//        Mail::send(['text'=>'mail'],$data,function ($message) use ($data){
//
//            if($data['to'] != "")
//                $message->to($data['to']);
//            if($data['cc'] != "")
//                $message->cc($data['cc']);
//            if($data['bcc'] != "")
//                $message->bcc($data['bcc']);
//
//            if($data['subject'] != "")
//                $message->subject($data['subject']);
//
////            $message->attach(public_path('\storage\attachment',$data['attachment']));
//            $message->from(Auth::user()->email);
//        });

        $part->save();
//        foreach($inboxes as key=>$inbox)
//            $data = array(
//                [key=>$inbox],
//            );

        return redirect('/home')->with('success','message sent');
    }



}
