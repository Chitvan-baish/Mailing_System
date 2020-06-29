@extends('layouts.app')

@section('content')


    @if (session('warning'))
        <div class="alert alert-warning" role="alert">
            <center>message not sent</center>
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-warning" role="alert">
            <center>message sent</center>
        </div>
    @endif


    <div class="tab" id="Inboxtab">
        <?php $i = 0; ?>
        @if($inboxes->isEmpty())
            <button class="tablinks">No mail available</button>
        @endif
        @foreach($inboxes->sortByDesc('created_at') as $inbox)
            @if($inbox->to === Auth::user()->email)
                <button class="tablinks" onclick="openCity(event, 'i{{$i++}}')"><b>{{$inbox->from}}</b><br>{{$inbox->subject}}
                    @if($inbox->attachment != 'nofile.jpg')
                        &nbsp;<i class="fa fa-paperclip"  aria-hidden="true"></i>
                    @endif
                    <p style="float: right">{{$inbox->created_at}}</p></button>
            @elseif($inbox->cc === Auth::user()->email)
                <button class="tablinks" onclick="openCity(event, 'i{{$i++}}')"><b>{{$inbox->from}}</b><br>{{$inbox->subject}}
                    @if($inbox->attachment != 'nofile.jpg')
                        &nbsp;<i class="fa fa-paperclip"  aria-hidden="true"></i>
                    @endif
                    <p style="float: right">{{$inbox->created_at}}</p></button>
            @elseif($inbox->bcc === Auth::user()->email)
                <button class="tablinks" onclick="openCity(event, 'i{{$i++}}')"><b>{{$inbox->from}}</b><br>{{$inbox->subject}}
                    @if($inbox->attachment != 'nofile.jpg')
                        &nbsp;<i class="fa fa-paperclip"  aria-hidden="true"></i>
                    @endif
                    <p style="float: right">{{$inbox->created_at}}</p></button>
                {{--@elseif($i === 0)--}}
                {{--<button class="tablinks" onclick="openCity(event, 'i')"><b>No mail</b></button>--}}
            @endif
        @endforeach
    </div>

    <div id="Inboxtabcontent">
        <?php $j = 0; ?>
        @foreach($inboxes->sortByDesc('created_at') as $inbox)
            @if($inbox->to === Auth::user()->email || $inbox->cc === Auth::user()->email || $inbox->bcc === Auth::user()->email)
                <div class="tabcontent" id="i{{$j++}}" hidden>
                    <b>From:&nbsp;</b> {{$inbox->from}}<br>
                    @if($inbox->to === Auth::user()->email)
                        @if($inbox->cc === "")
                            <b>To: &nbsp;</b>  <a href="#" data-toggle="tooltip" data-placement="bottom" title="compose" onclick="EditCompose('{{$inbox->to}}');"> {{$inbox->to}}</a><br>
                            <b>cc: &nbsp;</b>  <a href="#" data-toggle="tooltip" data-placement="bottom" title="compose" onclick="EditCompose('{{$inbox->cc}}');"> {{$inbox->cc}}</a><br>

                        @else
                            <b>To: &nbsp;</b><a href="#" data-toggle="tooltip" data-placement="bottom" title="compose" onclick="EditCompose('{{$inbox->to}}');"> {{$inbox->to}}</a><br>
                        @endif
                    @endif
                    @if($inbox->cc === Auth::user()->email)
                        @if($inbox->to !== "")
                            <b>To: &nbsp;</b><a href="#" data-toggle="tooltip" data-placement="bottom" title="compose" onclick="EditCompose('{{$inbox->to}}');"> {{$inbox->to}}</a><br>
                            <b>cc: &nbsp;</b><a href="#" data-toggle="tooltip" data-placement="bottom" title="compose" onclick="EditCompose('{{$inbox->cc}}');"> {{$inbox->cc}}</a><br>

                        @else
                            <b>To: &nbsp;</b>  <a href="#" data-toggle="tooltip" data-placement="bottom" title="compose" onclick="EditCompose('{{$inbox->cc}}');"> {{$inbox->cc}}</a><br>
                        @endif
                    @endif
                    @if($inbox->bcc === Auth::user()->email)
                        <b>bcc: &nbsp;</b>  <a href="#" data-toggle="tooltip" data-placement="bottom" title="compose" onclick="EditCompose('{{$inbox->bcc}}');"> {{$inbox->bcc}}</a><br>
                    @endif

                    @if($inbox->subject != "")
                        <h6><b>Subject: &nbsp;</b> {{$inbox->subject}}</h6><br>
                    @endif
                    @if($inbox->body != "")
                        <p>{{$inbox->body}}</p>
                    @endif
                    <br>
                    @if($inbox->attachment != 'nofile.jpg')
                        <img src="/storage/attachment/{{$inbox->attachment}}" width="20%"><br>
                        <a href="/storage/attachment/{{$inbox->attachment}}" download="{{$inbox->attachment}}">Download File</a>
                    @endif


                </div>
            @endif
        @endforeach
    </div>

