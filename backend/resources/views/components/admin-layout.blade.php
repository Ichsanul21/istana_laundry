@extends('admin.layouts.admin')

@section('title', $title ?? 'Dashboard')

@section('content')
    {{ $slot }}
@endsection

@section('styles')
    @stack('styles')
@endsection

@section('scripts')
    @stack('scripts')
@endsection
