@extends('home')

@section('user')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('You are logged in!') }}

                        <!-- Display user details -->
                        <div class="mt-4">
                            <strong>Name:</strong> {{ Auth::user()->name }}
                            <br>
                            <strong>Email:</strong> {{ Auth::user()->email }}
                            <br>
                            <strong>Phone:</strong> {{ Auth::user()->detail->phone }}
                            <br>
                            <strong>Address:</strong> {{ Auth::user()->detail->address }}
                            <br>
                            <strong>City:</strong> {{ Auth::user()->detail->city }}
                            <br>
                            <strong>Country:</strong> {{ Auth::user()->detail->country }}

                            <!-- Add a button to update details -->
{{--                            <strong>country:</strong> {{ Auth::user()->detail->country }}--}}

                        </div>
                        <!-- Modal for updating user details -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
