@extends('layouts.home')

@section('content')

<div class="container">
<center>
  <h2>{{ $exception->getMessage() }}</h2> 
</center>

</div>
@endsection

