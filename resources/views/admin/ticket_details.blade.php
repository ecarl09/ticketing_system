@extends('layouts.adminMainLayouts')

@section('current-page-title') Ticket Details @endsection
@section('current-page-title-icon') fas fa-ticket-alt @endsection

@push('css')
<link href="{{asset('assets/fancybox/jquery.fancybox.min.css')}}" rel="stylesheet"> 
<link href="{{asset('assets/sweet-alert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('assets/summernote/summernote-bs4.css')}}" rel="stylesheet"> 
@endpush

<!-- @section('bread-crumb-button')
    <div class="col-md-4 col-lg-4">
        <div class="widgetbar">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#priorityModal">
                Change Priority
            </button>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#statusModal" id="statusModalId">
                Update Status
            </button>
        </div>                        
    </div>
@endsection -->


@section('adminContent')
<div class="row g-0">
    <div class="col-lg-8 pe-lg-2">
        <div class="card mb-3">
            <div class="card-header m-0 bg-light">
              <div class="row justify-content-between">
                <div class="col-md-auto">
                    <h5 class="text-primary">
                        Code [ <span id="ticketCode"></span> ]
                    </h5>
                </div>
                <div class="col-md-auto">
                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" id="modalPriorityBtn" data-bs-target="#priorityModal">Change Priority</button>
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" id="modalStatusBtn" data-bs-target="#statusModal">Update Status</button>
                    <a href="{{ route('print.ticket', ['ticketId' => $id ]) }}" target="_blank" class="btn btn-sm btn-secondary">Print</a>
                </div>
              </div>
            </div>
            <div class="card-body">
                <h6 class="text-primary">Details: </h6>

                <div class="row ps-3">
                    <div class="col-lg-4">
                        <h6 class="mb-0">Type:</h6>
                        <p class="fs--1 mb-0" id="ticket_type"></p>
                    </div>

                    <div class="col-lg-4">
                        <h6 class="mb-0">Priority:</h6>
                        <p class="fs--1 mb-0" id="ticket_priority"></p>
                    </div>

                    <div class="col-lg-4">
                        <h6 class="mb-0">Date Created:</h6>
                        <p class="fs--1 mb-0" id="ticket_date_created"></p>
                    </div>
                </div>

                <hr class="my-4" />
                <h6 class="text-primary">Client Information: </h6>

                <div class="row ps-3 mb-0">
                    <div class="col-lg-12">
                        <h6 class="mb-0">Chapter Name:</h6>
                        <p class="fs--1 mb-2" id="chapter_name"></p>
                    </div>
                    <div class="col-lg-12">
                        <h6 class="mb-0">Customer Name:</h6>
                        <p class="fs--1 mb-2" id="ticket_created_by_"></p>
                    </div>
                    <div class="col-lg-12">
                        <h6 class="mb-0">Email Address:</h6>
                        <p class="fs--1 mb-2" id="email"></p>
                    </div>
                    <div class="col-lg-12">
                        <h6 class="mb-0">Department:</h6>
                        <p class="fs--1 mb-2" id="department"></p>
                    </div>
                    <div class="col-lg-12">
                        <h6 class="mb-0">Anydesk ID:</h6>
                        <p class="fs--1 mb-0" id="anydesk"></p>
                    </div>
                </div>

                <hr class="my-4" />
                <h6 class="text-primary">Client Concern: </h6>
                
                <div class="row ps-3 mb-0">
                    <div class="col-lg-12">
                        <h6 class="mb-0">Narrative:</h6>
                        <p class="fs--1 mb-2" id="narrative"></p>
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
                    <!-- {{$ticketComment}} -->
                </div>

                <div id="comment-content"></div>
                <!-- <a class="fs--1 text-700 d-inline-block mt-2" href="#!">Load more comments (2 of 34)</a> -->

                <div class="border-top border-200 fs--1 py-3 mt-1">
                    <a class="text-700" href="#!">Your Comments:</a>
                </div>

                <form class="pb-3" action="{{route('send.comments')}}" id="form-comments" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="ticket_id" id="ticket_id" value="{{$id}}"  />

                    <div class="d-flex align-items-center" >
                        <textarea class="form-control fs--1" rows="6" style="resize: none;" name="comment" id="comment" placeholder="Write a comment..." ></textarea>
                    </div>

                    <div class="d-flex align-items-center mt-2 ">
                        <input class="form-control form-control-sm " id="file" name="file[]" type="file" multiple="multiple" accept="image/*" />
                    </div>

                    <a class="btn btn-secondary btn-md me-1 mt-2" href="{{route('admin.ticket.list')}}">Back</a>
                    <button class="btn btn-primary btn-md me-1 mt-2" type="submit" id="submit_button">Send</button>
                </form>
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
                                    <h6 class="text-800 mb-1" style=" text-transform: capitalize; " id="ticket_created_by"></h6>
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

    <div class="modal fade" id="priorityModal" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered mt-6" role="document">
            <div class="modal-content border-0">
                <div class="position-absolute top-0 end-0 mt-1 me-3 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
                        <h6 class="mb-1" id="staticBackdropLabel">Change Priority</h6>
                    </div>
                    <div class="p-4 text-center">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="priority1" name="priority" value="NORMAL" />
                            <label class="form-check-label" for="priority1">Normal</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="priority2" name="priority" value="MEDIUM" />
                            <label class="form-check-label" for="priority2">Medium</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="priority3" name="priority" value="URGENT" />
                            <label class="form-check-label" for="priority3">Urgent</label>
                        </div>

                        <input type="hidden" name="_token" id="csrf" value="{{Session::token()}}">

                        <div class="row no-gutters align-items-center justify-content-center p-2">
                            <h1 class="text-primary my-4" id="ticket_priority_"></h1>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-sm btn-primary update_priority" id="update_priority_id">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="statusModal" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered mt-6" role="document">
            <div class="modal-content border-0">
                <div class="position-absolute top-0 end-0 mt-1 me-3 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
                        <h6 class="mb-1" id="staticBackdropLabel">Update Status</h6>
                    </div>
                    <div class="p-4 text-center">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="status-1" name="status" value="ACTION TAKEN" />
                            <label class="form-check-label" for="status-1">ACTION TAKEN</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="status-2" name="status" value="AWAITING REPLY" />
                            <label class="form-check-label" for="status-2">AWAITING REPLY</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="status-3" name="status" value="ON HOLD" />
                            <label class="form-check-label" for="status-3">ON HOLD</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="status-4" name="status" value="RESOLVED" />
                            <label class="form-check-label" for="status-4">RESOLVED</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="status-5" name="status" value="CLOSED" />
                            <label class="form-check-label" for="status-5">CLOSED</label>
                        </div>

                        <input type="hidden" name="_token" id="csrf_status" value="{{Session::token()}}">

                        <div class="row no-gutters align-items-center justify-content-center p-2">
                            <h1 class="text-primary my-4" id="ticket_status_">OPENED</h1>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="feedback">FeedBack:</label>
                            <textarea class="form-control" name="feedback" id="feedback" rows="5" id="feedback"></textarea>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-sm btn-primary update_status_" id="update_status_">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    
