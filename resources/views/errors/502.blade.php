@extends('layouts.main')

@section('title', '502')

@section('content')
    <div class="error-page">
        <div class="error-content">
            <h1 class="error-code">502</h1>
            <p class="error-message">Bad Gateway</p>
            <p class="error-description">The server, while acting as a gateway or proxy, received an invalid response from the upstream server.</p>
            <a href="{{ url('/') }}" class="btn-home">صفحة رئيسية</a>
        </div>
    </div>
@endsection
