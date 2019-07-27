@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-md-11">

                @if ($user)
                    <div class="alert alert-success" role="alert">
                        {{ __('Hello') }} <strong>{{ $user->name }}!</strong>
                        <br>
                        {{ __('Notifications for your account was') }}
                        <strong>{{ __('switched off.') }}</strong>
                    </div>
                @else
                    <div class="alert alert-danger" role="alert">
                        {{ __('User not found.') }}
                    </div>
                @endif

            </div>

        </div>
    </div>

@endsection
