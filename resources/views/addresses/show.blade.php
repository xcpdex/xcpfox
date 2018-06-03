@extends('layouts.app')

@section('title', $address->address)

@section('content')
<div class="container mt-1">
    <h1>
        {{ $address->address }}
    </h1>
    <div class="card mt-4">
        <div class="card-header font-weight-bold">
            Address Information
        </div>
        <div class="card-body">
        </div>
    </div>
</div>
@endsection