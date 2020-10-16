@extends('frontend.master')
@section('head')
    <title>{{ config('app.url') }}</title>
    <style>
        .biog img{
            max-width: 100%;
            border-radius: 7px;
        }
    </style>
@endsection

@section('body')
    <div class="row">
        <div class="col-lg-4 col-md-5 col-12 first_col">
            <div class="row justify-content-center">
                <div class="col-12 mt-1">
                    <b-img-lazy src="{{ asset('images') }}/{{$user['avatar']}}" alt="user_photo" fluid
                                class="rounded"></b-img-lazy>
                </div>
            </div>
            <div class="mt-md-4 mt-3">
                <p class="font1 font-weight-bold h4">Address</p>
                <div class="normal-font">{!! $user['address'] !!}</div>
            </div>
            <div class="mt-md-4 mt-3">
                <p class="h4 font1 font-weight-bold">Contact Information</p>
                <div>
                    @foreach($contacts as $contact)
                        <p class=" d-flex align-items-center flex-wrap user-select-all">
                            @if (isset($contact->icon))
                                <b-icon class="mr-2 normal-font" icon="{{ $contact->icon }}"></b-icon>
                            @endif
                            @if (isset($contact->text))
                                <span class="mr-2 normal-font">{{  $contact->text }}</span>
                            @endif
                            <span class="normal-font">{{ $contact->contact }}</span>

                        </p>
                    @endforeach
                </div>
                <a class="btn btn-primary w-100 mt-3" href="{{ route('website.blog') }}">My Blogs</a>
                @if (auth()->check())
                    <a class="btn btn-primary w-100 mt-3" href="{{ route('admin.index') }}">Admin</a>
                @endif
            </div>
        </div>
        <div class="col-lg-8 col-md-7 col-12 second_bar user-select-none">
            <div class="row mt-3">
                <div class="col-12">
                    <p style="letter-spacing: 1.2px"
                       class="display-4 font1 font-weight-bolder">{{ strtoupper($user['name']) }}</p>
                    <div class="h4 font1">{!! $user['info'] !!}</div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12">
                    <p class="h3 font1 font-weight-bold">Biography</p>
                    <div class="lead biog" style="font-weight: 500">
                        {!! $user['bio'] !!}
                    </div>
                </div>
            </div>
            <index-page></index-page>

        </div>

    </div>


@endsection

@section('js')

@endsection
