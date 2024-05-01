@extends('frontend.master_dashboard')

@section('title','Home easy online shop')

@section('main')
    <div class="container">
        <h1>Orders</h1>

        @if (count($orders) > 0)
            <ul class="list-group">
                @foreach ($orders as $order)
                    <li class="list-group-item">
                        <strong>Order ID:</strong> {{ $order->order_id }} <br>
                        <strong>Product:</strong> {{ $order->product->name }} <br>
                        <strong>Price:</strong> {{ $order->order_details_id }} <br>
                        <!-- Add more order details as needed -->
                    </li>
                @endforeach
            </ul>
        @else
            <p>No orders found.</p>
        @endif
    </div>
@endsection
