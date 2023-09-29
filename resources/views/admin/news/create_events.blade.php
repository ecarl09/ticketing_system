@extends('layouts.adminMainLayouts')

@section('current-page-title') News and update @endsection
@section('current-page-title-icon') fas fa-calendar-day @endsection

@push('css')
<link href="{{asset('vendors/flatpickr/flatpickr.min.css')}}" rel="stylesheet" />
@endpush

@section('adminContent')

@if(session('success') == 'true')
  <div class="alert alert-success border-2 d-flex align-items-center" role="alert">
    <div class="bg-success me-3 icon-item"><span class="fas fa-check-circle text-white fs-3"></span></div>
    <p class="mb-0 flex-1">Your event has been posted!</p>
    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif


<form class="row g-2 needs-validation" method="POST" action="{{ route('save.events') }}" enctype="multipart/form-data">
  @csrf
  <div class="card cover-image mb-3">
      <img class="card-img-top" height="400px" style="object-fit: contain;" src="../../assets/img/generic/featuredImage.jpg" alt="" id="output"  />
      <input class="d-none" id="upload-cover-image" name="file" type="file" accept="image/*" onchange="loadFile(event)" />
      <div class="invalid-feedback" style="display: block;">@error('featuredImage'){{$message}}@enderror</div>
      <label class="cover-image-file-input" for="upload-cover-image">
          <span class="fas fa-camera me-2"></span>
          <span>Upload featured image</span>
      </label>
  </div>

  <div class="row g-0">
    <div class="col-lg-8 pe-lg-2">
      <div class="card mb-3">
        <div class="card-header">
            <h5 class="mb-0">Event Details</h5>
        </div>
        <div class="card-body bg-light">
          <div class="row gx-2">
            <div class="col-12 mb-3">
                <label class="form-label" for="event-name">Event Title</label>
                <input class="form-control" id="event-name" name="title" type="text" value="{{ old('title') }}" placeholder="Event Title" />
                <div class="invalid-feedback" style="display: block;">@error('title'){{$message}}@enderror</div>
            </div>
            <div class="col-12 mb-3">
              <div class="min-vh-50">
                  <label class="form-label" for="event-content">Event Description</label>
                  <textarea class="tinymce d-none" id="event-content" name="content">{{ old('content') }}</textarea>
                  <div class="invalid-feedback" style="display: block;">@error('content'){{$message}}@enderror</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4 ps-lg-2">
      <div class="sticky-sidebar">
        <div class="card mb-lg-0">
          <div class="card-header">
            <h5 class="mb-0">Other Info</h5>
          </div>
          <div class="card-body bg-light">
            <div class="mb-3">
              <div class="d-flex justify-content-between align-items-center">
                <label class="mb-0" for="event-date">Event Date</label>
              </div>
              <input class="form-control datetimepicker" id="event-date" name="eventDate" value="{{ old('eventDate') }}" type="text" placeholder="m/d/y" data-options='{"disableMobile":true,"dateFormat":"m/d/Y"}' />
              <div class="invalid-feedback" style="display: block;">@error('eventDate'){{$message}}@enderror</div>
            </div>

            <div class="mb-3">
              <div class="d-flex justify-content-between align-items-center">
                <label class="mb-0" for="event-time">Event Time</label>
              </div>
              <input class="form-control datetimepicker" id="event-time" name="eventTime" value="{{ old('eventTime') }}" type="text" placeholder="H:i" data-options='{"enableTime":true,"noCalendar":true,"dateFormat":"H:i","disableMobile":true}' />
              <div class="invalid-feedback" style="display: block;">@error('eventTime'){{$message}}@enderror</div>
            </div>

            <div class="border-dashed-bottom my-3"></div>
            <div class="mb-3">
              <div class="d-flex justify-content-between align-items-center">
                <label class="mb-0" for="event-price">Price</label>
              </div>
              <input type="name" class="form-control" id="event-price" name="eventPrice" value="{{ old('eventPrice') }}" placeholder="0.00"  />
              <div class="invalid-feedback" style="display: block;">@error('eventPrice'){{$message}}@enderror</div>
            </div>

            <div class="border-dashed-bottom my-3"></div>
            <div class="mb-3">
              <div class="d-flex justify-content-between align-items-center">
                <label class="mb-0" for="event-venue">Venue</label>
              </div>
              <input type="text" class="form-control" id="event-venue" name="eventVenue" value="{{ old('eventVenue') }}" placeholder="Event Venue" />
              <div class="invalid-feedback" style="display: block;">@error('eventVenue'){{$message}}@enderror</div>
            </div>
            <div class="mb-3">
              <div class="d-flex justify-content-between align-items-center">
                <label class="mb-0" for="event-address">Address</label>
              </div>
              <input type="text" class="form-control" id="event-address" name="eventAddress" value="{{ old('eventAddress') }}"  placeholder="Event Address" />
              <div class="invalid-feedback" style="display: block;">@error('eventAddress'){{$message}}@enderror</div>
            </div>

            <h6>Comments</h6>
            <div class="form-check custom-checkbox mb-0">
              <input class="form-check-input" id="customRadio6" type="checkbox" value="{{ old('isComments') }}" name="isComments">
              <label class="form-label mb-0" for="customRadio6">Allow comments in the news feed?</label>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-body">
      <div class="row justify-content-between align-items-center">
        <div class="col-md">
          <h5 class="mb-2 mb-md-0">Nice Job! You're almost done</h5>
        </div>
        <div class="col-auto">
          <button type="submit" class="btn btn-primary me-2" onmouseup="this.form.submit(); this.disabled=true; this.className='btn btn-secondary me-2'; this.innerHTML='Saving . . .'; " >Save</button>
        </div>
      </div>
    </div>
  </div>
</form>
@endsection

@push('javascript')

<script src="{{asset('assets/jquery.min.js')}}"></script>
<script src="{{asset('vendors/tinymce/tinymce.min.js')}}"></script>
<script src="{{asset('assets/js/flatpickr.js')}}"></script>

<script>
    var loadFile = function(event) {
        var image = document.getElementById('output');
        image.src = URL.createObjectURL(event.target.files[0]);
    };
</script>
@endpush