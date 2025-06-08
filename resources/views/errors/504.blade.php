@extends('layouts.main')

@section('title', '504')

@section('content')
    <div class="error-page">
        <div class="error-content">
            <h1 class="error-code">504</h1>
            <p class="error-message">Gateway Timeout</p>
            <p class="error-description">The server, while acting as a gateway or proxy, did not receive a timely response from the upstream server.</p>
            <a href="{{ url('/') }}" class="btn-home">صفحة رئيسية</a>
        </div>
    </div>
@endsection
