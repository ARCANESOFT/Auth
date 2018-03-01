<?php
    /** @var  Arcanesoft\Auth\Models\User  $user */
    $user = auth()->user();
?>
<li class="dropdown user user-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        {{ html()->image($user->gravatar, $user->full_name, ['class' => 'user-image']) }}
        <span class="hidden-xs">{{ $user->full_name }}</span>
    </a>
    <ul class="dropdown-menu">
        {{-- User image --}}
        <li class="user-header">
            {{ html()->image($user->gravatar, $user->full_name, ['class' => 'img-circle']) }}
            <p>{{ $user->full_name }} <small>{{ $user->since_date }}</small></p>
        </li>
        {{-- Menu Body --}}
        <?php /*
            <li class="user-body">
                <div class="row">
                    <div class="col-xs-4 text-center">
                        <a href="#">Followers</a>
                    </div>
                    <div class="col-xs-4 text-center">
                        <a href="#">Sales</a>
                    </div>
                    <div class="col-xs-4 text-center">
                        <a href="#">Friends</a>
                    </div>
                </div>
            </li>
         */ ?>
        {{-- Menu Footer --}}
        <li class="user-footer">
            <div class="pull-left">
                <a href="{{ route('admin::auth.profile.index') }}" class="btn btn-default btn-flat">
                    <i class="fa fa-fw fa-user"></i> {{ trans('auth::generals.profile') }}
                </a>
            </div>
            <div class="pull-right">
                <a href="#" class="btn btn-default btn-flat" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    {{ trans('auth::generals.logout') }} <i class="fa fa-fw fa-sign-out"></i>
                </a>
                {{ form()->open(['route' => 'auth::logout', 'method' => 'POST', 'id' => 'logout-form', 'style' => 'display: none;']) }}
                {{ form()->close() }}
            </div>
        </li>
    </ul>
</li>
