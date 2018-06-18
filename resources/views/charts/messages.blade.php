@extends('layouts.app')

@section('title', $group_by === 'date' ? 'Counterparty Messages Per Day' : 'Counterparty Messages Per ' . ucfirst($group_by))
@section('canonical', url(route('charts.messages')))
@section('description', 'Chart showing total messages or "operations" processed by federated nodes in the Counterparty network.')

@section('content')
<div class="container mt-1">
    @include('charts.partials.page-title', [
        'title' => 'Messages',
        'small' => $group_by === 'date' ? 'Per Day' : 'Per ' . $group_by,
    ])
    <chart
        source="{{ url(route('api.charts.messages', ['group_by' => $group_by])) }}"
        title="Counterparty Messages"
        yaxis="Messages"
        group_by="{{ $group_by }}"
        type="{{ $chart_type }}"
        cumulative="true"
    >
    </chart>
    @include('charts.partials.options', ['route' => 'charts.messages'])
    @include('charts.partials.mobile-cta')
</div>
@endsection