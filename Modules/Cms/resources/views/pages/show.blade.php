@extends('layouts.public')

@section('title', $page->title.' — '.config('app.name'))

@section('content')
    <nav class="koro-breadcrumb" aria-label="Breadcrumb">
        <a href="{{ url('/') }}">Home</a>
        <span aria-hidden="true">/</span>
        <span class="text-white">{{ $page->title }}</span>
    </nav>

    <article class="koro-card max-w-3xl animate-fade-up">
        <p class="koro-eyebrow">CMS module</p>
        <h1 class="koro-heading-lg mt-2">{{ $page->title }}</h1>
        <div class="koro-prose mt-6">{!! $page->content !!}</div>
    </article>
@endsection
