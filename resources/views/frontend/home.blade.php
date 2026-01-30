@extends('frontend.layouts.app')

@section('title', 'Home')

@section('content')
    @include('frontend.partials.sections.hero')
    @include('frontend.partials.sections.categories')
    @include('frontend.partials.sections.products-best-selling')
    @include('frontend.partials.sections.banner')
    @include('frontend.partials.sections.products-featured')
    @include('frontend.partials.sections.newsletter')
    @include('frontend.partials.sections.products-popular')
    @include('frontend.partials.sections.products-latest')
    @include('frontend.partials.sections.blog')
    @include('frontend.partials.sections.app-downlaod')
    @include('frontend.partials.sections.tages')
    @include('frontend.partials.sections.feautures')
@endsection
