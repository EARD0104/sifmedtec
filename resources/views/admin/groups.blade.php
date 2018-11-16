@extends('layouts.app')

@section('content')
<div class="container">
    <groups is_admin="{{ auth()->user()->isAdmin()? 1 : 0 }}"></groups>
</div>
@endsection
