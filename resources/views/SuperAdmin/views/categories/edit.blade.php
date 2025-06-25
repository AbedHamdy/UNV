@extends('SuperAdmin.layouts.app')
@section('title', 'Edit Category')
@section('content')
    <div class="content" id="mainContent">
        <div class="container"
            style="max-width: 440px; margin: 36px auto; background: #fff; border-radius: 10px; box-shadow: 0 6px 32px 0 rgba(44,62,80,0.10); padding: 32px 26px;">
            <h2 style="text-align:center; color: #c0392b; margin-bottom: 18px; font-weight: bold;">Edit Category</h2>

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

            <form method="POST" action="{{ route('update_category', $category->id) }}">
                @csrf
                @method('PUT')
                <div style="margin-bottom: 18px;">
                    <label for="categoryName"
                        style="display:block; color:#111; font-weight:500; margin-bottom:6px;">Category Name</label>
                    <input type="text" id="categoryName" name="name" value="{{ old('name', $category->name) }}" required
                        style="width:100%; padding:10px 12px; border-radius:5px; border:1px solid #ddd; background:#fafafa; color:#111; font-size:1rem; outline:none; transition:border 0.2s;">
                    {{-- @error('name')
                        <div style="color:#c0392b; font-size:0.98rem; margin-top:7px;">{{ $message }}</div>
                    @enderror --}}
                </div>
                <button type="submit"
                    style="width:100%; background: linear-gradient(to left, #c0392b, #111); color:#fff; border:none; padding:12px; border-radius:5px; font-size:1.07rem; font-weight:bold; cursor:pointer; transition:background 0.2s;">
                    Update Category
                </button>
            </form>
        </div>
    </div>
@endsection