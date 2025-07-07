@extends('admin.layouts.app')
@section('title', 'Add Student')

@section('content')
<div class="content" id="mainContent">
    <div class="container"
        style="max-width: 440px; margin: 36px auto; background: #191919f7; border-radius: 10px; box-shadow: 0 6px 32px 0 rgba(230,126,34,0.10); padding: 32px 26px;">
        <h2 style="text-align:center; color: #e67e22; margin-bottom: 18px; font-weight: bold;">Add Student</h2>

        @if (session('success'))
            <div class="dashboard-alert dashboard-alert-success" id="success-alert" style="background: linear-gradient(to left, #43a047 80%, #222 100%); color: #fff;">
                <span class="alert-text">
                    <svg width="20" height="20" style="vertical-align:middle; margin-left:6px" fill="#fff"
                        viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.59L6.41 13l-1.41 1.41L10 19.41l9-9-1.41-1.41z" />
                    </svg>
                    {{ session('success') }}
                </span>
                <button class="alert-close" onclick="this.parentElement.style.display='none'">&times;</button>
            </div>
        @endif

        @if (session('error'))
            <div class="dashboard-alert dashboard-alert-error" id="error-alert" style="background: linear-gradient(to left, #e67e22 70%, #111 100%); color: #fff;">
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
            <div class="dashboard-alert dashboard-alert-error" id="validation-alert" style="background: linear-gradient(to left, #e67e22 70%, #111 100%); color: #fff;">
                <span class="alert-text">
                    <svg width="20" height="20" style="vertical-align:middle; margin-left:6px" fill="#fff"
                        viewBox="0 0 24 24">
                        <path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z" />
                    </svg>
                    <ul style="margin:0; padding-left:22px;">
                        @foreach ($errors->all() as $error)
                            <li style="margin-bottom:3px;">{{ $error }}</li>
                        @endforeach
                    </ul>
                </span>
                <button class="alert-close" onclick="this.parentElement.style.display='none'">&times;</button>
            </div>
        @endif

        <form method="POST" action="{{ route('store_student') }}">
            @csrf
            <div style="margin-bottom:18px;">
                <label for="name" style="display:block; color:#e67e22; font-weight:500; margin-bottom:6px;">Student Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}"
                    style="width:100%;padding:10px;border-radius:5px;border:1px solid #e67e22;background:#222;color:#fff;" required placeholder="Enter student name">
            </div>
            <div style="margin-bottom:18px;">
                <label for="code" style="display:block; color:#e67e22; font-weight:500; margin-bottom:6px;">Student Code</label>
                <input type="text" name="code" id="code" value="{{ $code }}"
                    style="width:100%;padding:10px;border-radius:5px;border:1px solid #e67e22;background:#242424;color:#e67e22;font-weight:bold;" readonly>
            </div>
            <div style="text-align:center;">
                <button type="submit" style="background: #e67e22; color:#fff; padding:10px 32px; border:none; border-radius:6px; font-size:1.1rem;">
                    Add Student
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
