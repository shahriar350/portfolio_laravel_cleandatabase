@extends('admin.master')

@section('head')
    <title>{{ auth()->user()->name }}</title>
@endsection

@section('body')
    <user-page :user="{{ auth()->user() }}"></user-page>
@endsection

@section('js')

@endsection
