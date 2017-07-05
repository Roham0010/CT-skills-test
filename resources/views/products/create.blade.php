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
		<form action="{{ route('products.create') }}" method="post" class="ajax-form">
			{{ CSRF_FIELD() }}
			<input name="_method" value="put" type="hidden"/>
		  <div class="form-group">
		    <label for="name">Product Name:</label>
		    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') ? old('name') : 'iphone' }}">
		    <span class="help-block"></span>
		  </div>
		  <div class="form-group">
		    <label for="quantity">Quantity:</label>
		    <input type="quantity" class="form-control" id="quantity" name="quantity" value="{{ old('quantity') ? old('quantity') : 5 }}">
		    <span class="help-block"></span>
		  </div>
		  <div class="form-group">
		    <label for="price">Price:</label>
		    <input type="price" class="form-control" id="price" name="price" value="{{ old('price') ? old('price') : 400 }}">
		    <span class="help-block"></span>
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
		  <thead> <tr> <th>Name</th> <th>Quantity</th> <th>Price</th> <th>Total value number</th> </tr> </thead>
		  <tbody id="product_rows">
		  	@foreach($products as $jproduct)
		  		@php
		  			$product = json_decode($jproduct);
		  			if(!is_object($product)) {
		  				continue;
		  			}
		  		@endphp
		  		<tr>
		  			<td>{{ $product->name }}</td>
		  			<td>{{ $product->quantity }}</td>
		  			<td>{{ $product->price }}</td>
		  			<td>{{ (((int)$product->price) * ((int)$product->quantity)) }}</td>

		  		</tr>
		  	@endforeach

		  </tbody>
		</table>
	</div>
</div>
<script type="text/javascript">
	var templateProductRow = "\
	<tr>\
		<td>{name}</td>\
		<td>{quantity}</td>\
		<td>{price}</td>\
		<td>{total}</td>\
	</tr>"
	function replacement(data, myString) {
	    var res = myString;
	    for (var key in data) {
	        var re = new RegExp("{" + key + "}", "g");
	        res = res.replace(re, data[key]);
	    }
	    return res;
	}
	$(document).ready(function() {
		$('.ajax-form').submit(function(e){
			e.preventDefault();
			var data = new FormData($(this)[0]);
			data.append('ajax', 'true');
			$this = $(this);
			$.ajax({
	            url:'{{ route('products.create') }}',
	            type: 'post',
	            data: {'name': $('input[name="name"]').val(), 'quantity':$('input[name="quantity"]').val(), 'price':$('input[name="price"]').val(), ajax:true, '_method': 'put', '_token': $('input[name="_token"]').val() },
	            cache: false,
	            dataType: 'json',
	            success: function(data) {
            		$('.help-block').each(function(){
            			$(this).html('');
            			$(this).parent().removeClass('has-error');
            		});
	            	if(data.status == 'OK') {
	            		product = data.data;
	            		product['total'] = product['price'] * product['quantity'];
	            		var newProduct = replacement(product, templateProductRow);
	            		$('#product_rows').append(newProduct);
	            	} else if(data.status == 'form-error') {
	            		for (var i in data.data) {
		                    if (data.data.hasOwnProperty(i)) {
		                        var errorElem = $this.find($('input[name='+i+']'));
		                        if(!errorElem.length)
		                            errorElem = $this.find($('textarea[name='+i+']'));
		                        if(!errorElem.length)
		                            errorElem = $this.find($('select[name='+i+']')).parent();
		                        console.log(errorElem);
		                        errorElem = errorElem.parent();
		                        if (errorElem.hasClass('has-error')) {
		                            errorElem.find('.help-block').remove();
		                        };
		                        errorElem.addClass('has-error');
		                        errorElem.append('<p class="help-block">'+data.data[i]+'</p>')
		                    }
		                }
	            	}
	            }
	        });
		})
	});
</script>
@endsection
