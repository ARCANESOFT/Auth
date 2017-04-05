<?php /** @var  \Illuminate\Database\Eloquent\Collection  $permissions */ ?>
<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title">{{ trans('auth::permissions.titles.permissions') }}</h3>

        @if ($errors->has('permissions'))
            <div class="box-tools">
                <span class="text-red">{!! $errors->first('permissions') !!}</span>
            </div>
        @endif
    </div>
    <div class="box-body no-padding">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ trans('auth::permissions.attributes.group') }}</th>
                    <th>{{ trans('auth::permissions.attributes.slug') }}</th>
                    <th>{{ trans('auth::permissions.attributes.name') }}</th>
                    <th>{{ trans('auth::permissions.attributes.description') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($permissions as $permission)
                <?php /** @var  \Arcanesoft\Auth\Models\Permission  $permission */ ?>
                <tr>
                    <td>
                        {{ Form::checkbox('permissions[]', $permission->id, $old->has($permission->id), ['data-permission-group' => $permission->group_id]) }}
                    </td>
                    <td>
                        @if ($permission->hasGroup())
                            <span class="label label-primary">{{ $permission->group->name }}</span>
                        @else
                            <span class="label label-default">{{ trans('auth::permissions.custom-group') }}</span>
                        @endif
                    </td>
                    <td>
                        <span class="label label-success">{{ $permission->slug }}</span>
                    </td>
                    <td>{{ $permission->name }}</td>
                    <td>{{ $permission->description }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
