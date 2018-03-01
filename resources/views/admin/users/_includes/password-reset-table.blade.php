<?php /** @var  Arcanesoft\Auth\Models\PasswordReset  $passwordReset */ ?>
<div class="box">
    <div class="box-header with-border">
        <h2 class="box-title">{{ trans('auth::password-resets.titles.password-resets') }}</h2>
    </div>
    <div class="box-body no-padding">
        <table class="table table-condensed no-margin">
            <tr>
                <td><b>{{ trans('core::generals.created_at') }} :</b></td>
                <td class="text-right">
                    <small>{{ $passwordReset->created_at }}</small>
                </td>
            </tr>
            <tr>
                <td><b>Expired :</b></td>
                <td class="text-right">
                    <span class="label label-{{ $passwordReset->isExpired() ? 'warning' : 'success' }}">
                        {{ $passwordReset->isExpired() ? 'Yes' : 'No' }}
                    </span>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    {{ ui_link('delete', '#delete-password-reset-modal')->appendClass('btn-block') }}
                </td>
            </tr>
        </table>
    </div>
</div>

@section('modals')
    @parent
@endsection

@section('scripts')
    @parent
@endsection
