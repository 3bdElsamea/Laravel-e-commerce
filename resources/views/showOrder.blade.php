@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <table class="table mt-4">
                    <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Unit Price</th>
                        <th scope="col">Total Price</th>

                    </tr>
                    </thead>
                    <tbody>

                    @foreach ($order->orderItems as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->product->name }}</td>

                            <td>{{ $item->quantity }}</td>
                            <td>{{ $item->price }}</td>
                            <td>{{ $item->quantity * $item->price }}</td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
{{--                Back Button--}}
                <a href="{{ route('home') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
@endsection
