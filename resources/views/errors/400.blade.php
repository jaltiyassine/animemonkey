@extends('layouts.main')

@section('title', '400')

@section('content')
    <div class="error-page">
        <div class="error-content">
            <h1 class="error-code">400</h1>
            <p class="error-message">Bad Request</p>
            <p class="error-description">The request could not be understood by the server due to malformed syntax.</p>
            <a href="{{ url('/') }}" class="btn-home">صفحة رئيسية</a>
        </div>
    </div>
@endsection
