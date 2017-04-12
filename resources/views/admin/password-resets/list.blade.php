<?php /** @var  \Illuminate\Pagination\LengthAwarePaginator  $resets */ ?>
@section('header')
    <h1><i class="fa fa-fw fa-refresh"></i> {{ trans('auth::password-resets.titles.password-resets') }} <small>{{ trans('auth::password-resets.titles.password-resets-list') }}</small></h1>
@endsection

@section('content')
    <div class="box box-success">
        <div class="box-header with-border">
            @include('core::admin._includes.pagination.labels', ['paginator' => $resets])

            @unless($resets->isEmpty())
                <div class="box-tools">
                    <a href="#clear-password-resets-modal" class="btn btn-xs btn-warning">
                        <i class="fa fa-fw fa-eraser"></i> {{ trans('auth::password-resets.actions.clear-expired') }}
                    </a>
                    <a href="#delete-password-resets-modal" class="btn btn-xs btn-danger">
                        <i class="fa fa-fw fa-trash-o"></i> {{ trans('auth::password-resets.actions.delete-all') }}
                    </a>
                </div>
            @endunless
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
                        @forelse ($resets as $reset)
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
                                    {{ ui_link_icon('show', route('admin::auth.users.show', [$reset->user->hashed_id])) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">
                                    <span class="label label-default">{{ trans('auth::password-resets.list-empty') }}</span>
                                </td>
                            </tr>
                        @endforelse
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
    @unless($resets->isEmpty())
        <div id="clear-password-resets-modal" class="modal fade">
            <div class="modal-dialog">
                {{ Form::open(['route' => 'admin::auth.password-resets.clear', 'method' => 'DELETE', 'class' => 'form form-loading', 'id' => 'clear-password-resets-form', 'autocomplete' => 'off']) }}
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">{{ trans('auth::password-resets.modals.clear.title') }}</h4>
                        </div>
                        <div class="modal-body">
                            <p>{!! trans('auth::password-resets.modals.clear.message') !!}</p>
                        </div>
                        <div class="modal-footer">
                            {{ ui_button('cancel')->appendClass('pull-left')->setAttribute('data-dismiss', 'modal') }}
                            {{ ui_button('clear', 'submit')->withLoadingText() }}
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>

        <div id="delete-password-resets-modal" class="modal fade">
            <div class="modal-dialog">
                {{ Form::open(['route' => 'admin::auth.password-resets.delete', 'method' => 'DELETE', 'class' => 'form form-loading', 'id' => 'delete-password-resets-form', 'autocomplete' => 'off']) }}
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">{{ trans('auth::password-resets.modals.delete.title') }}</h4>
                        </div>
                        <div class="modal-body">
                            <p>{!! trans('auth::password-resets.modals.delete.message') !!}</p>
                        </div>
                        <div class="modal-footer">
                            {{ ui_button('cancel')->appendClass('pull-left')->setAttribute('data-dismiss', 'modal') }}
                            {{ ui_button('delete', 'submit')->withLoadingText() }}
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    @endunless
@endsection

@section('scripts')
    @unless($resets->isEmpty())
    <script>
        $(function () {
            {{-- CLEAR MODAL --}}
            var $clearPasswordResetsModal = $('div#clear-password-resets-modal'),
                $clearPasswordResetsForm  = $('form#clear-password-resets-form');

            $('a[href="#clear-password-resets-modal"]').on('click', function (e) {
                e.preventDefault();

                $clearPasswordResetsModal.modal('show');
            });

            $clearPasswordResetsForm.on('submit', function (e) {
                e.preventDefault();

                var $submitBtn = $clearPasswordResetsForm.find('button[type="submit"]');
                    $submitBtn.button('loading');

                axios.delete($clearPasswordResetsForm.attr('action'))
                     .then(function (response) {
                         if (response.data.status === 'success') {
                             $clearPasswordResetsModal.modal('hide');
                             location.reload();
                         }
                         else {
                             alert('ERROR ! Check the console !');
                             console.error(response.data.message);
                             $submitBtn.button('reset');
                         }
                     })
                     .catch(function (error) {
                         alert('AJAX ERROR ! Check the console !');
                         console.log(error);
                         $submitBtn.button('reset');
                     });

                return false;
            });

            {{-- DELETE MODAL --}}

            var $deletePasswordResetsModal = $('div#delete-password-resets-modal'),
                $deletePasswordResetsForm  = $('form#delete-password-resets-form');

            $('a[href="#delete-password-resets-modal"]').on('click', function (e) {
                e.preventDefault();

                $deletePasswordResetsModal.modal('show');
            });

            $deletePasswordResetsForm.on('submit', function (e) {
                e.preventDefault();

                var $submitBtn = $deletePasswordResetsForm.find('button[type="submit"]');
                    $submitBtn.button('loading');

                axios.delete($deletePasswordResetsForm.attr('action'))
                     .then(function (response) {
                         if (response.data.status === 'success') {
                             $deletePasswordResetsModal.modal('hide');
                             location.reload();
                         }
                         else {
                             alert('ERROR ! Check the console !');
                             console.error(response.data.message);
                             $submitBtn.button('reset');
                         }
                     })
                     .catch(function (error) {
                         alert('AJAX ERROR ! Check the console !');
                         console.log(error);
                         $submitBtn.button('reset');
                     });

                return false;
            })
        });
    </script>
    @endunless
@endsection
