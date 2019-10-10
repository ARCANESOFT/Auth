@extends(arcanesoft\foundation()->template())

@section('page-title')
    <i class="fas fa-fw fa-shield-alt"></i> @lang('Permissions')
@endsection

@section('content')
    <div class="card card-borderless shadow-sm mb-3">
        <div class="table-responsive">
            <table id="permissions-table" class="table table-hover table-md mb-0">
                <thead>
                    <tr>
                        <th>@lang('Group')</th>
                        <th>@lang('Category')</th>
                        <th>@lang('Name')</th>
                        <th>@lang('Description')</th>
                        <th class="text-center">@lang('Roles')</th>
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
        ready(() => {
            window.plugins.datatable('#permissions-table', {
                ajax: "{{ route('admin::auth.permissions.datatables.index') }}",
                serverSide: true,
                processing: true,
                columns: [
                    { data: 'group_id', searchable: false },
                    { data: 'category' },
                    { data: 'name' },
                    { data: 'description' },
                    { data: 'roles_count', searchable: false, class: 'text-center'},
                    { data: 'actions', orderable: false, searchable: false, class: 'text-right' }
                ],
            })
        })
    </script>
@endpush
