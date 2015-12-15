@section('header')
    <h1><i class="fa fa-fw fa-bar-chart"></i> Statistics</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-blue">
                    <i class="ion ion-ios-people-outline"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Users</span>
                    <span class="info-box-number">{{ $authUsersTotal }}</span>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-yellow">
                    <i class="ion ion-locked"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Roles</span>
                    <span class="info-box-number">{{ $authRolesTotal }}</span>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-green">
                    <i class="ion ion-checkmark-circled"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Permissions</span>
                    <span class="info-box-number">{{ $authPermissionsTotal }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
