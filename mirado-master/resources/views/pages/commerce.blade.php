@extends('layouts.default')
@section('content')
<commerce-table :rate={{$rate}} :isadmin={{json_encode(auth()->user()->is('admin'))}}></commerce-table>
@stop