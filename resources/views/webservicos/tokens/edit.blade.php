@extends('layouts.page')

@section('title', 'Orders')

@section('content_header')
    <h1>Orders - Editar</h1>
@stop

@section('css')

@stop

@section('js')

@stop

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
<div class="card uper">
  <div class="card-header">
    Edit Order
  </div>
  <div class="card-body">
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div><br />
    @endif
      <form method="post" action="{{ route('admin.orders.update', $order->id) }}">
        @method('PATCH')
        @csrf
        <div class="form-group">
          <label for="name">Order Name:</label>
          <input type="text" class="form-control" name="name" value={{ $order->name }} />
        </div>
        <div class="form-group">
          <label for="price">Order Price :</label>
          <input type="text" class="form-control" name="price" value={{ $order->price }} />
        </div>
        <div class="form-group">
          <label for="quantity">Order Quantity:</label>
          <input type="text" class="form-control" name="qty" value={{ $order->qty }} />
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
      </form>
  </div>
</div>
@endsection