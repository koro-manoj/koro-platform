@extends('layouts.public')

@section('title', $page->title)

@section('content')
    <article class="card">
        <h1 style="margin-top:0;">{{ $page->title }}</h1>
        <div style="line-height:1.7;">{!! $page->content !!}</div>
    </article>
@endsection
