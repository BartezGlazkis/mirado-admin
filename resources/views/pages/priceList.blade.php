@extends('layouts.default')
@section('content')

@if (auth()->check())
@if (auth()->user()->is('admin'))
<admin-price-table />
@else
<price-table />
@endif
@endif
@stop