<div class="tab" id="Senttab" hidden>
    <?php $i = 0; ?>
        @if($inboxes->isEmpty())
            <button class="tablinks">No mail available</button>
        @endif
    @foreach($inboxes->sortByDesc('created_at') as $inbox)
        @if($inbox->from === Auth::user()->email)

            @if($inbox->to !== "")
                    <button class="tablinks" onclick="openCity(event, 'j{{$i++}}')"><b>{{Auth::user()->name}}</b><br>To: {{$inbox->to}}
                        @if($inbox->attachment != 'nofile.jpg')
                            &nbsp;<i class="fa fa-paperclip"  aria-hidden="true"></i>
                        @endif
                        <p style="float: right">{{$inbox->created_at}}</p></button>
            @elseif($inbox->to === "" && $inbox->cc !== "")
                    <button class="tablinks" onclick="openCity(event, 'j{{$i++}}')"><b>{{Auth::user()->name}}</b><br>To: {{$inbox->cc}}
                        @if($inbox->attachment != 'nofile.jpg')
                            &nbsp;<i class="fa fa-paperclip"  aria-hidden="true"></i>
                        @endif
                        <p style="float: right">{{$inbox->created_at}}</p></button>
            @elseif($inbox->to === "" && $inbox->cc === "" &&$inbox->bcc !== "" )
                    <button class="tablinks" onclick="openCity(event, 'j{{$i++}}')"><b>{{Auth::user()->name}}</b><br>To: {{$inbox->bcc}}
                        @if($inbox->attachment != 'nofile.jpg')
                            &nbsp;<i class="fa fa-paperclip"  aria-hidden="true"></i>
                        @endif
                        <p style="float: right">{{$inbox->created_at}}</p></button>

            {{--@elseif($i === 0)--}}
            {{--<button class="tablinks" onclick="openCity(event, 'i')"><b>No mail</b></button>--}}
            @endif
        @endif
    @endforeach
</div>



<div id="Senttabcontent">
    <?php $j=0; ?>
    @foreach($inboxes->sortByDesc('created_at') as $inbox)
        @if($inbox->from === Auth::user()->email)
            <div class="tabcontent" id="j{{$j++}}" hidden>
                <b>From: &nbsp;</b> {{$inbox->from}}<br>
                @if($inbox->to != "")
                    <b>To: &nbsp;</b> <a href="#" data-toggle="tooltip" data-placement="bottom" title="compose" onclick="EditCompose('{{$inbox->to}}');"> {{$inbox->to}}</a><br>
                    @endif
                @if($inbox->cc != "")
                    <b>cc: &nbsp;</b> <a href="#" data-toggle="tooltip" data-placement="bottom" title="compose" onclick="EditCompose('{{$inbox->cc}}');"> {{$inbox->cc}}</a><br>
                @endif
                @if($inbox->bcc != "")
                    <b>bcc: &nbsp;</b> <a href="#" data-toggle="tooltip" data-placement="bottom" title="compose" onclick="EditCompose('{{$inbox->bcc}}');"> {{$inbox->bcc}}</a><br>
                @endif
                @if($inbox->subject != "")
                <h6><b>Subject: &nbsp;</b> {{$inbox->subject}}</h6><br>
                @endif
                @if($inbox->body != "")
                <p>{{$inbox->body}}</p>
                @endif
                <br>
                @if($inbox->attachment != 'nofile.jpg')
                <img src="/storage/attachment/{{$inbox->attachment}}" width="20%"><br>
                <a href="/storage/attachment/{{$inbox->attachment}}" download="{{$inbox->attachment}}">Download File</a>
                @endif
            </div>
        @endif
    @endforeach
