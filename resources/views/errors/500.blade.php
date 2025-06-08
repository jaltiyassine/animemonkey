@extends('layouts.main')

@section('title', '500')

@section('content')
    <div class="error-page">
        <div class="error-content">
            <h1 class="error-code">500</h1>
            <p class="error-message">Internal Server Error</p>
            <p class="error-description">The server encountered an unexpected condition that prevented it from fulfilling the request.</p>
            <a href="{{ url('/') }}" class="btn-home">صفحة رئيسية</a>
        </div>
    </div>
@endsection
