{{-- @auth('admin')
    @php
        $userRoles = auth('admin')->user()->getRoleNames();
    @endphp
    {{ dump($userRoles) }}
@endauth --}}
<!-- BEGIN: Mobile Menu -->
<div class="mobile-menu md:hidden">
    <div class="mobile-menu-bar">
        <a href="" class="flex mr-auto">
            <img alt="Rubick Tailwind HTML Admin Template" class="w-20" src="{{ asset('assets/admin/images/Just Digital Guru.png') }}">
        </a>
        <a href="javascript:;" id="mobile-menu-toggler"> <i data-feather="bar-chart-2" class="w-8 h-8 text-white transform -rotate-90"></i> </a>
    </div>
    <ul class="border-t border-theme-29 py-5 hidden">
        <li>
            <a href="{{ url('dashboard') }}" class="menu  {{ $name === 'dashboard' ? 'menu--active' : '' }}">
                <div class="menu__icon"> <i data-feather="home"></i> </div>
                <div class="menu__title"> Dashboard </div>
            </a>
         </li>
         @can('manage-employee')
        <li>
            <a href="{{ url('users') }}" class="menu {{ $name === 'employees' ? 'menu--active' : '' }}">
                <div class="menu__icon"> <i data-feather="box"></i> </div>
                <div class="menu__title"> Manage Employees</div>
            </a>
        </li>
        @endcan
         @can('manage-team')
        <li>
            <a href="{{ url('teams') }}" class="menu {{ $name === 'teams' ? 'menu--active' : '' }}">
                <div class="menu__icon"> <i data-feather="box"></i> </div>
                <div class="menu__title"> Manage Teams</div>
            </a>
        </li>
        @endcan
        <li>
            <a href="{{ url('attendance') }}" class="menu {{ $name === 'attendance' ? 'menu--active' : '' }}">
                <div class="menu__icon"> <i data-feather="inbox"></i> </div>
                <div class="menu__title"> Manage Attendance </div>
            </a>
        </li>
        @can('manage-holiday')
        <li>
            <a href="{{ url('holiday') }}" class="menu {{ $name === 'holiday' ? 'menu--active' : '' }}">
                <div class="menu__icon"> <i data-feather="hard-drive"></i> </div>
                <div class="menu__title"> Manage Holidays </div>
            </a>
        </li>
        @endcan
        @can('manage-leave')

        <li>
            <a href="{{ url('leave') }}" class="menu {{ $name === 'leave' ? 'menu--active' : '' }}">
                <div class="menu__icon"> <i data-feather="calendar"></i> </div>
                <div class="menu__title"> Manage Leave </div>
            </a>
        </li>
            @endcan
            @can('manage-salary')
        <li>
            <a href="{{ url('salary') }}" class="menu {{ $name === 'salary' ? 'menu--active' : '' }}">
                <div class="menu__icon"> <i data-feather="credit-card"></i> </div>
                <div class="menu__title"> Manage Salary </div>
            </a>
        </li>
        @endcan
        @can('manage-overtime')
        <li>
            <a href="{{ url('overtime') }}" class="menu {{ $name === 'overtime' ? 'menu--active' : '' }}">
                <div class="menu__icon"> <i data-feather="clock"></i> </div>
                <div class="menu__title"> Manage Overtime </div>
            </a>
        </li>
        @endcan
        @can('manage-webpage')
        <li>
            <a href="{{ url('webpage') }}" class="menu {{ $name === 'webpage' ? 'menu--active' : '' }}">
                <div class="menu__icon"> <i data-feather="clock"></i> </div>
                <div class="menu__title"> Manage Web Page </div>
            </a>
        </li>
        @endcan
        @can('manage-kpi')
        <li>
            <a href="{{ url('kpipoints') }}" class="menu {{ $name === 'kpi' ? 'menu--active' : '' }}">
                <div class="menu__icon"> <i data-feather="clock"></i> </div>
                <div class="menu__title"> Manage KPI Points </div>
            </a>
        </li>
        @endcan
        @can('manage-careers')
        <li>
            <a href="{{ url('careers') }}" class="menu {{ $name === 'careers' ? 'menu--active' : '' }}">
                <div class="menu__icon"> <i data-feather="trending-up"></i> </div>
                <div class="menu__title"> Manage Carreers</div>
            </a>
        </li>
        @endcan

        <li>
            <a href="{{ url('profile') }}" class="menu {{ $name === 'profile' ? 'menu--active' : '' }}">
                <div class="menu__icon"> <i data-feather="message-square"></i> </div>
                <div class="menu__title"> Manage Profile </div>
            </a>
        </li>

        {{-- <li>
            <a href="side-menu-light-post.html" class="menu">
                <div class="menu__icon"> <i data-feather="file-text"></i> </div>
                <div class="menu__title"> Post </div>
            </a>
        </li>
        <li>
            <a href="side-menu-light-calendar.html" class="menu">
                <div class="menu__icon"> <i data-feather="calendar"></i> </div>
                <div class="menu__title"> Calendar </div>
            </a>
        </li> --}}
        <li class="menu__devider my-6"></li>
        @can('manage-roles-permissions')
        <li>
            <a href="javascript:;" class="menu">
                <div class="menu__icon"> <i data-feather="edit"></i> </div>
                <div class="menu__title"> Manage user roles and permission <i data-feather="chevron-down" class="menu__sub-icon "></i> </div>
            </a>
            <ul class="">
                <li>
                    <a href="{{ url('roles') }}" class="menu {{ $name === 'roles' ? 'side-menu--active' : '' }}">
                        <div class="menu__icon"> <i data-feather="activity"></i> </div>
                        <div class="menu__title"> Manage Roles </div>
                    </a>
                </li>
                <li>
                    <a href="{{ url('admin/permissions') }}" class="menu {{ $name === 'permissions' ? 'side-menu--active' : '' }}">
                        <div class="menu__icon"> <i data-feather="activity"></i> </div>
                        <div class="menu__title"> Manage Permissions </div>
                    </a>
                </li>
            </ul>
        </li>
        @endcan
        <li class="menu__devider my-6"></li>
        <li>
            <a href="{{ url('change_password') }}" class="menu {{ $name === 'changepassword' ? 'side-menu--active' : '' }}">
                <div class="menu__icon"> <i data-feather="file-text"></i> </div>
                <div class="menu__title"> Change Password</div>
            </a>
        </li>
    </ul>
