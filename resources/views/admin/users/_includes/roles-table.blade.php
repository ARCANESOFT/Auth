<?php /** @var  \Illuminate\Database\Eloquent\Collection  $roles */ ?>
<div class="box box-warning">
    <div class="box-header with-border">
        <h3 class="box-title">{{ trans('auth::roles.titles.roles') }}</h3>
    </div>
    <div class="box-body no-padding">
        <div class="table-responsive">
            <table class="table table-condensed no-margin">
                <thead>
                    <tr>
                        <th>{{ trans('auth::roles.attributes.name') }}</th>
                        <th>{{ trans('auth::roles.attributes.description') }}</th>
                        <th class="text-right">{{ trans('core::generals.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($roles->isEmpty())
                        <tr>
                            <td colspan="3" class="text-center">
                                <span class="label label-default">{{ trans('auth::users.has-no-roles') }}</span>
                            </td>
                        </tr>
                    @else
                        @foreach ($roles as $role)
                        <?php /** @var  \Arcanesoft\Auth\Models\Role  $role */ ?>
                        <tr>
                            <td><span class="label label-primary">{{ $role->name }}</span></td>
                            <td>{{ $role->description }}</td>
                            <td class="text-right">
                                @can(Arcanesoft\Auth\Policies\RolesPolicy::PERMISSION_SHOW)
                                    @include('core::admin._includes.actions.icon-links.show', ['url' => route('admin::auth.roles.show', [$role->hashed_id])])
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
