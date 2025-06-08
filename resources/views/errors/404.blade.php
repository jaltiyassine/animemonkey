@extends('layouts.main')

@section('title', '404')

@section('content')
    <div class="error-page">
        <div class="error-content">
            <h1 class="error-code">404</h1>
            <p class="error-message">Page Not Found</p>
            <p class="error-description">The page you are looking for might have been moved or doesn't exist.</p>
            <a href="{{ url('/') }}" class="btn-home">صفحة رئيسية</a>
        </div>
    </div>
@endsection