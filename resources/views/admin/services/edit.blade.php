@extends('layouts.admin')

@section('title', 'Editar Servicio')

@section('extra_css')
<link rel="stylesheet" href="{{ asset('css/admin-services-form.css') }}">
@endsection

@section('content')
@include('admin.services._form')
@endsection
