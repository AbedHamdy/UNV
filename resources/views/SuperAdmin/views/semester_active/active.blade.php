@extends('SuperAdmin.layouts.app')
@section('title', 'Active Semester')

@section('content')
<div class="content" id="mainContent">
    <div class="container"
        style="max-width: 400px; margin: 36px auto; background: #fff; border-radius: 10px; box-shadow: 0 6px 32px 0 rgba(44,62,80,0.10); padding: 32px 26px;">
        <h2 style="text-align:center; color: #c0392b; margin-bottom: 18px; font-weight: bold;">
            Choose Active Semester
        </h2>
        @if ($errors->any())
            <div class="dashboard-alert dashboard-alert-error" id="validation-alert">
                <ul style="margin:0; padding-right:22px;">
                    @foreach ($errors->all() as $error)
                        <li style="margin-bottom:3px;">{{ $error }}</li>
                    @endforeach
                </ul>
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
        <form action="{{ route('store_active_semester') }}" method="POST">
            @csrf
            <div style="margin-bottom: 24px;">
                <label style="display:block;margin-bottom:8px;font-weight:500;">Semester</label>
                <div style="display:flex; flex-direction:column; gap:12px; color:#111;">
                    <label>
                        <input type="radio" name="semester" value="1" required>
                        First Semester
                    </label>
                    <label>
                        <input type="radio" name="semester" value="2">
                        Second Semester
                    </label>
                    <label>
                        <input type="radio" name="semester" value="3">
                        Summer Semester
                    </label>
                </div>
            </div>
            <div style="text-align:center;">
                <button type="submit" style="background:#c0392b;color:#fff;padding:10px 32px;border:none;border-radius:6px;font-size:1.1rem;">Activate</button>
            </div>
        </form>
    </div>
</div>
@endsection