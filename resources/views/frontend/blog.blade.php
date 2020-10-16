@extends('frontend.master')
@section('head')
    <title>Blog page</title>
@endsection

@section('body')
    <div class="row">
        <div class="col-12 sticky-top">
            <div class="row justify-content-center">
                <a href="{{ route('website.index') }}" class="btn btn-primary mx-1"><b-icon icon="box-arrow-in-left"></b-icon>Home</a>
                <a href="{{ route('website.blog') }}" class="btn btn-primary mx-1">                          <b-icon icon="book"></b-icon>  Blog</a>
                <col-6>

                </col-6>
            </div>

        </div>
        <div class="col-12">
            @foreach ($blogs as $blog)
                <div class="card my-2 card-body">
                    <a class="h3" href="{{ route('website.blog.id',$blog->id) }}">{{ $blog->title }}</a>
                    @foreach($blog->get_category as $cat)
                        <a class="h5" href="{{ route('website.blog.cat',$cat->get_name->id) }}">{{ $cat->get_name->name }}</a>
                    @endforeach
                    <div class="lead">
                        <p> {!! \Illuminate\Support\Str::limit($blog->blog) !!} </p>
                    </div>

                </div>

            @endforeach
            <div class="w-100">
                {{ $blogs->links() }}
            </div>

        </div>
    </div>

@endsection

@section('js')

@endsection
