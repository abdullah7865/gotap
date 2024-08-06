<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo mb-4">
        <a href="/admin/dashboard" class="app-brand-link">
            <span class="app-brand-logo demo" style="background:white">
                <img src="{{ asset('logo.png') }}" class="img-fluid" width="140" alt="Logo here">
            </span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
            <a href="{{ url('admin/dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div>Dashboard</div>
            </a>
        </li>

        <li class="menu-item {{ request()->is('admin/users') ? 'active' : '' }}">
            <a href="{{ url('admin/users') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user-pin"></i>
                <div>Users</div>
            </a>
        </li>
        {{-- <li class="menu-item {{ request()->is('admin/users') ? 'active' : '' }}">
            <a href="{{ url('admin/users') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user-pin"></i>
                <div>Manage Teams</div>
            </a>
        </li> --}}
        <li class="menu-item {{ request()->is('admin/categories') ? 'active' : '' }}">
            <a href="{{ url('admin/categories') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-category"></i>
                <div>Categories</div>
            </a>
        </li>
        <li class="menu-item {{ request()->is('admin/platforms') ? 'active' : '' }}">
            <a href="{{ url('admin/platforms') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-shape-square"></i>
                <div>Platforms</div>
            </a>
        </li>
        <li class="menu-item {{ request()->is('admin/cards') ? 'active' : '' }}">
            <a href="{{ url('admin/cards') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-credit-card-alt"></i>
                <div>Cards</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="javascript:void(0)" onclick="changePassword()" class="menu-link">
                <i class="menu-icon tf-icons bx bx-key"></i>
                <div>Change Password</div>
            </a>
        </li>
        {{-- <li class="menu-item {{ request()->is('admin/logs') ? 'active' : '' }}">
            <a href="{{ url('admin/logs') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-plus-medical"></i>
                <div>Logs</div>
            </a>
        </li> --}}
    </ul>
</aside>

<div class="modal fade" id="changePassword" tabindex="-1" aria-labelledby="changePasswordLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordLabel">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" placeholder="Enter password">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn" style="background: #0EA7C1; color:white"
                    onclick="savePassword()">Update</button>
            </div>
        </div>
    </div>
</div>
