<div id="left-sidebar" class="sidebar">
    <div class="sidebar-scroll">
        <div class="user-account">
            <img src="{{ asset(auth()->user()->profile_picture) }}" class="rounded-circle user-photo" alt="User Profile Picture">
            <div class="dropdown">
                <span>Welcome,</span>
                <a href="javascript:void(0);" class="dropdown-toggle user-name" data-toggle="dropdown"><strong>{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</strong></a>
                <ul class="dropdown-menu dropdown-menu-right account">
                    <li><a href="#"><i class="icon-user"></i>My Profile</a></li>
                    <li><a href="#"><i class="icon-envelope-open"></i>Messages</a></li>
                    <li><a href="#"><i class="icon-settings"></i>Settings</a></li>
                    <li class="divider"></li>
                    <li>
                        <a href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i>Logout</a>
                    </li>
                </ul>
            </div>
        </div>
        <nav id="left-sidebar-nav" class="sidebar-nav">
            <ul id="main-menu" class="metismenu">
                <li class="{{ Route::is('dashboard') ? 'active' : '' }}">
                    <a  href="{{ route('dashboard') }}"><i class="fa fa-home"></i> <span>Dashboard</span></a>
                </li>
                <li class="{{ Route::is('leads.index') ? 'active' : '' }}">
                    <a  href="{{ route('leads.index') }}"><i class="fa fa-phone"></i> <span>Call Tracking</span></a>
                </li>
                <li class="{{ Route::is('cash-register.index') ? 'active' : '' }}">
                    <a href="#" class="has-arrow"><i class="fa fa-money"></i> <span>Sales Projection</span></a>
                    <ul>
                        <li><a href="{{ route('cash-register.dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ route('cash-register.goals') }}">Goals</a></li>
                        <li><a href="{{ route('cash-register.index') }}">Add Transaction</a></li>
                    </ul>
                </li>

                <li class="{{ Route::is('lead-management.index') ? 'active' : '' }}">
                    <a href="#" class="has-arrow"><i class="fa fa-tasks"></i> <span>Lead Management</span></a>
                    <ul>
                        <li><a href="{{ route('lead-management.index') }}">Lead Search</a></li>
                        <li><a href="{{ route('lead-management.lead_list') }}">New Lead</a></li>
                    </ul>
                </li>

                <li class="{{ Route::is('cash-register.index') ? 'active' : '' }}">
                    <a href="#" class="has-arrow"><i class="fa fa-bug"></i> <span>Reports</span></a>
                    <ul>
                        <li><a href="{{ route('cash-register.dashboard') }}">Pipeline Reports</a></li>
                        <li><a href="{{ route('cash-register.goals') }}">Lead Reports</a></li>
                    </ul>
                </li>

                @php
                    $department_sides = \Modules\Department\Entities\Department::all();
                @endphp

                @if($department_sides->count() == 0)
                <li class="{{ Route::is('lead.index') ? 'active' : '' }}">
                    <a href="{{route('lead.index')}}"><i class="fa fa-filter"></i> <span>Leads</span></a>
                </li>
                @else

                <li class="{{ Route::is('lead.index') ? 'active' : '' }}">
                    <a href="#" class="has-arrow"><i class="fa fa-filter"></i> <span>Leads</span></a>
                    <ul>
                        @foreach($department_sides as $dep)
                        <li><a href="{{ route('lead.index', ['department_id' => $dep->id]) }}">{{ $dep->name }}</a></li>
                        @endforeach
                    </ul>
                </li>
                @endif


                <li class="{{ Route::is('ticket.index','reviews.index') ? 'active' : '' }}">
                    <a href="#" class="has-arrow"><i class="fa fa-info-circle"></i> <span>Helpdesk</span></a>
                    <ul>
                        <li><a href="{{ route('ticket.index') }}">Tickets</a></li>
                        <li><a href="{{ route('reviews.index') }}">Reviews</a></li>
                    </ul>
                </li>
                <li class="{{ Route::is(['department.index', 'lead-source.index', 'lead-status.index', 'formbuilder::forms.index']) ? 'active' : '' }}">
                    <a href="#" class="has-arrow"><i class="fa fa-cog"></i> <span>Settings</span></a>
                    <ul>
                        <li><a href="{{ route('department.index') }}">Department</a></li>
                        <li>
                            <a href="#" class="has-arrow"><span>Lead</span></a>
                            <ul>
                                <li><a href="{{ route('lead-source.index') }}">Sources</a></li>
                                <li><a href="{{ route('lead-status.index') }}">Statuses</a></li>
                                <li><a href="{{ route('lead-type.index') }}">Types</a></li>
                                <li><a href="{{ route('form.index') }}">Web to Lead</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#" class="has-arrow"><span>Ticket</span></a>
                            <ul>
                                <li><a href="{{ route('ticket-status.index') }}">Statuses</a></li>
                                <li><a href="{{ route('ticket-priority.index') }}">Priorities</a></li>
                                <li><a href="{{ route('ticket-service.index') }}">Services</a></li>
                            </ul>
                        </li>
                 {{--        <li>
                            <a  href="{{ route('smtp') }}"><span>Setup</span></a>
                        </li> --}}
                    </ul>
                </li>
                <li class="{{ Route::is(['user.index', 'role.index', 'permission.index']) ? 'active' : '' }}">
                    <a href="#" class="has-arrow"><i class="fa fa-users"></i> <span>User Management</span></a>
                    <ul>
                        <li><a href="{{ route('user.index') }}">User</a></li>
                        <li><a href="{{ route('role.index') }}">Role</a></li>
                        <li><a href="{{ route('permission.index') }}">Permission</a></li>
                    </ul>
                </li>

            </ul>
        </nav>
    </div>
</div>
