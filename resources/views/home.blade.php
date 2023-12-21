@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <table class="table mt-4">
                <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Made By</th>
                    <th scope="col">Made At</th>
                </tr>
                </thead>
                <tbody>

                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->user->name }}</td>

                        <td>{{ $order->created_at }}</td>

                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{ $orders->links() }}
    </div>
</div>
@endsection
