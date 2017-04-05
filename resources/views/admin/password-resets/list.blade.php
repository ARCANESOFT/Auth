<?php /** @var  \Illuminate\Pagination\LengthAwarePaginator  $resets */ ?>
@section('header')
    <h1><i class="fa fa-fw fa-refresh"></i> {{ trans('auth::password-resets.titles.password-resets') }} <small>{{ trans('auth::password-resets.titles.password-resets-list') }}</small></h1>
@endsection

@section('content')
    <div class="box box-success">
        <div class="box-header with-border">
            <span class="label label-info" style="margin-right: 5px;">
                {{ trans('core::pagination.total', ['total' => $resets->total()]) }}
            </span>
            @if ($resets->hasPages())
                <span class="label label-info">
                    {{ trans('core::pagination.pages', ['current' => $resets->currentPage(), 'last' => $resets->lastPage()]) }}
                </span>
            @endif
            <div class="box-tools">
                @if ($resets->total())
                <a href="#clearPasswordResetsModal" class="btn btn-xs btn-primary">
                    <i class="fa fa-fw fa-trash-o"></i> {{ trans('auth::password-resets.actions.clear-expired') }}
                </a>
                <a href="#deletePasswordResetsModal" class="btn btn-xs btn-danger">
                    <i class="fa fa-fw fa-trash-o"></i> {{ trans('auth::password-resets.actions.delete-all') }}
                </a>
                @endif
            </div>
        </div>
        <div class="box-body no-padding">
            <div class="table-responsive">
                <table class="table table-condensed table-hover no-margin">
                    <thead>
                        <tr>
                            <th>{{ trans('auth::users.attributes.email') }}</th>
                            <th>{{ trans('auth::users.attributes.full_name') }}</th>
                            <th>{{ trans('core::generals.created_at') }}</th>
                            <th class="text-center">{{ trans('auth::password-resets.attributes.expired') }}</th>
                            <th class="text-right" style="width: 80px;">{{ trans('core::generals.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if ($resets->isEmpty())
                        <tr>
                            <td colspan="6" class="text-center">
                                <span class="label label-default">{{ trans('auth::password-resets.list-empty') }}</span>
                            </td>
                        </tr>
                    @else
                        @foreach ($resets as $reset)
                        <?php /** @var  \Arcanesoft\Auth\Models\PasswordReset  $reset */ ?>
                        <tr>
                            <td>{{ $reset->email }}</td>
                            <td>{{ $reset->user->full_name }}</td>
                            <td><small>{{ $reset->created_at }}</small></td>
                            <td class="text-center">
                                @if ($reset->isExpired())
                                    <span class="label label-warning">Yes</span>
                                @else
                                    <span class="label label-success">No</span>
                                @endif
                            </td>
                            <td class="text-right">
                                <a href="{{ route('admin::auth.users.show', [$reset->user->hashed_id]) }}" class="btn btn-xs btn-info" data-toggle="tooltip" data-original-title="Show">
                                    <i class="fa fa-fw fa-search"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
        @if ($resets->hasPages())
            <div class="box-footer clearfix">{!! $resets->render() !!}</div>
        @endif
    </div>
@endsection

@section('modals')
    <div id="clearPasswordResetsModal" class="modal fade">
        <div class="modal-dialog">
            {{ Form::open(['route' => 'admin::auth.password-resets.clear', 'method' => 'DELETE', 'class' => 'form form-loading', 'id' => 'clearPasswordResetsForm', 'autocomplete' => 'off']) }}
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Clear all expired password resets</h4>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure to <span class="label label-primary">clear</span> all the expired password resets ?</p>
                    </div>
                    <div class="modal-footer">
                        {{ Form::button('Cancel', ['class' => 'btn btn-sm btn-default pull-left', 'data-dismiss' => 'modal']) }}
                        <button type="submit" class="btn btn-sm btn-primary" data-loading-text="Loading&hellip;">
                            <i class="fa fa-fw fa-trash-o"></i> Clear
                        </button>
                    </div>
                </div>
            {{ Form::close() }}
        </div>
    </div>

    <div id="deletePasswordResetsModal" class="modal fade">
        <div class="modal-dialog">
            {{ Form::open(['route' => 'admin::auth.password-resets.delete', 'method' => 'DELETE', 'class' => 'form form-loading', 'id' => 'deletePasswordResetsForm', 'autocomplete' => 'off']) }}
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Delete all password resets</h4>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure to <span class="label label-danger">delete</span> all password resets ?</p>
                    </div>
                    <div class="modal-footer">
                        {{ Form::button('Cancel', ['class' => 'btn btn-sm btn-default pull-left', 'data-dismiss' => 'modal']) }}
                        <button type="submit" class="btn btn-sm btn-danger" data-loading-text="Loading&hellip;">
                            <i class="fa fa-fw fa-trash-o"></i> Delete
                        </button>
                    </div>
                </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function () {
            var $clearPasswordResetsModal = $('div#clearPasswordResetsModal'),
                $clearPasswordResetsForm  = $('form#clearPasswordResetsForm');

            $('a[href="#clearPasswordResetsModal"]').on('click', function (e) {
                e.preventDefault();

                $clearPasswordResetsModal.modal('show');
            });

            $clearPasswordResetsForm.submit(function (e) {
                e.preventDefault();
                var $submitBtn = $clearPasswordResetsForm.find('button[type="submit"]');
                    $submitBtn.button('loading');

                $.ajax({
                    url:      $clearPasswordResetsForm.attr('action'),
                    type:     $clearPasswordResetsForm.attr('method'),
                    dataType: 'json',
                    data:     $clearPasswordResetsForm.serialize(),
                    success: function (data, textStatus, xhr) {
                        if (data.status === 'success') {
                            $clearPasswordResetsModal.modal('hide');
                            location.reload();
                        }
                        else {
                            alert('ERROR ! Check the console !');
                            console.error(data.message);
                            $submitBtn.button('reset');
                        }
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        alert('AJAX ERROR ! Check the console !');
                        console.error(xhr);
                        $submitBtn.button('reset');
                    }
                });

                return false;
            });

            var $deletePasswordResetsModal = $('div#deletePasswordResetsModal'),
                $deletePasswordResetsForm  = $('form#deletePasswordResetsForm');

            $('a[href="#deletePasswordResetsModal"]').on('click', function (e) {
                e.preventDefault();

                $deletePasswordResetsModal.modal('show');
            });

            $deletePasswordResetsForm.submit(function (e) {
                e.preventDefault();
                var $submitBtn = $deletePasswordResetsForm.find('button[type="submit"]');
                    $submitBtn.button('loading');

                $.ajax({
                    url:      $deletePasswordResetsForm.attr('action'),
                    type:     $deletePasswordResetsForm.attr('method'),
                    dataType: 'json',
                    data:     $deletePasswordResetsForm.serialize(),
                    success: function (data, textStatus, xhr) {
                        if (data.status === 'success') {
                            $deletePasswordResetsModal.modal('hide');
                            location.reload();
                        }
                        else {
                            alert('ERROR ! Check the console !');
                            console.error(data.message);
                            $submitBtn.button('reset');
                        }
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        alert('AJAX ERROR ! Check the console !');
                        console.error(xhr);
                        $submitBtn.button('reset');
                    }
                });
                return false;
            })
        });
    </script>
@endsection
