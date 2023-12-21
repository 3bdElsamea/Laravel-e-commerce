@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <table class="table mt-4">
                    <thead>
                    <tr>
                        <th scope="col">Notifications</th>

                    </tr>
                    </thead>
                    <tbody>

                    @foreach ($notifications as $notification)
                        <tr>
                            <td>{{ $notification->data }}</td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{--                Back Button--}}
                <a href="{{ route('home') }}" class="btn btn-primary">Back</a>
            </div>

            {{ $notifications->links()}}
        </div>
    </div>
@endsection
