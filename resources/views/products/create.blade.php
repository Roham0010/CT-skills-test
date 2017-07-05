@extends('app')
@section('content')
<div class="row" style="background: #f3f3f3;">

	{{-- <div class="col-md-3"></div> --}}
	<div class="col-md-12 text-center"><h1 class="head header"> Coalition Technologies Skill Test</h1></div>
<br>
</div>
<br>
<div class="row">
	<div class="col-md-4">
		<ul>
			@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
	<div class="col-md-4">
		<form action="{{ route('products.create') }}" method="post">
		{{ CSRF_FIELD() }}
			<input name="_method" value="put" type="hidden"/>
		  <div class="form-group">
		    <label for="name">Product Name:</label>
		    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') ? old('name') : 'iphone' }}">
		  </div>
		  <div class="form-group">
		    <label for="quantity">Quantity:</label>
		    <input type="quantity" class="form-control" id="quantity" name="quantity" value="{{ old('quantity') ? old('quantity') : 5 }}">
		  </div>
		  <div class="form-group">
		    <label for="price">Price:</label>
		    <input type="price" class="form-control" id="price" name="price" value="{{ old('price') ? old('price') : 400 }}">
		  </div>
		  <button type="submit" class="btn btn-default">Submit</button>
		</form>
	</div>
</div>
<br>
<br>
<div class="row">
	<div class="col-md-4"></div>
	<div class="col-md-4">
		<table class="table table-striped">
		  <thead> <tr> <th>#</th> <th>Name</th> <th>Quantity</th> <th>Price</th> </tr> </thead>
		  <tbody>
		  @php $i = 0 @endphp
		  	@foreach($products as $jproduct)
		  		@php
		  			$product = json_decode($jproduct);
		  			if(!is_object($product)) {
		  				continue;
		  			}
		  		@endphp
		  		<tr>
		  			<td>{{ $i++ }}</td>
		  			<td>{{ $product->name }}</td>
		  			<td>{{ $product->quantity }}</td>
		  			<td>{{ $product->price }}</td>

		  		</tr>
		  	@endforeach

		  </tbody>
		</table>
	</div>
</div>
@endsection
