@extends('SuperAdmin.layouts.app')
@section('title', 'Assign Courses')
@section('content')
    <div class="content" id="mainContent">
        <div class="container"
            style="max-width: 650px; margin: 36px auto; background: #fff; border-radius: 10px; box-shadow: 0 6px 32px 0 rgba(44,62,80,0.10); padding: 32px 26px;">
            <h2 style="text-align:center; color: #c0392b; margin-bottom: 18px; font-weight: bold;">
                Assign Courses to Category: <span style="color:#111;">{{ $category->name }}</span>
            </h2>
            @if (session('success'))
                <div class="dashboard-alert dashboard-alert-success" id="success-alert">
                    <span class="alert-text">
                        <svg width="20" height="20" style="vertical-align:middle; margin-left:6px" fill="#fff"
                            viewBox="0 0 24 24">
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.59L6.41 13l-1.41 1.41L10 19.41l9-9-1.41-1.41z" />
                        </svg>
                        {{ session('success') }}
                    </span>
                    <button class="alert-close" onclick="this.parentElement.style.display='none'">&times;</button>
                </div>
            @endif

            @if (session('error'))
                <div class="dashboard-alert dashboard-alert-error" id="error-alert">
                    <span class="alert-text">
                        <svg width="20" height="20" style="vertical-align:middle; margin-left:6px" fill="#fff"
                            viewBox="0 0 24 24">
                            <path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z" />
                        </svg>
                        {{ session('error') }}
                    </span>
                    <button class="alert-close" onclick="this.parentElement.style.display='none'">&times;</button>
                </div>
            @endif

            @if ($errors->any())
                <div class="dashboard-alert dashboard-alert-error" id="validation-alert" style="text-align:right;">
                    <span class="alert-text" style="align-items: flex-start;">
                        <svg width="20" height="20" style="vertical-align:middle; margin-left:6px" fill="#fff"
                            viewBox="0 0 24 24">
                            <path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z" />
                        </svg>
                        <ul style="margin:0; padding-right:22px;">
                            @foreach ($errors->all() as $error)
                                <li style="margin-bottom:3px;">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </span>
                    <button class="alert-close" onclick="this.parentElement.style.display='none'">&times;</button>
                </div>
            @endif
            <form method="POST" action="{{ route('category_courses_store', $category->id) }}">
                @csrf

                <div style="margin-bottom:18px;">
                    <label style="color:#111; font-weight:500; margin-bottom:8px; display:block;">Select Level</label>
                    <select id="levelSelector" name="level_id" required
                        style="width:100%; padding:10px; border-radius:6px; border:1px solid #ddd; background:#fafafa; color:#111;">
                        <option value="">-- Select Level --</option>
                        @foreach ($levels as $level)
                            <option value="{{ $level->id }}">{{ $level->number_level }}</option>
                        @endforeach
                    </select>
                </div>

                <div style="margin-bottom:18px;">
                    <label style="color:#111; font-weight:500; margin-bottom:8px; display:block;">Select Term</label>
                    <select id="termSelector" name="semester_number" required
                        style="width:100%; padding:10px; border-radius:6px; border:1px solid #ddd; background:#fafafa; color:#111;">
                        <option value="">-- Select Term --</option>
                        <option value="1">First Semester</option>
                        <option value="2">Second Semester</option>
                        <option value="3">Summer Semester</option>
                    </select>
                </div>

                <div style="margin-bottom:24px;">
                    <label style="color:#111; font-weight:500; margin-bottom:8px; display:block;">Select Courses</label>
                    <select name="courses[]" multiple size="8"
                        style="width:100%; padding:10px; border-radius:6px; border:1px solid #ddd; background:#fafafa; color:#111;">
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->name }}</option>
                        @endforeach
                    </select>
                    <div style="color:#888; font-size:0.97rem; margin-top:8px;">
                        (You can select more than one course by pressing Ctrl or Shift with your mouse)
                    </div>
                </div>

                <div style="text-align: center; margin-top: 20px;">
                    <button type="submit"
                        style="background: linear-gradient(to left, #c0392b, #111); color:#fff; border:none; padding:12px 24px; border-radius:5px; font-size:1.07rem; font-weight:bold; cursor:pointer;">
                        Go
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
