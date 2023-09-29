@extends('layouts.usersMainLayouts')

@section('current-page-title') News and update @endsection
@section('current-page-title-icon') far fa-newspaper @endsection

@section('usersContent')
<div class="row g-3">
    <div class="col-lg-8">
        @foreach($news as $data)
            @if($data->category === 'EVENTS')
                <div class="card mb-3 p-1">
                    <img height="400px" style="object-fit: cover;"  class="card-img-top" src="{{asset('/storage/featured_image').'/'.$data->featuredImage}}" alt="">
                    <div class="card-body overflow-hidden">
                        <div class="row justify-content-between align-items-center">
                            <div class="col">
                                <div class="d-flex">
                                    <div class="calendar me-2">
                                        <span class="calendar-month">{{date("M", strtotime($data->eventDate))}}</span>
                                        <span class="calendar-day">{{date("d", strtotime($data->eventDate))}}</span>
                                    </div>
                                    <div class="flex-1 fs--1">
                                        <h5 class="fs-0">
                                            <a href="{{ route('events.details.user', $data->id) }}" style="text-transform: capitalize; ">
                                                {{$data->title}}
                                            </a>
                                        </h5>
                                        <p class="mb-0">
                                            by<a href="#!"> {{$data->author}}</a>
                                        </p>
                                        <span class="fs-0 text-warning fw-semi-bold" style="text-transform: capitalize; ">{{$data->eventPrice}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-auto d-none d-md-block">
                                <a href="{{ route('events.details.user', $data->id) }}" class="btn btn-primary btn-sm px-4" type="button">View Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="card mb-3">
                    <img class="card-img-top" height="400px" style="object-fit: cover;" src="{{asset('/storage/featured_image').'/'.$data->featuredImage}}" alt="">
                    <div class="card-header bg-light">
                        <div class="row justify-content-between">
                            <div class="col">
                                <div class="d-flex">
                                    <div class="flex-1 align-self-center">
                                        <p class="mb-1 lh-1">
                                            <a class="fw-semi-bold" href="{{ route('news.details.user', $data->id) }}">{{$data->title}}</a>
                                        </p>
                                        <p class="mb-0 fs--1">{{date("F d, Y", strtotime($data->created_at))}} &bull; {{date("h:i A", strtotime($data->created_at))}} &bull; <span class="fas fa-globe-americas"></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body overflow-hidden pt-0">
                        <div style="text-align: justify;">
                            @php
                                $content = mb_strimwidth($data->content, 0, 5000, ' . . .');
                            @endphp

                            {!! $content !!}
                        </div>
                        <a class="fs--1 d-inline-block mt-0 link-primary" href="{{ route('news.details.user', $data->id) }}">Read more</a>
                    </div>
                </div>
            @endif
        @endforeach  
        {{ $news->links() }}
    </div>
    <!-- <div class="col-lg-4 ps-lg-2">
        <div class="sticky-sidebar">
            <div class="card mb-lg-0">
                <div class="card-header">
                    <h5 class="mb-0">Other Info</h5>
                </div>
                <div class="card-body bg-light">

                </div>
            </div>
        </div>
    </div> -->
</div>
@endsection
