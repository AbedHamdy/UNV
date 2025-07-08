@extends('SuperAdmin.layouts.app')
@section('title', 'Edit Doctor')
@section('content')
    <div class="content" id="mainContent">
        <div class="container"
            style="max-width: 480px; margin: 36px auto; background: #fff; border-radius: 10px; box-shadow: 0 6px 32px 0 rgba(44,62,80,0.10); padding: 32px 26px;">
            <h2 style="text-align:center; color: #c0392b; margin-bottom: 18px; font-weight: bold;">
                Edit Doctor
            </h2>

            @if (session('success'))
                <div class="dashboard-alert dashboard-alert-success" id="success-alert">
                    <span class="alert-text">{{ session('success') }}</span>
                    <button class="alert-close" onclick="this.parentElement.style.display='none'">&times;</button>
                </div>
            @endif

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

            <form method="POST" action="{{ route('update_doctor', $doctor->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div style="margin-bottom: 18px;">
                    <label for="name" style="display:block; color:#111; font-weight:500; margin-bottom:6px;">Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $doctor->name) }}"
                        style="width:100%; padding:10px 12px; border-radius:5px; border:1px solid #ddd; background:#fafafa; color:#111; font-size:1rem;">
                </div>
                <div style="margin-bottom: 18px;">
                    <label for="email" style="display:block; color:#111; font-weight:500; margin-bottom:6px;">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $doctor->email) }}"
                        style="width:100%; padding:10px 12px; border-radius:5px; border:1px solid #ddd; background:#fafafa; color:#111; font-size:1rem;">
                </div>
                <div style="margin-bottom: 18px;">
                    <label for="password" style="display:block; color:#111; font-weight:500; margin-bottom:6px;">Password <small>(Leave blank if unchanged)</small></label>
                    <input type="password" id="password" name="password"
                        style="width:100%; padding:10px 12px; border-radius:5px; border:1px solid #ddd; background:#fafafa; color:#111; font-size:1rem;">
                </div>
                <div style="margin-bottom: 18px;">
                    <label for="image" style="display:block; color:#111; font-weight:500; margin-bottom:6px;">Profile Image</label>
                    <input type="file" id="image" name="image" accept="image/*"
                        style="width:100%; padding:10px 12px; border-radius:5px; border:1px solid #ddd; background:#fafafa; color:#111; font-size:1rem;">
                    @if($doctor->image)
                        <div style="margin-top:10px;">
                            <img src="{{ asset('images/doctors/'.$doctor->image) }}" alt="Doctor Image" width="100" style="border-radius: 6px;">
                        </div>
                    @endif
                </div>
                <div style="margin-bottom: 18px;">
                    <label for="course_id" style="display:block; color:#111; font-weight:500; margin-bottom:6px;">Course</label>
                    <select id="course_id" name="course_id"
                        style="width:100%; padding:10px 12px; border-radius:5px; border:1px solid #ddd; background:#fafafa; color:#111; font-size:1rem;">
                        <option value="">Choose Course</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}" {{ old('course_id', $doctor->course_id) == $course->id ? 'selected' : '' }}>
                                {{ $course->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit"
                    style="width:100%; background: linear-gradient(to left, #c0392b, #111); color:#fff; border:none; padding:12px; border-radius:5px; font-size:1.07rem; font-weight:bold; cursor:pointer;">
                    Update Doctor
                </button>
            </form>
        </div>
    </div>
@endsection
