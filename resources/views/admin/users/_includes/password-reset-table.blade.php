<div class="box">
    <div class="box-header with-border">
        <h2 class="box-title">Password reset</h2>
        <div class="box-tools">
            <a href="#deletePasswordResetModal" class="btn btn-xs btn-danger">
                <i class="fa fa-fw fa-trash-o"></i> Delete
            </a>
        </div>
    </div>
    <div class="box-body no-padding">
        <table class="table table-condensed no-margin">
            <tr>
                <td>
                    <b>Created at :</b>
                </td>
                <td class="text-right">
                    <small>{{ $user->passwordReset->created_at }}</small>
                </td>
            </tr>
            <tr>
                <td><b>Expired :</b></td>
                <td class="text-right">
                    @if ($user->passwordReset->isExpired())
                        <span class="label label-warning">Yes</span>
                    @else
                        <span class="label label-success">No</span>
                    @endif
                </td>
            </tr>
        </table>
    </div>
</div>

@section('modals')
    @parent
@endsection
