<h1>this is the products page</h1>

@foreach($products as $product)
{{ $product->name }} - {{ $product->price }} <br>

@endforeach
