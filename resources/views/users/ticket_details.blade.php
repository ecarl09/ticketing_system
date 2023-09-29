@extends('layouts.UsersMainLayouts')

@section('current-page-title') Ticket Details @endsection
@section('current-page-title-icon') fas fa-ticket-alt @endsection

@push('css')
<link href="{{asset('assets/fancybox/jquery.fancybox.min.css')}}" rel="stylesheet"> 
<link href="{{asset('assets/summernote/summernote-bs4.css')}}" rel="stylesheet"> 
<!-- <link href="{{asset('assets/plugins/pnotify/css/pnotify.custom.min.css')}}" rel="stylesheet"> 
 -->
@endpush


@section('usersContent')
<div class="row g-0">
    <div class="col-lg-8 pe-lg-2">
        <div class="card mb-3">
            <div class="card-header m-0 bg-light">
              <div class="row justify-content-between">
                <div class="col-md-auto">
                    <input type="hidden" name="ticketId" id="ticketId" value="{{ $list[0]->id }}" />
                    {{ $list[0]->ticket_code  }}
                </div>
                <div class="col-md-auto">
                    <a href="{{ route('print.ticket.reports', ['ticketId' => $list[0]->id ]) }}" target="_blank" class="btn btn-sm btn-primary">Print</a>
                </div>
              </div>
            </div>
            <div class="card-body">
                <h6 class="text-primary">Details: </h6>

                <div class="row ps-3">
                    <div class="col-lg-4">
                        <h6 class="mb-0">Type:</h6>
                        <p class="fs--1 mb-0">{{ $list[0]->ticket_type }}</p>
                    </div>

                    <div class="col-lg-4">
                        <h6 class="mb-0">Date Created:</h6>
                        <p class="fs--1 mb-0">{{ date("F d, Y, h:i A", strtotime($list[0]->created_at)) }}</p>
                    </div>
                </div>

                <div class="row ps-3 mt-3">
                    <div class="col-lg-4">
                        <h6 class="mb-0">Status:</h6>
                        <p class="fs--1 mb-0">
                            @if($list[0]->status == 'NEW')
                                <span class="badge rounded-pill bg-secondary">{{ $list[0]->status }}</span>
                            @elseif($list[0]->status == 'OPENED')
                                <span class="badge rounded-pill bg-primary">{{ $list[0]->status }}</span>
                            @elseif($list[0]->status == 'ACTION TAKEN')
                                <span class="badge rounded-pill bg-warning">{{ $list[0]->status }}</span>
                            @elseif($list[0]->status == 'AWAITING REPLY')
                                <span class="badge rounded-pill bg-info">{{ $list[0]->status }}</span>
                            @elseif($list[0]->status == 'ON HOLD')
                                <span class="badge rounded-pill bg-danger">{{ $list[0]->status }}</span>
                            @elseif($list[0]->status == 'RESOLVED')
                                <span class="badge rounded-pill bg-success">{{ $list[0]->status }}</span>
                            @elseif($list[0]->status == 'CLOSED')
                                <span class="badge rounded-pill bg-success">{{ $list[0]->status }}</span>
                            @endif
                        </p>
                    </div>
                    <div class="col-lg-4">
                        <h6 class="mb-0">Priority:</h6>
                        <p class="fs--1 mb-0">
                            @if($list[0]->priority == 'NORMAL')
                                <span class="badge rounded-pill bg-primary">{{ $list[0]->priority }}</span>
                            @elseif($list[0]->priority == 'MEDIUM')
                                <span class="badge rounded-pill bg-warning">{{ $list[0]->priority }}</span>
                            @elseif($list[0]->priority == 'URGENT')
                                <span class="badge rounded-pill bg-danger">{{ $list[0]->priority }}</span>
                            @endif
                        </p>
                    </div>
                    <div class="col-lg-4">
                        <h6 class="mb-0">Date Updated:</h6>
                        <p class="fs--1 mb-0">{{ date("F d, Y, h:i A", strtotime($list[0]->updated_at)) }}</p>
                    </div>
                </div>

                <hr class="my-4" />
                <h6 class="text-primary">Client Information: </h6>

                <div class="row ps-3 mb-0">
                    <div class="col-lg-12">
                        <h6 class="mb-0">Chapter Name:</h6>
                        <p class="fs--1 mb-2">{{ $list[0]->chapterName }}</p>
                    </div>
                    <div class="col-lg-12">
                        <h6 class="mb-0">Customer Name:</h6>
                        <p class="fs--1 mb-2">{{ ucwords($list[0]->firstName).' '.ucwords($list[0]->lastName)}}</p>
                    </div>
                    <div class="col-lg-12">
                        <h6 class="mb-0">Email Address:</h6>
                        <p class="fs--1 mb-2">{{ $list[0]->email }}</p>
                    </div>
                    <div class="col-lg-12">
                        <h6 class="mb-0">Department:</h6>
                        <p class="fs--1 mb-2">{{ $list[0]->department }}</p>
                    </div>
                    <div class="col-lg-12">
                        <h6 class="mb-0">Anydesk ID:</h6>
                        <p class="fs--1 mb-0">{{ $list[0]->anydeskId }}</p>
                    </div>
                </div>

                <hr class="my-4" />
                <h6 class="text-primary">Client Concern: </h6>
                
                <div class="row ps-3 mb-0">
                    <div class="col-lg-12">
                        <h6 class="mb-0">Narrative:</h6>
                        <p class="fs--1 mb-2">{!! $list[0]->narrative !!}</p>
                    </div>
                    <div class="col-lg-12">
                        <h6 class="mb-2">Attachment:</h6>
                        @foreach($attachements as $data)
                            <div class="avatar avatar-3xl mx-1">
                                <a href="{{asset('/storage/ticket_attachments/'.$data->file_name)}}" data-fancybox="gallery"" >
                                    <img class="rounded-soft" src="{{asset('/storage/ticket_attachments/'.$data->file_name)}}" alt="" />
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>

            <div class="card-footer bg-light pt-0">
                <div class="border-bottom border-200 fs--1 py-3">
                    <a class="text-700" href="#!">Comments</a>
                </div>

                <div id="comment-content"></div>
                <!-- <a class="fs--1 text-700 d-inline-block mt-2" href="#!">Load more comments (2 of 34)</a> -->

                <div class="border-top border-200 fs--1 py-3 mt-1">
                    <a class="text-700" href="#!">Your Comments:</a>
                </div>

                @if($list[0]->status != 'RESOLVED')
                <form class="pb-3" action="{{route('send.comments')}}" id="form-comments" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="ticket_id" id="ticket_id" value="{{ $list[0]->id }}" />

                    <div class="d-flex align-items-center" >
                        <textarea class="form-control fs--1" rows="3" style="resize: none;" name="comment" id="comment" placeholder="Write a comment..." ></textarea>
                    </div>

                    <div class="d-flex align-items-center mt-2 ">
                        <input class="form-control form-control-sm " id="file" name="file[]" type="file" multiple="multiple" accept="image/*" />
                    </div>

                    <button type="button" class="btn btn-secondary btn-md me-1 mt-2" onclick="history.back()">Back</button>
                    <button class="btn btn-primary btn-md me-1 mt-2" type="submit" id="submit_button">Send</button>
                </form>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="sticky-sidebar">
            <div class="card sticky-top">
                <div class="card-header border-bottom">
                    <h6 class="mb-0 fs-0">Ticket Status</h6>
                </div>
                <div class="card-body scrollbar  ps-2">
                    <div class="row g-3 timeline timeline-primary timeline-past pb-card">
                        <div class="col-auto ps-4 ms-2">
                            <div class="ps-2">
                                <div class="icon-item icon-item-sm rounded-circle bg-200 shadow-none"><span class="text-primary fas fa-ticket-alt"></span></div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="row gx-0 border-bottom pb-card">
                                <div class="col">
                                    <h6 class="text-800 mb-1" style=" text-transform: capitalize; " >{{ date("F d, Y, h:i A", strtotime($list[0]->created_at)) }}</h6>
                                    <p class="fs--1 text-600 mb-0">New</p>
                                </div>
                                <div class="col-auto">
                                    <p class="fs--2 text-500 mb-0" id="ticket_date_created_"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="all_ticket_status"> </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('javascript')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<script src="{{asset('assets/fancybox/jquery.fancybox.min.js')}}"></script>
