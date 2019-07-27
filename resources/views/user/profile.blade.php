@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <h1>{{ __('My profile') }}</h1>
                @if (session('saved'))
                    <div class="alert alert-success" role="alert">
                        {{ __('Profile properties saved.') }}
                    </div>
                @endif
                <form method="post" action="{{ route('save-profile') }}">
                    @csrf
                    <div class="form-group">
                        <img src="https://www.gravatar.com/avatar/{{ md5(auth()->user()->email) }}"
                             class="gravatar" title="Your avatar from gravatar.com"/>
                    </div>
                    <div class="form-group">
                        <label for="name">{{ __('Name on site') }}</label>
                        <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                               id="name" placeholder="{{ __('Enter your name on site') }}"
                               name="name"
                               value="{{ $user->name }}">
                        @if ($errors->has('name'))
                            <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('name') }}</strong></span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="email">{{ __('Email address') }}</label>
                        <input type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                               id="email" placeholder="{{ __('Enter email') }}"
                               name="email"
                               value="{{ $user->email }}">
                        @if (!$user->email_verified_at)
                            <small id="email" class="form-text text-muted">
                                {{ __('E-mail is not confirmed.') }} <a href="{{ route('verification.resend') }}">
                                    {{ __('Confirm my e-mail') }}</a>
                            </small>
                        @else
                            <small id="email" class="form-text text-muted">
                                {{ __('Your e-mail confirmed at: ') }}
                                {{ date_format($user->email_verified_at, "F d, Y") }}
                            </small>
                        @endif
                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('email') }}</strong></span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="passw1">{{ __('Password') }}</label>
                        <input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}"
                               id="passw1" placeholder="{{ __('Password') }}"
                               name="password">
                        <small id="passw1" class="form-text text-muted">{{ __('Enter new password to change current one.') }}</small>
                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('password') }}</strong></span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="passw2">{{ __('Password') }}</label>
                        <input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}"
                               id="passw2" placeholder="{{ __('Password confirmation') }}"
                                name="password_confirmation">
                        <small id="passw2" class="form-text text-muted">{{ __('Enter new password to change current one.') }}</small>
                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('password') }}</strong></span>
                        @endif
                    </div>

                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input"
                               @if($user->allow_replies)
                                   checked="checked"
                               @endif
                               id="emailReplies" name="allow_replies" value="1">
                        <label class="form-check-label" for="emailReplies">{{ __('Allow mail notifications when someone replies to my comments') }}</label>
                    </div>

                    <button type="submit" class="btn btn-primary">{{ __('Save profile') }}</button>
                    <small class="form-text text-muted">{{ __('Updated at:') }} {{ date_format($user->updated_at, "F d, Y H:i:s ") }}</small>
                </form>
            </div>
        </div>
    </div>
@endsection
