<div class="top_nav">
    <div class="nav_menu">
        <nav role="navigation">
            <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>
            <ul class="nav navbar-nav navbar-right">
                <li class="">
                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset('asset/picture-default/users.png') }}" alt=""> Halo, ASD
                        <span class=" fa fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                        <li><a href="{{ route('account.me') }}"> Profile</a></li>
                        <li><a href="{{ route('auth.logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                        <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                  </ul>
                </li>
            </ul>
        </nav>
    </div>
</div>