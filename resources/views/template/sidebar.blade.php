<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
       
                <li>
                    <a href="{{URL('/Dashboard')}}" class="waves-effect">
                        <i class="mdi mdi-speedometer-slow mb-0"></i>
                       
                        <span key="t-dashboards">Dashboard</span>
                    </a>
                    
                </li>
            
                <li>
                    <a href="{{URL('/User')}}" class="waves-effect">
                        <i class="bx bxs-user-plus"></i>
                        <span key="t-calendar">Agents</span>
                    </a>
                </li>

                <li>
                    <a href="{{URL('/Clients')}}" class="waves-effect">
                        <i class="bx bxs-user-plus"></i>
                        <span key="t-calendar">Clients</span>
                    </a>
                </li>

                 <li>
                    <a href="{{URL('/Offers')}}" class="waves-effect">
                        <i class="bx bxs-user-plus"></i>
                        <span key="t-calendar">Offers</span>
                    </a>
                </li>

                

               <!--  <li>
                    <a href="{{URL('/Backup')}}" class="waves-effect">
                        <i class="mdi mdi-database-export"></i>
                        <span key="t-calendar">
                        DB Backup</span>
                    </a>
                </li> -->


                 <li>
                    <a href="{{URL('/Logout')}}" class="waves-effect">
                        <i class="bx bx-power-off"></i>
                        <span key="t-calendar">Logout</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>