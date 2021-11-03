<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
<form class="form-inline mr-auto">
    <ul class="navbar-nav mr-3">
    <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
    </ul>
</form>
<ul class="navbar-nav navbar-right">
      <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg @if($unread->count() != 0) {{ 'beep' }} @endif"><i class="far fa-bell"></i></a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">
              <div class="dropdown-header">Pemberitahuan
                <div class="float-right">
                  <a href="#">Mark All As Read</a>
                </div>
              </div>
              <div class="dropdown-list-content dropdown-list-icons">
                  @foreach($unread as $notif_unread)
                  <a href="#" class="dropdown-item dropdown-item-unread" data-id="{{ $notif_unread->id }}">
                  <div class="dropdown-item-icon bg-primary text-white">
                    <i class="fas fa-code"></i>
                  </div>
                        <div class="dropdown-item-desc">
                              @if($notif_unread->type === 'App\Notifications\ImportReady' ) {{ 'Pembaharuan data customer oleh' }} @endif {{ $notif_unread->data['name']}}
                        <div class="time text-primary"> {{ Carbon\Carbon::parse($notif_unread->created_at)->diffForHumans()}} </div>
                        </div>
                  </a>
                  @endforeach
              </div>
              <div class="dropdown-footer text-center">
                <a href="#">Lihat Semua<i class="fas fa-chevron-right"></i></a>
              </div>
            </div>
          </li>
    <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
    <img class="img-profile rounded-circle" src="{{ Auth::user()->profile_picture != null ? URL::to('/').'/storage/profile_picture/'. Auth::user()->profile_picture : URL::to('/layout/assets/img/avatar.png')}}">
    <div class="d-sm-none d-lg-inline-block">{{ Auth::user() != null ? Auth::user()->nama : '' }}</div></a>
    <div class="dropdown-menu dropdown-menu-right">
        <a href="{{route('profile')}}" class="dropdown-item has-icon">
        <i class="far fa-user"></i> Profile
        </a>
        </a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
          <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
          Logout
        </a>
    </div>
    </li>
</ul>
</nav>