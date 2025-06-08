@extends('layouts.main')

@section('title', '401')

@section('content')
    <div class="error-page">
        <div class="error-content">
            <h1 class="error-code">401</h1>
            <p class="error-message">Unauthorized</p>
            <p class="error-description">You must be authenticated to access this page.</p>
            <a href="{{ url('/') }}" class="btn-home">صفحة رئيسية</a>
        </div>
    </div>
@endsection
