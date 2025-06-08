@extends('layouts.main')

@section('title', '405')

@section('content')
    <div class="error-page">
        <div class="error-content">
            <h1 class="error-code">405</h1>
            <p class="error-message">Method Not Allowed</p>
            <p class="error-description">The method specified in the request is not allowed for the resource.</p>
            <a href="{{ url('/') }}" class="btn-home">صفحة رئيسية</a>
        </div>
    </div>
@endsection
