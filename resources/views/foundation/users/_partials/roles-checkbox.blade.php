<div class="box box-warning">
    <div class="box-header with-border">
        <h3 class="box-title">Roles</h3>

        @if ($errors->has('roles'))
            <div class="box-tools">
                <span class="text-red">{!! $errors->first('roles') !!}</span>
            </div>
        @endif
    </div>
    <div class="box-body no-padding">
        <div class="table-responsive">
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($roles->count())
                        @foreach ($roles as $role)
                        <tr>
                            <td>{{ Form::checkbox('roles[]', $role->id, in_array($role->id, $old)) }}</td>
                            <td>{{ $role->name }}</td>
                            <td><span class="label label-primary">{{ $role->name }}</span></td>
                            <td>{{ $role->description }}</td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
