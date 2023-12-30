<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline ml-auto">
        <ul class="navbar-nav">
            <li class="bars-icon-navbar"><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg "><i
                        class="fas fa-bars"></i></a></li>
            </li>
            <form method="GET">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="بحث" name="search">
                </div>
            </form>
        </ul>
    </form>
    <ul class="navbar-nav navbar-right">
        <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
                class="nav-link notification-toggle nav-link-lg {{ $notifications->count() > 0 ? 'beep' : '' }}">
                <i data-feather="bell"></i>
            </a>
            <div class="dropdown-menu dropdown-list dropdown-menu-left">
                <div class="dropdown-header">الإشعارات
                    <div class="float-right">
                        <a href="{{ route('admin.markNotification') }}">وضع علامة على الكل كمقروء</a>
                    </div>
                </div>
                <div class="dropdown-list-content dropdown-list-icons">
                    @forelse($notifications as $notification)
                        <a class="dropdown-item dropdown-item-unread">
                            <div class="dropdown-item-icon bg-primary text-white">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="dropdown-item-desc">
                                {{ $notification->data['message'] }}
                                <div class="time text-primary">{{ $notification->created_at->diffforhumans() }}</div>
                            </div>
                        </a>
                    @empty
                        <p class="text-center">لا توجد إشعارات جديدة</p>
                    @endforelse
                </div>

            </div>
        </li>
        <li class="dropdown"><a href="#" data-toggle="dropdown"
                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <div class="d-lg-inline-block text-capitalize">مرحبًا,
                    {{ auth()->guard('admin')->user()->username }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-left">
                <a href="{{ route('admin.profile') }}" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> الملف الشخصي
                </a>
                <a href="{{ route('admin.logout') }}" class="dropdown-item has-icon text-danger">
                    <i class="fas fa-sign-out-alt"></i> تسجيل الخروج
                </a>
            </div>
        </li>
    </ul>
</nav>
