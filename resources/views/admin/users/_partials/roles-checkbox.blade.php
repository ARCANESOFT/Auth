<?php
/**
 * @var  \Illuminate\Support\Collection  $roles
 * @var  \Illuminate\Support\Collection  $old
 */
?>
<div class="box box-warning">
    <div class="box-header with-border">
        <h3 class="box-title">{{ trans('auth::roles.titles.roles') }}</h3>

        @if ($errors->has('roles'))
            <div class="box-tools">
                <span class="text-red">{!! $errors->first('roles') !!}</span>
            </div>
        @endif
    </div>
    <div class="box-body no-padding">
        <div class="table-responsive">
            <table class="table table-condensed no-margin">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ trans('auth::roles.attributes.name') }}</th>
                        <th>{{ trans('auth::roles.attributes.slug') }}</th>
                        <th>{{ trans('auth::roles.attributes.description') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($roles as $role)
                        <?php /** @var  \Arcanesoft\Auth\Models\Role  $role */ ?>
                        <tr>
                            <td>{{ Form::checkbox('roles[]', $role->id, $old->has($role->id)) }}</td>
                            <td>{{ $role->name }}</td>
                            <td><span class="label label-primary">{{ $role->name }}</span></td>
                            <td>{{ $role->description }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">
                                <span class="label label-default">{{ trans('auth::roles.list-empty') }}</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
