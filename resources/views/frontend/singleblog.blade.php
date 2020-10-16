@extends('frontend.master')
@section('head')
    <title>Blog page</title>
    <style>

    </style>
@endsection

@section('body')
    <div class="row">
        <div class="col-12 sticky-top">
            <div class="row justify-content-center">
                <a href="{{ route('website.index') }}" class="btn btn-primary mx-1"><b-icon icon="box-arrow-in-left"></b-icon>Home</a>
                <a href="{{ route('website.blog') }}" class="btn btn-primary mx-1">                          <b-icon icon="book"></b-icon>  Blog</a>
            </div>
        </div>
        <div class="col-12">
            <div class="card my-2 card-body">
                <p class="h3 font-weight-bold py-2">{{ $blog->title }}</p>
                @foreach($blog->get_category as $cat)
                    <a class="h5" href="{{ route('website.blog.cat',$cat->get_name->id) }}">{{ $cat->get_name->name }}</a>
                @endforeach
                <div class="lead mt-2">
                    <p> {!! $blog->blog !!} </p>
                </div>

            </div>
        </div>
    </div>

@endsection

@section('js')

@endsection