</div>




<div class="tab" id="Drafttab" hidden>
    <?php $i = 0; ?>
    @if($drafts->isEmpty())
            <button class="tablinks">No mail available</button>
    @endif
    @foreach($drafts->sortByDesc('created_at') as $draft)
        @if($draft->from === Auth::user()->email)

            <button class="tablinks" onclick="openCity(event, 'k{{$i++}}')"><b>{{Auth::user()->name}}</b><br>{{$draft->body}}<p style="float: right">{{$draft->created_at}}</p></button>



        @endif
    @endforeach
</div>

<div id="Drafttabcontent">
    <?php $j=0; ?>
    @foreach($drafts->sortByDesc('created_at') as $draft)
        @if($draft->from === Auth::user()->email)
            <div class="tabcontent" id="k{{$j++}}" hidden>
                <b>From: &nbsp;</b> {{$draft->from}}<br>
                @if($draft->to != "")
                    <b>To: &nbsp;</b> {{$inbox->to}}<br>
                @endif
                @if($draft->cc != "")
                    <b>cc: &nbsp;</b> {{$draft->cc}}<br>
                @endif
                @if($draft->bcc != "")
                    <b>bcc: &nbsp;</b> {{$draft->bcc}}<br>
                @endif
                @if($draft->subject != "")
                    <h5><b>Subject: &nbsp;</b> {{$draft->subject}}</h5><br>
                @endif
                @if($draft->body != "")
                    <p>{{$draft->body}}</p>
                @endif

                <a href="#" onclick="EditDraft('{{$inbox->to}}','{{$draft->cc}}','{{$draft->bcc}}','{{$draft->subject}}','{{$draft->body}}');">Edit</a>


            </div>
        @endif
    @endforeach
</div>








<div class="container" id="compose" hidden>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                    <div class="container box">

                        <form method="post" action="{{action('EmailData@store')}}" enctype="multipart/form-data" autocomplete="off">
                            {{ csrf_field() }}
                            <div class="form-group" hidden>
                                <label>TO</label>
                                <input type="email" name="from" id="from" class="form-control" value="{{ Auth::user()->email }}" />
                            </div>
                            <div class="autocomplete">
                                <label>TO</label>
                                <input type="email" name="to" id="to" class="form-control" value="" />
                            </div>
                            <div class="form-group">
                                <label>cc</label>
                                <input type="email" name="cc" id="cc" class="form-control" value="" />
                            </div>
                            <div class="form-group">
                                <label>bcc</label>
                                <input type="email" name="bcc" id="bcc" class="form-control" value="" />
                            </div>
                            <div class="form-group">
                                <label>Attachment</label>
                                <input type="file" name="attachment" id="attachment" class="form-control" value="" />
                            </div>
                            <div class="form-group">
                                <label>Subject</label>
                                <input type="text" name="subject" id="subject" class="form-control" value="" />
                            </div>
                            <div class="form-group">
                                <label>Enter Your Message</label>
                                <textarea name="body" id="body1" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <input type="submit" name="send" class="btn btn-info" value="Send" />
                            </div>
                            <input type="button" id="defaultSubmit" value="submit" onclick="saveInDraft();" hidden>
                            <input type="reset" id="reset" hidden>
                        </form>

                    </div>

        </div>
    </div>
</div>
</div>

    <?php $l=0; ?>
    @foreach($inboxes as $inbox)
        <input type="hidden" id="l{{$l++}}" value="{{$inbox->to}}">
        @endforeach
    <input type="hidden" value="{{$l}}" id="m">




<form action="{{action('SaveDraftController@draft')}}" enctype="multipart/form-data" method="post" hidden>
    {{ csrf_field() }}
    <input type="email" id="defaultFrom" value="{{ Auth::user()->email }}" name="from">
    <input type="email" id="defaultTo" name="to">
    <input type="email" id="defaultCC" name="cc">
    <input type="email" id="defaultBCC" name="bcc">
    <input type="file" id="defaultAttachement" name="attachment">
    <input type="text" id="defaultSubject" name="subject">
    <textarea name="body" id="defaultBody" cols="30" rows="10"></textarea>
    <input type="submit" id="SubmitDraft">
</form>



@endsection
