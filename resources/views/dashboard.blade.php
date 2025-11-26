@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Dashboard</h1>
    <p>Selamat datang, {{ auth()->user()->name }}!</p>
</div>
@endsection
