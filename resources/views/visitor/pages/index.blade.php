@extends('visitor.base')

@section('base.body')
    @include('visitor.sections.swiper')
    @include('visitor.sections.search', ['_link' => route('visitor.decors')])
    @include('visitor.sections.recent-decors')
    {{-- @include('visitor.sections.destinations') --}}
    @include('visitor.sections.about')
    @include('visitor.sections.best-decors')
    {{-- @include('visitor.sections.gallery') --}}
    @include('visitor.sections.counter')
    {{-- @include('visitor.sections.team') --}}
    @include('visitor.sections.testimonials')
    @include('visitor.sections.brand')
    @include('visitor.sections.recent-events')
@endsection
