@if (Auth::check())
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            {{ Auth::user()->full_name }} <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
            <li>
                <a href="{{ route('foundation::home') }}">
                    <i class="fa fa-fw fa-tachometer"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-fw fa-user"></i> Profile
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-fw fa-cog"></i> Settings
                </a>
            </li>
            <li role="separator" class="divider"></li>
            <li>
                <a href="{{ route('auth::logout') }}">
                    <i class="fa fa-fw fa-sign-out"></i> Logout
                </a>
            </li>
        </ul>
    </li>
@else
    <li>
        <a href="{{ route('auth::login.get') }}">
            <i class="fa fa-fw fa-sign-in"></i> Login
        </a>
    </li>
@endif
