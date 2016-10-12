<!-- ====================================================
header section -->
<!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">SB Admin</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> {{ Auth::user()->name }} <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-envelope"></i> Inbox</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-gear"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="{{ url('/logout') }}" onclick="event.preventDefault();    document.getElementById('logout-form').submit();"><i class="fa fa-fw fa-power-off"></i>
                                        Logout
                                    </a>

                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <?php //echo "<pre>"; print_r($users); echo "</pre>";  ?>
                    <?php $user_role = Auth::user()->role; ?>
                    
                    @if($user_role == "admin")
                    <li>
                        <a href="{{ URL::to('/admin/dashboard') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                    </li>
                    
                    <li>
                        <a href="{{ URL::to('/admin/users') }}"><i class="fa fa-fw fa-user"></i>All Users</a>
                    </li>
                    @endif

                    @if($user_role == "admin" || $user_role == "sub-admin")
                   
                    <li class="active">
                        <a href="{{ URL::to('/admin/sub-admin') }}"><i class="fa fa-fw fa-user-md"></i> Sub-admin</a>
                    </li>

                    @endif

                   @if($user_role == "admin" || $user_role == "sub-admin"  || $user_role == "master-distributer") 
                   
                    <li>
                        <a href="{{ URL::to('/admin/master-distributers') }}"><i class="fa fa-fw fa-edit"></i>Master-distributer</a>
                    </li>
                    @endif

                    @if($user_role == "admin" || $user_role == "sub-admin"  || $user_role == "master-distributer" || $user_role == "super-distributer") 
                    <li>
                        <a href="{{ URL::to('/admin/super-distributers') }}"><i class="fa fa-fw fa-desktop"></i> Super-distributer</a>
                    </li>
                    @endif

                    @if($user_role == "admin" || $user_role == "sub-admin"  || $user_role == "master-distributer" || $user_role == "super-distributer" || $user_role == "distributer") 
                    <li>
                        <a href="{{ URL::to('/admin/distributers') }}"><i class="fa fa-fw fa-wrench"></i>Distributer</a>
                    </li>
                    @endif

                    @if($user_role == "admin" || $user_role == "sub-admin"  || $user_role == "master-distributer" || $user_role == "super-distributer" || $user_role == "distributer" || $user_role == "retailer") 
                    <li>
                        <a href="{{ URL::to('/admin/retailer') }}"><i class="fa fa-fw fa-users"></i> Shop-user/Retailers</a>
                    </li>
                    @endif
                    
                    @if($user_role == "admin" || $user_role == "sub-admin"  || $user_role == "master-distributer" || $user_role == "super-distributer" || $user_role == "distributer" || $user_role == "retailer" || $user_role == "general") 
                    <li>
                        <a href="{{ URL::to('/admin/customers') }}"><i class="fa fa-fw fa-users"></i>Customer</a>
                    </li>
                    @endif

                    @if($user_role == "admin" || $user_role == "sub-admin"  || $user_role == "master-distributer" || $user_role == "super-distributer" || $user_role == "distributer" || $user_role == "retailer") 
                    <li>
                        <a href="{{ route('recharge') }}"><i class="fa fa-fw fa-users"></i>Customer Recharge</a>
                    </li>
                    @endif
                    
                    
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>