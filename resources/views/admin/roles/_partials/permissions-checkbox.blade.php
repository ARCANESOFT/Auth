<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title">Permissions</h3>

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
                    <th>Group</th>
                    <th>Slug</th>
                    <th>Name</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($permissions as $permission)
                <tr>
                    <td>
                        {{ Form::checkbox('permissions[]', $permission->id, $old->has($permission->id), ['data-permission-group' => $permission->group_id]) }}
                    </td>
                    <td>
                        <span class="label label-{{$permission->hasGroup() ? 'primary' : 'default' }}">
                            {{ $permission->hasGroup() ? $permission->group->name : 'Custom' }}
                        </span>
                    </td>
                    <td>
                        <span class="label label-success">{{ $permission->slug }}</span>
                    </td>
                    <td>
                        {{ $permission->name }}
                    </td>
                    <td>
                        {{ $permission->description }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
