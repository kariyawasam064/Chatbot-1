@extends('layouts.app')

@section('sidebar')
    @livewire('admin.admin-sidebar')
@endsection

@section('dashboard')
@livewire('admin.admin-dashboard')
@endsection

@section('chat-dashboard')
@livewire('admin.admin-chat-view-dashboard')
@endsection
