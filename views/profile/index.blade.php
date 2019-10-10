@extends(arcanesoft\foundation()->template())

@section('page-title')
    <i class="fas fa-fw fa-user"></i> @lang('Profile')
@endsection

<?php
/**
 * @var  Arcanesoft\Auth\Models\User  $user
 */
?>

@section('content')
    <div class="row">
        <div class="col-md-6">
            {{-- ACCOUNT --}}
            {{ form()->open(['route' => 'admin::auth.profile.account.update', 'method' => 'PUT']) }}
                <div class="card card-borderless">
                    <div class="card-header">@lang('Account')</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="first_name" class="control-label">@lang('First Name') :</label>
                            {{ form()->text('first_name', old('first_name', $user->first_name), ['class' => 'form-control'.$errors->first('first_name', ' is-invalid'), 'placeholder' => __('First Name'), 'required']) }}
                            @error('first_name')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="last_name" class="control-label">@lang('Last Name') :</label>
                            {{ form()->text('last_name', old('last_name', $user->last_name), ['class' => 'form-control'.$errors->first('last_name', ' is-invalid'), 'placeholder' => __('First Name'), 'required']) }}
                            @error('last_name')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-0">
                            <label for="email" class="control-label">@lang('Email') :</label>
                            {{ form()->email('email', old('email', $user->email), ['class' => 'form-control'.$errors->first('email', ' is-invalid'), 'placeholder' => __('Email'), 'required']) }}
                            @error('email')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end">
                        {{ arcanesoft\ui\action_button('update')->size('sm')->submit() }}
                    </div>
                </div>
            {{ form()->close() }}
        </div>
        <div class="col-md-6">
            {{-- PASSWORD --}}
            {{ form()->open(['route' => 'admin::auth.profile.password.update', 'method' => 'PUT']) }}
                <div class="card card-borderless">
                    <div class="card-header">@lang('Edit Password')</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="old_password" class="control-label">@lang('Old Password') :</label>
                            {{ form()->password('old_password', ['class' => 'form-control'.$errors->first('old_password', ' is-invalid'), 'placeholder' => __('Old Password')]) }}
                            @error('old_password')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password" class="control-label">@lang('Password') :</label>
                            {{ form()->password('password', ['class' => 'form-control'.$errors->first('password', ' is-invalid'), 'placeholder' => __('Password')]) }}
                            @error('password')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-0">
                            <label for="password_confirmation" class="control-label">@lang('Confirm Password') :</label>
                            {{ form()->password('password_confirmation', ['class' => 'form-control'.$errors->first('password_confirmation', ' is-invalid'), 'placeholder' => __('Confirm Password')]) }}
                            @error('password_confirmation')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end">
                        {{ arcanesoft\ui\action_button('update')->size('sm')->submit() }}
                    </div>
                </div>
            {{ form()->close() }}
        </div>
    </div>
@endsection

@push('scripts')
@endpush
