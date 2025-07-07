<div class="sidebar" id="sidebar">
    <!-- Dashboard Icon Button -->
    <a href="{{ route('dashboard_Admin') }}" class="sidebar-btn" style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
        <svg width="22" height="22" fill="#fff" viewBox="0 0 24 24">
            <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8v-10h-8v10zm0-18v6h8V3h-8z"/>
        </svg>
        <span style="font-size:1.07rem;">Dashboard</span>
    </a>

    <a href="{{ route('create_student') }}" class="sidebar-btn" style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
    <svg width="22" height="22" fill="#fff" viewBox="0 0 24 24">
        <path d="M15 14c2.7 0 5 2.3 5 5v1H4v-1c0-2.7 2.3-5 5-5h6zm-3-2c-1.7 0-3-1.3-3-3s1.3-3
            3-3 3 1.3 3 3-1.3 3-3 3zm7-5V5h-2V3h2V1h2v2h2v2h-2v2h-2z"/>
    </svg>
        <span style="font-size:1.07rem;">Create Student</span>
    </a>




    <!-- Student Code Search -->
    {{-- {{ route('search_student_by_code') }} --}}
    <form action="{{ route("search") }}" method="post" style="margin: 20px;">
        @csrf
        <div class="input-group">
            <input type="integer" name="student_code" class="form-control" placeholder="Enter Student Code" required
                style="border-radius: 4px 0 0 4px; border: none; height: 42px; background: #222; color: #fff;">
            <button type="submit" class="btn" style="background: #e67e22; color: #fff; border-radius: 0 4px 4px 0; border: none;">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </form>

    <form action="{{ route("enrollment") }}" method="post" style="margin: 20px;">
        @csrf
        <div class="input-group">
            <input type="integer" name="student_code" class="form-control" placeholder="Enter Student Code" required
                style="border-radius: 4px 0 0 4px; border: none; height: 42px; background: #222; color: #fff;">
            <button type="submit" class="btn" style="background: #e67e22; color: #fff; border-radius: 0 4px 4px 0; border: none;">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </form>
</div>
