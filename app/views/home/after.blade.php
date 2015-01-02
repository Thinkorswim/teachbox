@extends('layouts.master-after')

@section('content')
	<a href="{{ URL::action('CourseController@create')}}"> Create Course </a>
 
    <?php 
    	 $lawly = User::where('name', '=', 'Martin Georgiev')->first();

    foreach ($lawly->course as $tree)
        echo $tree->name . ' ';

    ?>

@endsection
