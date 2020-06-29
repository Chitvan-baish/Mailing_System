<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StoreEmailData;
use Illuminate\Support\Facades\Auth;
use App\User;
use Mail;

class mailController extends Controller
{
    public function index(){
        $part = StoreEmailData::all();

    }
    public function send()
    {
//        $part = StoreEmailData::all();

        Mail::send(['text'=>'mail'],['name'=>'chitvan'],function ($message){
            $message->to('baishchitvan@gmail.com','to chitavn')->subject('hello');
            $message->cc('ashokkr2906@gmail.com','to chitvan')->subject('hello');
            $message->bcc('dilip.baish71@gmail.com','to chitvan')->subject('hello');
            $message->from(Auth::user()->email);
    });
    }
}