</div>
@endsection

@push('javascript')

<!-- <script src="{{asset('assets/plugins/pnotify/js/pnotify.custom.min.js')}}"></script> -->

<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
<script src="{{asset('assets/fancybox/jquery.fancybox.min.js')}}"></script>
<script src="{{asset('assets/sweet-alert2/sweetalert2.min.js')}}"></script>
<script src="{{asset('assets/summernote/summernote-bs4.min.js')}}"></script>

<script>
    fetch_data();

    function fetch_data(){
        $.ajax({
            url     : '{{route("get.ticket.details", $id)}}',
            type    : 'get',
            dataType: 'json',
            success : function(response){
                var date = new Date(response[0]['created_at']);
                
                if(response[0]['status'] == "CLOSED" || response[0]['status'] == "RESOLVED"){
                    $("#modalPriorityBtn").prop("disabled", true);
                    $("#modalStatusBtn").prop("disabled", true);
                    $("#form-comments").hide();
                }
                
                $('#ticketCode').html(response[0]['ticket_code']);
                $('#ticket_type').html(response[0]['ticket_type']);
                $('#ticket_date_created').html(response[0]['date']);
                $('#ticket_date_created_').html(response[0]['date']);
                $('#ticket_priority').html(response[0]['priority']);
                $('#ticket_priority_').html(response[0]['priority']);
                $('ticket_status_').html(response[0]['status']);
                $('#ticket_created_by').html(response[0]['firstName']+' '+response[0]['lastName']);
                $('#ticket_created_by_').html(response[0]['firstName']+' '+response[0]['lastName']);
                $('#chapter_name').html(response[0]['chapterName']);
                $('#email').html(response[0]['email']);
                $('#department').html(response[0]['department']);
                $('#anydesk').html(response[0]['anydeskId']);
                $('#narrative').html(response[0]['narrative']);
                $('#ticket_id').attr('value',response[0]['id']);
            }
        });
    }
    
    fetch_status();

    function fetch_status(){

        $.ajax({
            url     : '{{route("get.ticket.status", $id)}}',
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
        var id           = '{{$id}}';
        var main_user_id = '{{Auth::user()["id"]}}';

        $.ajax({
            url     : '{{route("admin.get.comments")}}',
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
            url     : '{{route("admin.get.comments.attachements")}}',
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
            url     : '{{route("admin.delete.comments")}}',
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

        $('input[type=radio][name=priority]').change(function() {
            $('#ticket_priority_').html(this.value);
        });

        $('input[type=radio][name=status]').change(function() {
            $('#ticket_status_').html(this.value);
        });

        $(document).on('click', '.update_priority', function(){
            var data = {
                '_token'  : $("#csrf").val(),
                'id'      : '{{$id}}',
                'priority': $('input[name="priority"]:checked').val()
            }

            if($('input[name="priority"]:checked').val()){
                this.disabled=true;
                this.className='btn btn-sm btn-secondary';
                this.innerHTML='Updating . . .';

                $.ajax({
                    type    : "POST",
                    url     : '{{route("update.priority")}}',
                    data    : data,
                    dataType: "json",
                    success : function (response){
                        $('#ticket_priority').html($('input[name="priority"]:checked').val());
                        $('#priorityModal').modal('toggle');
                        swal({
                            title             : 'Success',
                            text              : 'Priority status updated to ' + $('input[name="priority"]:checked').val(),
                            type              : 'success',
                            showCancelButton  : false,
                            confirmButtonClass: 'btn btn-success',
                        })
                        $("#update_priority_id").prop("disabled", false); 
                        $("#update_priority_id").removeClass("btn-secondary").addClass("btn-primary update_priority");
                        $('#update_priority_id').html('Save changes');
                    },
                    error: function(data){
                        alert("Error")
                    }
                });
            }
        });

        $(document).on('click', '.update_status_', function(){

            var data = {
                '_token'  : $("#csrf_status").val(),
                'id'      : '{{$id}}',
                'status'  : $('input[name="status"]:checked').val(),
                'feedback': $('textarea#feedback').val()
            }

            if($('input[name="status"]:checked').val() && $('#feedback').val()){
                this.disabled=true;
                this.className='btn btn-sm btn-secondary';
                this.innerHTML='Updating . . .';

                $.ajax({
                    type    : "POST",
                    url     : '{{route("update.status")}}',
                    data    : data,
                    dataType: "json",
                    success : function (response){
                        if(response.message === 'success'){
                            fetch_status();

                            $('#statusModal').modal('toggle');

                            swal({
                                title             : 'Success',
                                text              : 'Ticket status updated to ' + $('input[name="status"]:checked').val(),
                                type              : 'success',
                                showCancelButton  : false,
                                confirmButtonClass: 'btn btn-success',
                            })

                            if($('input[name="status"]:checked').val() == "CLOSED" || $('input[name="status"]:checked').val() == "RESOLVED"){
                                $("#modalPriorityBtn").prop("disabled", true);
                                $("#modalStatusBtn").prop("disabled", true);
                                $("#form-comments").hide();
                            }

                            $("#update_status_").prop("disabled", false); 
                            $("#update_status_").removeClass("btn-secondary").addClass("btn-primary update_status_");
                            $('#update_status_').html('Save changes');
                        }else{
                            swal({
                                title             : 'Error!',
                                text              : 'Something went wrong. Please try again!',
                                type              : 'warning',
                                showCancelButton  : false,
                                confirmButtonClass: 'btn btn-success',
                            })

                            $('#statusModal').modal('toggle');

                            $("#update_status_").prop("disabled", false); 
                            $("#update_status_").removeClass("btn-secondary").addClass("btn-primary update_status_");
                            $('#update_status_').html('Save changes');
                        }
                    },error: function(data){
                        alert("Error")
                        console.log(data)
                    }
                });
            }else{
                swal({
                    title             : 'Oopss',
                    text              : 'Please fill out all the required fields.',
                    type              : 'warning',
                    showCancelButton  : false,
                    confirmButtonClass: 'btn btn-success',
                })
            }
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
                    url: "{{ route('admin-send.comments') }}",
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