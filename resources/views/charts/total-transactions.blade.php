@extends('layouts.app')

@section('title', 'Total Transactions')

@section('content')
<div class="container">
    <chart-transactions chart="total" group="date" type="line"></chart-transactions>
</div>
@endsection