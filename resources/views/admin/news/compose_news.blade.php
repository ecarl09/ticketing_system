@extends('layouts.adminMainLayouts')

@section('current-page-title') News and update @endsection
@section('current-page-title-icon') far fa-newspaper @endsection

@push('css')
    <link href="{{asset('vendors/flatpickr/flatpickr.min.css')}}" rel="stylesheet" />
@endpush

@section('adminContent')

@if(session('success') == 'true')
    <div class="alert alert-success border-2 d-flex align-items-center" role="alert">
        <div class="bg-success me-3 icon-item"><span class="fas fa-check-circle text-white fs-3"></span></div>
        <p class="mb-0 flex-1">Your news has been posted!</p>
        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card cover-image mb-3">
      <img class="card-img-top" height="400px" style="object-fit: contain;" src="../../assets/img/generic/featuredImage.jpg" alt="" id="output"  />
      
      <div class="invalid-feedback" style="display: block;">@error('featuredImage'){{$message}}@enderror</div>
      <label class="cover-image-file-input" for="upload-cover-image">
          <span class="fas fa-camera me-2"></span>
          <span>Upload featured image</span>
      </label>
  </div>

<div class="card">
    <div class="card-header bg-light overflow-hidden">
        <div class="d-flex align-items-center">
            <div class="avatar avatar-m">
                <img class="rounded-circle" src="{{asset('/storage/profile_picture/'.Auth::user()['profile_picture'])}}" alt="" />
            </div>
            <div class="flex-1 ms-2">
                <h5 class="mb-0 fs-0">Create news</h5>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <form method="post" action="{{route('save.news.form')}}" id="news-form" enctype="multipart/form-data">
            @csrf
            <input class="d-none" id="upload-cover-image" name="file" type="file" accept="image/*" onchange="loadFile(event)" />

            <div class="border border-top-0 border-200">
                <input class="form-control border-0 rounded-0 outline-none px-card" type="name" name="title" id="title" placeholder="Title" />
                <div class="invalid-feedback" id="title-feedback" >This field is required!</div>
            </div>
            <div class="min-vh-50">
                <textarea class="tinymce d-none" name="content" id="content" placeholder="What do you want to talk about?"></textarea>
                <div class="invalid-feedback" id="content-feedback" >This field is required!</div>
            </div>
            <div id="attachement-container"></div>
        </form>

        <div class="bg-light px-card py-3">
            <div class="d-inline-flex flex-column" id="dynamicImageTitle"></div>
        </div>
    </div>
    <div class="card-footer border-top border-200 d-flex flex-between-center">
        <div class="d-flex align-items-center">
            <button class="btn btn-primary btn-sm px-5 me-2" type="button" id="save_news_form" >Publish</button>
            <form method="POST" enctype="multipart/form-data" id="addAttachement">
                @csrf
                <input type="file" accept="image/*" id="addDynamicImage" name="addDynamicImage" class="d-none fileUploader"  />
            </form>
            <button class="btn btn-light btn-sm rounded-pill shadow-none d-inline-flex align-items-center fs--1 mb-0 me-1" type="button" id="OpenImgUpload">
                <img class="cursor-pointer" src="../../assets/img/icons/spot-illustrations/image.svg" width="17" alt="" />
                <span class="ms-2 d-none d-md-inline-block">Image</span>
            </button>
        </div>
        <div class="d-flex align-items-center">
            <div class="form-check custom-checkbox mb-0">
                <input class="form-check-input" id="customRadio6" type="checkbox" name="isComments">
                <label class="form-label mb-0" for="customRadio6">Allow comments in the news feed?</label>
            </div>
        </div>
    </div>
</div>
@endsection

@push('javascript')
<script src="{{asset('assets/jquery.min.js')}}"></script>
<script src="{{asset('vendors/tinymce/tinymce.min.js')}}"></script>

<script>
var imageID = 0 ; 

var loadFile = function(event) {
        var image = document.getElementById('output');
        image.src = URL.createObjectURL(event.target.files[0]);
    };

$(document).ready(function(){
    //open image browser to attache image
    $('#OpenImgUpload').click(function(){ 
        $('#addDynamicImage').trigger('click');
    });

    //remove pre attach image
    $(document).on('click', '.remove_image', function(){  
        var button_id = $(this).attr("id");

        $.ajax({
            url     : '{{route("remove.pre.attach.image")}}',
            type    : 'post',
            data    :  {id:button_id,'_token':"{{csrf_token()}}"},
            dataType: 'json',
            success : function(response){
                $('#'+button_id).remove(); 
                $('#attachementToUpdate-'+button_id).remove(); 
                console.log(response)
            },error: function(data){
                alert("Error")
            }
        });
    });

    //save pre attach image in the database
    $(".fileUploader").on("change", function(e){
        var formData = new FormData( $("#addAttachement")[0] );
        var attachement = '';
        var attachement_container = '';
        imageID++;

        $.ajax({
            type: "post",
            url: "{{ route('save.image.attachement') }}",
            data: formData,
            contentType: false,
            processData: false,
            success: function(data){
                //append to div
                attachement+='<div class="border px-2 rounded-3 d-flex flex-between-center bg-white dark__bg-1000 my-1 fs--1 mx-2 remove_image" id="dynamic-image-'+data.id+'">';
                    attachement+='<span class="fs-1 far fa-image"></span>';
                    attachement+='<span class="ms-2">'+e.target.files[0].name+'</span>';
                    attachement+='<a class="text-300 p-1 ms-6 remove_image" href="#!" data-bs-toggle="tooltip" data-bs-placement="right" title="Detach" id="'+data.id+'">';
                        attachement+='<span class="fas fa-times"></span>';
                    attachement+='</a>';
                attachement+='</div>';

                $("#dynamicImageTitle").append(attachement); 

                attachement_container+='<input type="name" class="d-none" id="attachementToUpdate-'+data.id+'" name="attachementToUpdate[]" value="'+data.id+'">';
                $("#attachement-container").append(attachement_container); 
            },error: function(data){
                alert("Error")
            }
        });
    })

    //save news to db
    $('#save_news_form').click(function(){
        tinyMCE.triggerSave();

        if(!$('#title').val()){
            $( "#title-feedback" ).addClass( "d-block" );
        }else if(!$('#content').val()){
            $( "#content-feedback" ).addClass( "d-block" );
        }else{
            $('#news-form').submit();
        }
    });
});
</script>
@endpush