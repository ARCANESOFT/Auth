@extends(arcanesoft\foundation()->template())

@section('page-title')
    <i class="fa fa-fw fa-users"></i> @lang('Create User')
@endsection

@section('content')
    {{ form()->open(['route' => 'admin::auth.users.store', 'method' => 'POST']) }}
        <div class="row">
            <div class="col-md-6">
                <div class="card card-borderless">
                    <div class="card-header">@lang('User')</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="first_name" class="control-label">@lang('First Name') :</label>
                            {{ form()->text('first_name', old('first_name'), ['class' => 'form-control'.$errors->first('first_name', ' is-invalid'), 'placeholder' => __('First Name'), 'required']) }}
                            @error('first_name')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="last_name" class="control-label">@lang('Last Name') :</label>
                            {{ form()->text('last_name', old('last_name'), ['class' => 'form-control'.$errors->first('last_name', ' is-invalid'), 'placeholder' => __('First Name'), 'required']) }}
                            @error('last_name')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email" class="control-label">@lang('Email') :</label>
                            {{ form()->email('email', old('email'), ['class' => 'form-control'.$errors->first('email', ' is-invalid'), 'placeholder' => __('Email'), 'required']) }}
                            @error('email')
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
                    <div class="card-footer d-flex justify-content-between">
                        {{ arcanesoft\ui\action_link('cancel', route('admin::auth.users.index'))->size('sm') }}
                        {{ arcanesoft\ui\action_button('create')->size('sm')->submit() }}
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-borderless">
                    <div class="card-header">
                        @lang('Roles')
                    </div>
                    <table class="table table-md mb-0">
                        <thead>
                            <tr>
                                <th></th>
                                <th>@lang('Name')</th>
                                <th>@lang('Description')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($roles as $role)
                                <?php /** @var  Arcanesoft\Auth\Models\Role  $role */ ?>
                                <tr>
                                    <td>
                                        {{ form()->checkbox('roles[]', $role->uuid, in_array($role->uuid, old('roles', []))) }}
                                    </td>
                                    <td>{{ $role->name }}</td>
                                    <td>{{ $role->description }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">@lang('The list is empty !')</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    {{ form()->close() }}
@endsection
