@extends('SuperAdmin.layouts.app')
@section('title', 'Create Category')

@section('content')
<div class="content" id="mainContent">
    <div class="container"
        style="max-width: 440px; margin: 36px auto; background: #fff; border-radius: 10px; box-shadow: 0 6px 32px 0 rgba(44,62,80,0.10); padding: 32px 26px;">
        <h2 style="text-align:center; color: #c0392b; margin-bottom: 18px; font-weight: bold;">Create Category</h2>
        
        @if (session('success'))
            <div class="dashboard-alert dashboard-alert-success" id="success-alert">
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

        <form method="POST" action="{{ route('store_category') }}">
            @csrf
            <div style="margin-bottom:18px;">
                <label for="name" style="display:block; color:#111; font-weight:500; margin-bottom:6px;">Category Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}"  
                    style="width:100%;padding:10px;border-radius:5px;border:1px solid #ddd;">
            </div>
            <div style="text-align:center;">
                <button type="submit" style="background:#c0392b;color:#fff;padding:10px 32px;border:none;border-radius:6px;font-size:1.1rem;">
                    Create
                </button>
            </div>
        </form>
    </div>
</div>
@endsection