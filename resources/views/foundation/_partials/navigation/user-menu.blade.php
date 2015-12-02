<?php
    /** @var  \Arcanesoft\Auth\Models\User  $user */
    $user = Auth::user();
?>
<li class="dropdown user user-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        {!! Html::image($user->gravatar, $user->full_name, ['class' => 'user-image']) !!}
        <span class="hidden-xs">{{ $user->full_name }}</span>
    </a>
    <ul class="dropdown-menu">
        {{-- User image --}}
        <li class="user-header">
            {!! Html::image($user->gravatar, 'User Image', ['class' => 'img-circle']) !!}
            <p>{{ $user->full_name }} <small>Member since {{ $user->created_at->toFormattedDateString() }}</small></p>
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
                {!! link_to_route('auth::foundation.profile.index', 'Profile', [], ['class' => 'btn btn-default btn-flat']) !!}
            </div>
            <div class="pull-right">
                {!! link_to_route('auth::logout', 'Sign out', [], ['class' => 'btn btn-default btn-flat']) !!}
            </div>
        </li>
    </ul>
</li>
