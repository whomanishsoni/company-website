<!-- resources/views/components/sidebar.blade.php -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SB Admin 2</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Items -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ url('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        User Management
    </div>

    <!-- Nav Item - Users Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsers"
            aria-expanded="true" aria-controls="collapseUsers">
            <i class="fas fa-fw fa-users"></i>
            <span>Users</span>
        </a>
        <div id="collapseUsers" class="collapse" aria-labelledby="headingUsers" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">User Management:</h6>
                <a class="collapse-item" href="{{ route('users.index') }}">List Users</a>
                <a class="collapse-item" href="{{ route('users.create') }}">Create User</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Member Management
    </div>

    <!-- Nav Item - Members Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMembers"
            aria-expanded="true" aria-controls="collapseMembers">
            <i class="fas fa-fw fa-users"></i>
            <span>Members</span>
        </a>
        <div id="collapseMembers" class="collapse" aria-labelledby="headingMembers" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Member Management:</h6>
                <a class="collapse-item" href="{{ route('members.index') }}">List Members</a>
                <a class="collapse-item" href="{{ route('members.create') }}">Create Member</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Blog Management
    </div>

    <!-- Nav Item - Blogs Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBlogs"
            aria-expanded="true" aria-controls="collapseBlogs">
            <i class="fas fa-fw fa-blog"></i>
            <span>Blogs</span>
        </a>
        <div id="collapseBlogs" class="collapse" aria-labelledby="headingBlogs" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Blog Management:</h6>
                <a class="collapse-item" href="{{ route('blogs.index') }}">List Blogs</a>
                <a class="collapse-item" href="{{ route('blogs.create') }}">Create Blog</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Categories Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCategories"
            aria-expanded="true" aria-controls="collapseCategories">
            <i class="fas fa-fw fa-folder"></i>
            <span>Categories</span>
        </a>
        <div id="collapseCategories" class="collapse" aria-labelledby="headingCategories"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Category Management:</h6>
                <a class="collapse-item" href="{{ route('categories.index') }}">List Categories</a>
                <a class="collapse-item" href="{{ route('categories.create') }}">Create Category</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Tags Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTags"
            aria-expanded="true" aria-controls="collapseTags">
            <i class="fas fa-fw fa-tags"></i>
            <span>Tags</span>
        </a>
        <div id="collapseTags" class="collapse" aria-labelledby="headingTags" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Tag Management:</h6>
                <a class="collapse-item" href="{{ route('tags.index') }}">List Tags</a>
                <a class="collapse-item" href="{{ route('tags.create') }}">Create Tag</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Communications
    </div>

    <!-- Nav Item - Mail Inquiries -->
    <li class="nav-item">
        @php
            $unreadCount = \App\Models\MailInquiry::where('is_read', false)->where('is_trashed', false)->count();
            $totalInboxCount = \App\Models\MailInquiry::where('is_trashed', false)->count();
            $trashedCount = \App\Models\MailInquiry::where('is_trashed', true)->count();
        @endphp

        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMail"
            aria-expanded="true" aria-controls="collapseMail">
            <i class="fas fa-fw fa-envelope"></i>
            <span>Mail Inquiries</span>
            @if ($unreadCount > 0)
                <span class="badge badge-danger badge-counter">{{ $unreadCount }}</span>
            @endif
        </a>

        <div id="collapseMail" class="collapse" aria-labelledby="headingMail" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Mail Management:</h6>

                <a class="collapse-item d-flex justify-content-between align-items-center"
                    href="{{ route('mail-inquiries.index') }}">
                    <span>
                        <i class="fas fa-inbox mr-2"></i> Inbox
                    </span>
                    <span class="badge badge-primary badge-pill">
                        {{ $totalInboxCount }}
                        @if ($unreadCount > 0)
                            <span class="ml-1">({{ $unreadCount }} new)</span>
                        @endif
                    </span>
                </a>

                <a class="collapse-item d-flex justify-content-between align-items-center"
                    href="{{ route('mail-inquiries.trash') }}">
                    <span>
                        <i class="fas fa-trash-alt mr-2"></i> Trash
                    </span>
                    <span class="badge badge-warning badge-pill">
                        {{ $trashedCount }}
                    </span>
                </a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        System Configuration
    </div>

    <!-- Nav Item - Settings Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSettings"
            aria-expanded="true" aria-controls="collapseSettings">
            <i class="fas fa-fw fa-cog"></i>
            <span>Settings</span>
        </a>
        <div id="collapseSettings" class="collapse" aria-labelledby="headingSettings"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Configuration:</h6>
                <a class="collapse-item" href="{{ route('settings.index') }}">General Settings</a>
                <a class="collapse-item" href="{{ route('mail-settings.index') }}">Mail Settings</a>
                <!-- You can add more setting sections here if needed -->
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
