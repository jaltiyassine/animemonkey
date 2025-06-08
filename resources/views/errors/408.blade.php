@extends('layouts.main')

@section('title', '408')

@section('content')
    <div class="error-page">
        <div class="error-content">
            <h1 class="error-code">408</h1>
            <p class="error-message">Request Timeout</p>
            <p class="error-description">The server timed out waiting for the request.</p>
            <a href="{{ url('/') }}" class="btn-home">صفحة رئيسية</a>
        </div>
    </div>
@endsection
