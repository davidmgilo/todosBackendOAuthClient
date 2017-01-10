@extends('adminlte::page')

@section('htmlheader_title')
	TODO List
@endsection


@section('main-content')
	<script>
		window.access_token = {{ $access_token }};
	</script>
	<todos></todos>
@endsection
