@extends(arcanesoft\foundation()->template())

@section('page-title')
    <i class="fas fa-fw fa-user-tag"></i> @lang('Create Role')
@endsection

@section('content')
    {{ form()->open(['route' => 'admin::auth.roles.store', 'method' => 'POST']) }}
        {{-- ROLE --}}
        <div class="row">
            <div class="col-md-6">
                <div class="card card-borderless shadow-sm mb-3">
                    <div class="card-header">@lang('Role')</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name" class="control-label">@lang('Name') :</label>
                            {{ form()->text('name', old('name'), ['class' => 'form-control'.$errors->first('name', ' is-invalid'), 'placeholder' => __('Name'), 'required']) }}
                            @error('name')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description" class="control-label">@lang('Description') :</label>
                            {{ form()->text('description', old('description'), ['class' => 'form-control'.$errors->first('description', ' is-invalid'), 'placeholder' => __('Description'), 'required']) }}
                            @error('description')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        {{ arcanesoft\ui\action_link('cancel', route('admin::auth.roles.index'))->size('sm') }}
                        {{ arcanesoft\ui\action_button('create')->size('sm')->submit() }}
                    </div>
                </div>
            </div>
        </div>

        {{-- PERMISSIONS --}}
        <div class="card card-borderless shadow-sm mb-3">
            <div class="card-header">@lang('Permissions')</div>
            <table class="table table-hover table-md mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>@lang('Group')</th>
                        <th>@lang('Category')</th>
                        <th>@lang('Name')</th>
                        <th>@lang('Description')</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($permissions as $permission)
                    <?php /** @var  Arcanesoft\Auth\Models\Permission  $permission */ ?>
                    <tr>
                        <td>
                            {{ form()->checkbox('permissions[]', $permission->uuid, in_array($permission->uuid, old('permissions', []))) }}
                        </td>
                        <td>{{ $permission->group->name }}</td>
                        <td>{{ $permission->category }}</td>
                        <td>{{ $permission->name }}</td>
                        <td><small>{{ $permission->description }}</small></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">@lang('The list is empty!')</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    {{ form()->close() }}
@endsection
