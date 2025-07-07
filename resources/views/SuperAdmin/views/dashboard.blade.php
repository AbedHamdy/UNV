@extends('SuperAdmin.layouts.app')
@section('title', 'Dashboard')
@section('content')
    <div class="content" id="mainContent">
        @if (session('success'))
            <div class="dashboard-alert dashboard-alert-success" id="success-alert">
                <span class="alert-text">{{ session('success') }}</span>
                <button class="alert-close" onclick="this.parentElement.style.display='none'">&times;</button>
            </div>
        @endif
        {{-- <div id="dashboard-alert" class="dashboard-alert">
            <span class="alert-text">
                <svg width="20" height="20" style="vertical-align:middle; margin-left:6px" fill="#fff"
                    viewBox="0 0 24 24">
                    <path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z" />
                </svg>
                No categories found.
            </span>
            <button class="alert-close" onclick="document.getElementById('dashboard-alert').style.display='none'">
                &times;
            </button>
        </div> --}}
        <h1 style="text-align:center; margin-top: 60px;">Welcome to the Super Admin Dashboard</h1>
        <p style="text-align:center; font-size:1.2rem;">Here you can manage specializations and all system settings.</p>
    </div>
@endsection
