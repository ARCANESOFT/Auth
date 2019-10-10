@extends(arcanesoft\foundation()->template())

@section('page-title')
    <i class="fa fa-fw fa-users"></i> @lang('Password Resets')
@endsection

@push('content-nav')
    <div class="mb-3 text-right">
        <a href="{{ route('admin::auth.password-resets.metrics') }}" class="btn btn-sm btn-secondary {{ active(['admin::auth.password-resets.metrics']) }}">@lang('Metrics')</a>
        <a href="{{ route('admin::auth.password-resets.index') }}" class="btn btn-sm btn-secondary {{ active(['admin::auth.password-resets.index']) }}">@lang('All')</a>
    </div>
@endpush

@section('content')
    <div class="card card-borderless shadow-sm">
        <div class="table-responsive">
            <table id="password-resets-table" class="table table-hover table-md mb-0">
                <thead>
                    <tr>
                        <th>@lang('Email')</th>
                        <th class="text-center">@lang('Created at')</th>
                        <th class="text-right">@lang('Actions')</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push('modals')
@endpush

@push('scripts')
    <script>
        window.ready(() => {
            window.plugins.datatable('table#password-resets-table', {
                ajax: "{{ route('admin::auth.password-resets.datatables.index') }}",
                serverSide: true,
                processing: true,
                columns: [
                    {data: 'email'},
                    {data: 'created_at', class: 'text-center'},
                    {data: 'actions', class: 'text-right', orderable: false, searchable: false}
                ],
            });
        });
    </script>
@endpush
