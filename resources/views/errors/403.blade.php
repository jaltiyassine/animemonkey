@extends('layouts.main')

@section('title', '403')

@section('content')
    <div class="error-page">
        <div class="error-content">
            <h1 class="error-code">403</h1>
            <p class="error-message">Access Denied</p>
            <p class="error-description">You do not have permission to access this page.</p>
            <a href="{{ url('/') }}" class="btn-home">صفحة رئيسية</a>
        </div>
    </div>
@endsection