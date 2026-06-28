<nav class="navbar navbar-expand-lg navbar-light dashboard-bgcolor border-bottom">
    <button class="btn b-db-color" id="menu-toggle">
        <span style="display:none;">Menu</span>
        <span class="fas fa-bars" style="font-size: 1.4rem"></span>
    </button>
    <button class="navbar-toggler b-dropmenubtn" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="far fa-caret-square-down" style="font-size: 30px; color: #FFF"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">

        <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
            <!--<li class="nav-item">
              <a class="nav-link b-db-color" href="#">Notification</a>
            </li>
            <li class="nav-item">
              <a class="nav-link b-db-color" href="#">Inbox</a>
            </li>-->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle b-db-color" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="fas fa-users"></span> Profile
                </a>
                <div class="dropdown-menu dropdown-menu-right text-center b-dropmenu-db" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{route('worker-profile')}}">Profile</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#signout-modal">Sign Out</a>

                </div>
            </li>
        </ul>
    </div>
</nav>
