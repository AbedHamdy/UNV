<div class="sidebar" id="sidebar">
    <!-- Dashboard Icon Button -->
    <a href="{{ route('dashboard_SuperAdmin') }}" class="sidebar-btn" style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
        <svg width="22" height="22" fill="#fff" viewBox="0 0 24 24">
            <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8v-10h-8v10zm0-18v6h8V3h-8z"/>
        </svg>
        <span style="font-size:1.07rem;">Dashboard</span>
    </a>

    <!-- Category Dropdown -->
    <div class="dropdown">
        <button class="sidebar-btn" id="dropdownBtn">
            <svg width="22" height="22" fill="#fff" viewBox="0 0 24 24">
                <path d="M19 13H5v-2h14v2zm-7-7h2v6h-2V6zm0 8h2v6h-2v-6z" />
            </svg>
            Category
            <span style="margin-right:auto;">
                <svg width="18" height="18" fill="#fff" viewBox="0 0 24 24" style="vertical-align:middle;">
                    <path d="M7 10l5 5 5-5z" />
                </svg>
            </span>
        </button>
        <div class="dropdown-content" id="dropdownMenu">
            <a href="{{ route('create_category') }}">Create Category</a>
            <a href="{{ route('all_categories') }}">All Categories</a>
        </div>
    </div>

    {{-- admin --}}
    <div class="dropdown">
        <button class="sidebar-btn" id="dropdownAdminBtn">
            <svg width="22" height="22" fill="#fff" viewBox="0 0 24 24">
                <path d="M12 12c2.7 0 8 1.34 8 4v2H4v-2c0-2.66 5.3-4 8-4zm0-2a4 4 0 100-8 4 4 0 000 8z"/>
            </svg>
            Admin
            <span style="margin-right:auto;">
                <svg width="18" height="18" fill="#fff" viewBox="0 0 24 24" style="vertical-align:middle;">
                    <path d="M7 10l5 5 5-5z" />
                </svg>
            </span>
        </button>
        <div class="dropdown-content" id="dropdownAdminMenu">
            <a href="{{ route('create_admin') }}">Create Admin</a>
            <a href="{{ route('all_admins') }}">All Admins</a>
        </div>
    </div>

    {{-- doctor --}}
    <div class="dropdown">
        <button class="sidebar-btn" id="dropdownDoctorBtn">
            <svg width="22" height="22" fill="#fff" viewBox="0 0 24 24">
                <path d="M12 12c2.7 0 8 1.34 8 4v2H4v-2c0-2.66 5.3-4 8-4zm0-2a4 4 0 100-8 4 4 0 000 8z"/>
            </svg>
            Doctor
            <span style="margin-right:auto;">
                <svg width="18" height="18" fill="#fff" viewBox="0 0 24 24" style="vertical-align:middle;">
                    <path d="M7 10l5 5 5-5z" />
                </svg>
            </span>
        </button>
        <div class="dropdown-content" id="dropdownDoctorMenu">
            <a href="{{ route('create_doctor') }}">Create Doctor</a>
            <a href="{{ route('all_doctors') }}">All Doctors</a>
        </div>
    </div>

    {{-- course --}}
    <div class="dropdown">
        <button class="sidebar-btn" id="dropdownCourseBtn">
            <svg width="22" height="22" fill="#fff" viewBox="0 0 24 24">
                <path d="M4 6v16h16V6H4zm2 2h12v12H6V8zm7-6v2h-2V2h2zM8 4V2h8v2H8z"/>
            </svg>
            Course
            <span style="margin-right:auto;">
                <svg width="18" height="18" fill="#fff" viewBox="0 0 24 24" style="vertical-align:middle;">
                    <path d="M7 10l5 5 5-5z" />
                </svg>
            </span>
        </button>
        <div class="dropdown-content" id="dropdownCourseMenu">
            <a href="{{ route('create_course') }}">Create Course</a>
            <a href="{{ route('all_courses') }}">All Courses</a>
        </div>
    </div>

    <a href="{{ route("active_semester") }}" class="sidebar-btn" style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
        <svg width="22" height="22" fill="#fff" viewBox="0 0 24 24">
            <path d="M12 2a10 10 0 100 20 10 10 0 000-20zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
        </svg>
        <span style="font-size:1.07rem;">Active Semester</span>
    </a>
</div>