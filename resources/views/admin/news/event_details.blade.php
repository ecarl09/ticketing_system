@extends('layouts.adminMainLayouts')

@section('current-page-title') Event details @endsection
@section('current-page-title-icon') far fa-newspaper @endsection

@push('css')
    <link href="{{asset('vendors/glightbox/glightbox.min.css')}}" rel="stylesheet" />
@endpush

@section('adminContent')
    <div class="card mb-3">
        <a href="{{asset('/storage/featured_image').'/'.$news[0]->featuredImage}}" data-gallery="gallery-2">
            <img class="card-img-top" height="400px" style="object-fit: cover;" src="{{asset('/storage/featured_image').'/'.$news[0]->featuredImage}}" alt="" />
        </a>
        <div class="card-body">
            <div class="row justify-content-between align-items-center">
                <div class="col">
                    <div class="d-flex">
                        <div class="calendar me-2"><span class="calendar-month">{{date("M", strtotime($events[0]->eventDate))}}</span><span class="calendar-day">{{date("d", strtotime($events[0]->eventDate))}} </span></div>
                        <div class="flex-1 fs--1">
                            <h5 class="fs-0">{{$news[0]->title}}</h5>
                            <p class="mb-0">by <a href="#!">{{$news[0]->author}} | {{date("F d, Y", strtotime($news[0]->created_at))}} &bull; {{date("h:i A", strtotime($news[0]->created_at))}} | {{$news[0]->category}}</a></p>
                            <span class="fs-0 text-warning fw-semi-bold" style="text-transform: capitalize; ">{{$events[0]->eventPrice}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-0">
        <div class="col-lg-8 pe-lg-2">
            <div class="card mb-3 mb-lg-0">
                <div class="card-body">
                    <h5 class="fs-0 mb-3">{{$news[0]->title}}</h5>
                    <p>{!! $news[0]->content !!}</p>
                </div>
            </div>
        </div>

        <div class="col-lg-4 ps-lg-2">
            <div class="sticky-sidebar">
            <div class="card mb-3 fs--1">
                <div class="card-body">
                    <h6>Date And Time</h6>
                    <p class="mb-1">{{date("D, F d, Y", strtotime($events[0]->created_at))}} - {{date("h:i A", strtotime($events[0]->created_at))}}</p>

                    <h6 class="mt-4">Venue</h6>
                    <p class="mb-1" style="text-transform: capitalize; ">{{$events[0]->eventVenue}}</p>

                    <h6 class="mt-4">Location</h6>
                    <div class="mb-1" style="text-transform: capitalize; ">{{$events[0]->eventAddress}}</div>
                
                    <h6 class="mt-4">Event Fee</h6>
                    <p class="fs--1 mb-0" style="text-transform: capitalize; ">{{$events[0]->eventPrice}}</p>
                </div>
            </div>
            </div>
        </div>

    </div>
@endsection

@push('javascript')
<script src="{{asset('vendors/glightbox/glightbox.min.js')}}"></script>
@endpush
