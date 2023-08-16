<header id="page-topbar">
<div class="navbar-header">
<div class="d-flex">
<!-- LOGO -->
<div class="navbar-brand-box">
<a href="{{URL('/dashboard')}}" class="logo logo-dark">
<span class="logo-sm">
<img src="{{URL('/')}}/assets/images/square.svg" alt="" height="30">
</span>
<span class="logo-lg">
<img src="{{URL('/')}}/assets/images/square.svg" alt="" height="10"> Falak
</span>
</a>
<a href="{{URL('/Dashboard')}}" class="logo logo-light">
<span class="logo-sm">
<img src="{{URL('/')}}/assets/images/square.svg" alt="" height="30">
</span>
<span class="logo-lg ">
<h5 class="mt-4 text-white"> Promo Deals</h5>
</span>
</a>
</div>
<button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
<i class="fa fa-fw fa-bars"></i>
</button>
<!-- App Search-->
<form class="app-search  d-none d-xl-block">
<div class="position-relative">
<div class="d-flex gap-2 flex-wrap">
    <!--   <div class="btn-group ">
        <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Reports <i class="mdi mdi-chevron-down"></i></button>
        <div class="dropdown-menu">
            <a class="dropdown-item  " href="{{URL('/Journal')}}">Journal</a>
            <a class="dropdown-item" href="{{URL('/CashbookReport')}}">Cash Book</a>
            <div class="dropdown-divider"></div>
            
            
        </div>
    </div><  /btn-group -->
    
</div>
</div>
</form>

</div>
<div class="d-flex">
<div class="dropdown d-inline-block d-lg-none ms-2">
    <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown"
    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <i class="mdi mdi-magnify"></i>
    </button>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
        aria-labelledby="page-header-search-dropdown">
        
        <form class="p-3">
            <div class="form-group m-0">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="dropdown d-inline-block">
    <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <img class="rounded-circle header-profile-user" src="{{URL('/')}}/assets/images/users/avatar-1.jpg"
    alt="Header Avatar">
    <span class="d-none d-xl-inline-block ms-1 " key="t-henry">Setting</span>
    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
    </button>
    <div class="dropdown-menu dropdown-menu-end">
        <!-- item-->
        <a class="dropdown-item" href="{{URL('/UserProfile')}}">
            <i class="bx bx-user font-size-16 align-middle me-1"></i>
            <span key="t-profile">Profile</span></a>
            
            
            <a class="dropdown-item d-block" href="{{URL('/ChangePassword')}}"><i class="bx bx-wrench font-size-16 align-middle me-1"></i> <span key="t-settings">Change Password</span></a>
            
            
            <div class="dropdown-divider"></div>
            <a class="dropdown-item text-danger" href="{{URL('/Logout')}}"><i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span key="t-logout">Logout</span></a>
        </div>
    </div>
    
</div>
</div>
</header>