<script src="{{asset('assets/summernote/summernote-bs4.min.js')}}"></script>
<script>
    fetch_status();

    function fetch_status(){
        var id           = document.getElementById('ticketId').value;

        $.ajax({
            url     : '{{route("user.get.ticket.status", $list[0]->id)}}',
            type    : 'get',
            dataType: 'json',
            success : function(response){
                var bodyData = '';
                $('#all_ticket_status').empty();
                
                $.each(response,function(index,row){
                    var text_color = "";
                    var text_color = "text-primary"

                    if(row.status == 'OPENED'){ 
                        icon = "far fa-eye"
                    }else if(row.status == 'AWAITING REPLY'){ 
                        icon = "fab fa-rocketchat"
                    }else if(row.status == 'ACTION TAKEN'){ 
                        icon = "fas fa-wrench"
                    }else if(row.status == 'ON HOLD'){
                        icon = "fas fa-hand-paper"
                    }else{
                        icon = "far fa-check-circle"
                    }

                    bodyData+='<div class="row g-3 timeline timeline-primary timeline-past pb-card">';
                        bodyData+='<div class="col-auto ps-4 ms-2">';
                            bodyData+='<div class="ps-2">';
                                bodyData+='<div class="icon-item icon-item-sm rounded-circle bg-200 shadow-none"><span class="'+text_color+' '+icon+' "></span></div>';
                            bodyData+='</div>';
                        bodyData+='</div>';
                        bodyData+='<div class="col">';
                            bodyData+='<div class="row gx-0 border-bottom pb-card">';
                                bodyData+='<div class="col">';
                                    bodyData+='<h6 class="text-800 mb-1">'+row.user_name+'</h6>';
                                    bodyData+='<p class="fs--1 text-500 mb-0">'+row.status+'</p>';
                                bodyData+='</div>';
                                bodyData+='<div class="col-auto">';
                                    bodyData+='<p class="fs--2 text-500 mb-0">'+row.date+'</p>';
                                bodyData+='</div>';
                                    if(row.feedback == '<p><br></p>' || row.feedback == ''){
                                        
                                    }else{
                                        bodyData+='<p class="fs--1 text-500 mb-0">'+row.feedback+'</p>';
                                    }
                            bodyData+='</div>';
                        bodyData+='</div>';
                    bodyData+='</div>';
                })

                $("#all_ticket_status").append(bodyData);
            }
        }); 
    }

    get_comments();

    function get_comments(){
        var id           = document.getElementById('ticketId').value;
        var main_user_id = '{{Auth::user()["id"]}}';

        $.ajax({
            url     : '{{route("get.comments")}}',
            type    : 'post',
            data    :  {id:id,'_token':"{{csrf_token()}}"},
            dataType: 'json',
            success : function(response){
                $('#comment-content').empty();

                $.each(response,function(index,row){
                    var bodyData = '';

                    bodyData+='<div class="d-flex mt-3">';
                        bodyData+='<div class="avatar avatar-xl">';
                            bodyData+='<img class="rounded-circle" src="{{asset("/storage/profile_picture")}}/'+row.profile_picture+'" alt="" />';
                        bodyData+='</div>';
                        bodyData+='<div class="flex-1 ms-2 fs--1">';
                            bodyData+='<p class="mb-1 bg-200 rounded-3 p-2">';
                                bodyData+='<a class="fw-semi-bold" href="#!">'+row.sender+'</a> ';
                                bodyData+='<br>';
                                bodyData+=''+row.comments+'';
                            bodyData+='</p>';

                            bodyData+='<div id="images-'+row.id+'"></div>';

                            bodyData+='<div class="px-2">';
                                main_user_id === row.user_id ? bodyData+='<a href="#!" onclick="deleteComment('+row.id+')">Delete</a> ' : null;
                                bodyData+='&bull; '+row.date+' ';
                            bodyData+='</div>';
                        bodyData+='</div>';
                    bodyData+='</div>';

                    $("#comment-content").append(bodyData);
                    get_attachements(row.id);
                })
            },
            error: function(data){
                alert("Error")
            }
        }); 
    }

    function get_attachements(id){
        $.ajax({
            url     : '{{route("get.comments.attachements")}}',
            type    : 'post',
            data    :  {id:id,'_token':"{{csrf_token()}}"},
            dataType: 'json',
            success : function(response){    
                $.each(response,function(index,row){
                    var bodyData = '';

                    bodyData+='<div class="avatar avatar-3xl mx-1">';
                        bodyData+='<a href="{{asset("/storage/ticket_comments_attachenent")}}/'+row.file_name+'" data-fancybox="gallery" >';
                            bodyData+='<img class="rounded-soft" src="{{asset("/storage/ticket_comments_attachenent")}}/'+row.file_name+'" alt="" />';
                        bodyData+='</a>'; 
                    bodyData+='</div>';

                    $('#images-'+id).append(bodyData);
                })
            },
            error: function(data){
                alert("Error")
            }
        }); 
    }

    function deleteComment(id){
        $.ajax({
            url     : '{{route("delete.comments")}}',
            type    : 'post',
            data    :  {id:id,'_token':"{{csrf_token()}}"},
            dataType: 'json',
            success : function(response){
                // new PNotify( {title: 'Success', text: 'Comment has been removed!', type: 'success'});
                get_comments();
            },error: function(data){
                alert("Error")
            }
        });
    }

    $(document).ready(function(){
        $('#comment').summernote({
            toolbar: [
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['para', ['ul', 'ol']],
            ['insert', ['link']],
            ['undo', ['undo', 'redo']],
            ],
            styleTags: ['h1', 'h2'],
            minHeight: 200,
            width: '100%'
        });

        $('#form-comments').submit(function(e) {
            e.preventDefault();

            if($('textarea#comment').val() || $("#file")[0].files.length >= 1){
                $("#submit_button").prop("disabled", true); 
                $("#submit_button").removeClass("btn-primary").addClass("btn-secondary");
                $('#submit_button').html('Sending . . .');

                let formData = new FormData(this);

                $.ajax({
                    type: "post",
                    url: "{{ route('send.comments') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data){
                        // new PNotify({title: 'Success', text: 'Comment has been added!', type: 'success'});

                        $("#file").val(null);
                        // $("div.gallery").html("");
                        // document.getElementById('remove_image_button').style.display = 'none';

                        $("#submit_button").prop("disabled", false); 
                        $("#submit_button").removeClass("btn-secondary").addClass("btn-primary");
                        $('#submit_button').html('Save');

                        // $("#comment").summernote("reset");
                        document.getElementById("comment").value = "";
                        get_comments();
                    },error: function(data){
                        alert("Error")
                        console.log(data)
                    }
                });
            }
        });
    });
</script>
@endpush