</div>
<!-- END: Mobile Menu -->
<div class="flex">
    <!-- BEGIN: Side Menu -->
    <nav class="side-nav">
        <a href="" class="intro-x flex items-center pt-4" style="justify-content:center;">
            <img alt="Rubick Tailwind HTML Admin Template" class="w-20" style="width: 10rem;" src="{{ asset('assets/admin/images/Just Digital Guru.png') }}">
            <!-- <span class="hidden xl:block text-white text-md ml-3"><span class="font-medium">Just Digital Gurus</span> </span> -->
        </a>
        <div class="side-nav__devider my-6"></div>
        <ul>
            <li>
                <a href="{{ url('dashboard') }}" class="side-menu {{ $name === 'dashboard' ? 'side-menu--active' : '' }} ">
                    <div class="side-menu__icon"> <i data-feather="home"></i> </div>
                    <div class="side-menu__title">
                        Dashboard
                        <div class="side-menu__sub-icon transform rotate-180"> </div>
                    </div>
                </a>
            </li>
         @can('manage-employee')
            <li>
                <a href="{{ url('users') }}" class="side-menu {{ $name === 'employees' ? 'side-menu--active' : '' }}">
                    <div class="side-menu__icon"> <i data-feather="user"></i> </div>
                    <div class="side-menu__title">
                        Manage Employees
                        <div class="side-menu__sub-icon "></div>
                    </div>
                </a>
            </li>
        @endcan
         @can('manage-team')
            <li>
                <a href="{{ url('teams') }}" class="side-menu {{ $name === 'teams' ? 'side-menu--active' : '' }}">
                    <div class="side-menu__icon"> <i data-feather="user"></i> </div>
                    <div class="side-menu__title">
                        Manage Teams
                        <div class="side-menu__sub-icon "></div>
                    </div>
                </a>
            </li>
        @endcan
            <li>
                <a href="{{ url('attendance') }}" class="side-menu {{ $name === 'attendance' ? 'side-menu--active' : '' }}">
                    <div class="side-menu__icon"> <i data-feather="check-circle"></i> </div>
                    <div class="side-menu__title"> Manage Attendance </div>
                </a>
            </li>
        @can('manage-holiday')
            <li>
                <a href="{{ url('holiday') }}" class="side-menu {{ $name === 'holiday' ? 'side-menu--active' : '' }}">
                    <div class="side-menu__icon"> <i data-feather="calendar"></i> </div>
                    <div class="side-menu__title"> Manage Holidays </div>
                </a>
            </li>
        @endcan
        @can('manage-leave')

            <li>
                <a href="{{ url('leave') }}" class="side-menu {{ $name === 'leave' ? 'side-menu--active' : '' }}">
                    <div class="side-menu__icon"> <i data-feather="calendar"></i> </div>
                    <div class="side-menu__title"> Manage Leave </div>
                </a>
            </li>
            @endcan

            @can('manage-salary')
            <li>
                <a href="{{ url('salary') }}" class="side-menu {{ $name === 'salary' ? 'side-menu--active' : '' }}">
                    <div class="side-menu__icon"> <i data-feather="credit-card"></i> </div>
                    <div class="side-menu__title"> Manage Salary </div>
                </a>
            </li>
            @endcan
            @can('manage-overtime')
            <li>
                <a href="{{ url('overtime') }}" class="side-menu {{ $name === 'overtime' ? 'side-menu--active' : '' }}">
                    <div class="side-menu__icon"> <i data-feather="clock"></i> </div>
                    <div class="side-menu__title"> Manage Overtime </div>
                </a>
            </li>
            @endcan
            @can('manage-webpage')
                <li>
                    <a href="{{ url('webpage') }}" class="side-menu {{ $name === 'webpage' ? 'side-menu--active' : '' }}">
                        <div class="side-menu__icon"> <i data-feather="layout"></i> </div>
                        <div class="side-menu__title"> Manage Web Page </div>
                    </a>
                </li>
            @endcan
            @can('manage-kpi')
                <li>
                    <a href="{{ url('kpipoints') }}" class="side-menu {{ $name === 'kpi' ? 'side-menu--active' : '' }}">
                        <div class="side-menu__icon"> <i data-feather="layout"></i> </div>
                        <div class="side-menu__title"> Manage KPI Points </div>
                    </a>
                </li>
            @endcan
            @can('manage-careers')
            <li>
                <a href="{{ url('careers') }}" class="side-menu {{ $name === 'careers' ? 'side-menu--active' : '' }}">
                    <div class="side-menu__icon"> <i data-feather="trending-up"></i> </div>
                    <div class="side-menu__title"> Manage Careers </div>
                </a>
            </li>
            @endcan
            <li class="side-nav__devider my-6"></li>
            <li>
                <a href="{{ url('profile') }}" class="side-menu {{ $name === 'profile' ? 'side-menu--active' : '' }}">
                    <div class="side-menu__icon"> <i data-feather="edit"></i> </div>
                    <div class="side-menu__title">
                        Profile
                        <div class="side-menu__sub-icon "> </div>
                    </div>
                </a>
            </li>
            @can('manage-roles-permissions')
            <li>
                <a href="javascript:;" class="side-menu">
                    <div class="side-menu__icon"> <i data-feather="users"></i> </div>
                    <div class="side-menu__title">
                        Manage user roles and permission
                        <div class="side-menu__sub-icon "> <i data-feather="chevron-down"></i> </div>
                    </div>
                </a>
                <ul class="">
                    <li>
                        <a href="{{ url('roles') }}" class="side-menu {{ $name === 'roles' ? 'side-menu--active' : '' }}">
                            <div class="side-menu__icon"> <i data-feather="user"></i> </div>
                            <div class="side-menu__title"> Manage Roles</div>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('permissions') }}" class="side-menu {{ $name === 'permissions' ? 'side-menu--active' : '' }}">
                            <div class="side-menu__icon"> <i data-feather="lock"></i> </div>
                            <div class="side-menu__title"> Manage Permissions </div>
                        </a>
                    </li>
                </ul>
            </li>
            @endcan
            <li>
                <a href="{{ url('change_password') }}" class="side-menu {{ $name === 'changepassword' ? 'side-menu--active' : '' }}">
                    <div class="side-menu__icon"> <i data-feather="lock"></i> </div>
                    <div class="side-menu__title">
                        Change password
                        <div class="side-menu__sub-icon "> </div>
                    </div>
                </a>
            </li>
        </ul>
    </nav>
    <!-- END: Side Menu -->
