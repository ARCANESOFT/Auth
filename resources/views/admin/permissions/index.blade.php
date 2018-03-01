<?php /** @var  \Illuminate\Pagination\LengthAwarePaginator  $permissions */ ?>

@section('header')
    <h1><i class="fa fa-fw fa-check-circle"></i> {{ trans('auth::permissions.titles.permissions') }} <small>{{ trans('auth::permissions.titles.permissions-list') }}</small></h1>
@endsection

@section('content')
    <div class="box box-success">
        <div class="box-header with-border">
            @include('core::admin._includes.pagination.labels', ['paginator' => $permissions])

            <div class="box-tools">
                @include(Arcanesoft\Auth\ViewComposers\PermissionGroupsFilterComposer::VIEW)
            </div>
        </div>
        <div class="box-body no-padding">
            <div class="table-responsive">
                <table class="table table-condensed table-hover no-margin">
                    <thead>
                        <tr>
                            <th>{{ trans('auth::permissions.attributes.group') }}</th>
                            <th>{{ trans('auth::permissions.attributes.slug') }}</th>
                            <th>{{ trans('auth::permissions.attributes.name') }}</th>
                            <th>{{ trans('auth::permissions.attributes.description') }}</th>
                            <th class="text-center">{{ trans('auth::roles.titles.roles') }}</th>
                            <th class="text-right" style="width: 80px;">{{ trans('core::generals.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($permissions as $permission)
                            <?php /** @var  Arcanesoft\Auth\Models\Permission  $permission */ ?>
                            <tr>
                                <td>
                                    @php($hasGroup = $permission->hasGroup())
                                    <span class="label label-{{ $hasGroup ? 'primary' : 'default' }}">
                                        {{ $hasGroup ? $permission->group->name : trans('auth::permission-groups.custom') }}
                                    </span>
                                </td>
                                <td>
                                    <span class="label label-success">{{ $permission->slug }}</span>
                                </td>
                                <td>{{ $permission->name }}</td>
                                <td>{{ $permission->description }}</td>
                                <td class="text-center">{{ label_count($permission->roles_count) }}</td>
                                <td class="text-right">
                                    @can(Arcanesoft\Auth\Policies\PermissionsPolicy::PERMISSION_SHOW)
                                        {{ ui_link_icon('show', route('admin::auth.permissions.show', [$permission->hashed_id])) }}
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">
                                    <span class="label label-default">{{ trans('auth::permissions.list-empty') }}</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($permissions->hasPages())
            <div class="box-footer clearfix">
                {{ $permissions->render() }}
            </div>
        @endif
    </div>
@endsection

@section('scripts')
@endsection
