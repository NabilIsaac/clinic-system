@extends('layouts.app')

@section('content')
    @role('admin|super-admin')
        @include('dashboard.admin')
    @endrole

    @role('patient')
        @include('dashboard.patient')
    @endrole

    @role('nurse')
        @include('dashboard.nurse')
    @endrole

    @role('doctor')
        @include('dashboard.doctor')
    @endrole

    @role('receptionist')
        @include('dashboard.receptionist')
    @endrole
@endsection