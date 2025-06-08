@extends('layouts.main')

@section('title', '503')

@section('content')
    <div class="error-page">
        <div class="error-content">
            <h1 class="error-code">503</h1>
            <p class="error-message">Service Unavailable</p>
            <p class="error-description">The server is currently unable to handle the request due to a temporary overload or scheduled maintenance.</p>
            <a href="{{ url('/') }}" class="btn-home">صفحة رئيسية</a>
        </div>
    </div>
@endsection
