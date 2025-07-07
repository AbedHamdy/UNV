@extends('SuperAdmin.layouts.app')
@section('title', 'Edit Courses For Semester')
@section('content')
<div class="content" id="mainContent">
    <div class="container" style="max-width: 500px; margin: 36px auto; background: #fff; border-radius: 10px; box-shadow: 0 6px 32px 0 rgba(44,62,80,0.10); padding: 32px 26px;">
        <h2 style="text-align:center; color: #c0392b; margin-bottom: 18px; font-weight: bold;">
            Edit Courses for <span style="color:#111;">{{ $category->name }}</span> - Level {{ $level->number_level ?? $level->name }} - {{ $semester->name ?? 'Semester' }}
        </h2>

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

        <form method="POST" action="{{ route('update_courses_category', [$category->id, $level->id, $semester->id]) }}">
            @csrf

            @if($courses->count())
                <div style="margin-bottom:22px;">
                    <label style="color:#111; font-weight:500; margin-bottom:8px; display:block;">Current Courses</label>
                    <select name="courses[]" multiple size="8"
                        style="width:100%; padding:10px; border-radius:6px; border:1px solid #ddd; background:#fafafa; color:#111;">
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" selected>{{ $course->name }}</option>
                        @endforeach
                    </select>
                    <div style="color:#888; font-size:0.97rem; margin-top:8px;">
                        (Deselect any course you want to remove. Hold Ctrl or Shift for multi-select.)
                    </div>
                </div>
            @else
                <div style="color:#c0392b; font-size:1.01rem;">No courses found for this term.</div>
            @endif

            <button type="submit"
                style="width:100%; background: linear-gradient(to left, #c0392b, #111); color:#fff; border:none; padding:12px; border-radius:5px; font-size:1.07rem; font-weight:bold; cursor:pointer;">
                Save Changes
            </button>
        </form>
    </div>
</div>
@endsection
