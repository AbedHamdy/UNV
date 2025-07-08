@extends('admin.layouts.app')
@section('title', 'Enroll Courses')

@section('content')
<div class="content" id="mainContent">
    <div class="container"
        style="max-width: 440px; margin: 36px auto; background: #191919f7; border-radius: 10px; box-shadow: 0 6px 32px 0 rgba(230,126,34,0.10); padding: 32px 26px;">

        <h2 style="text-align:center; color: #e67e22; margin-bottom: 18px; font-weight: bold;">Enroll Student in Courses</h2>

        {{-- Alerts --}}
        @if (session('success'))
            <div class="dashboard-alert dashboard-alert-success" id="success-alert" style="background: linear-gradient(to left, #43a047 80%, #222 100%); color: #fff;">
                <span class="alert-text">{{ session('success') }}</span>
                <button class="alert-close" onclick="this.parentElement.style.display='none'">&times;</button>
            </div>
        @endif

        @if (session('error'))
            <div class="dashboard-alert dashboard-alert-error" id="error-alert" style="background: linear-gradient(to left, #e67e22 70%, #111 100%); color: #fff;">
                <span class="alert-text">{{ session('error') }}</span>
                <button class="alert-close" onclick="this.parentElement.style.display='none'">&times;</button>
            </div>
        @endif

        @if ($errors->any())
            <div class="dashboard-alert dashboard-alert-error" id="validation-alert" style="background: linear-gradient(to left, #e67e22 70%, #111 100%); color: #fff;">
                <ul style="margin:0; padding-left:22px;">
                    @foreach ($errors->all() as $error)
                        <li style="margin-bottom:3px;">{{ $error }}</li>
                    @endforeach
                </ul>
                <button class="alert-close" onclick="this.parentElement.style.display='none'">&times;</button>
            </div>
        @endif

        {{-- Courses Form --}}
        <form method="POST" action="{{ route('store_enrollment') }}">
            @csrf

            <input type="hidden" value="{{ $student->id }}" name="student_id">
            <div style="margin-bottom: 20px;">
                <label style="color:#e67e22; font-weight:500; display:block; margin-bottom:10px;">
                    Select Courses:
                </label>
                {{-- @dd($courses) --}}
                @forelse($courses as $course)
                    <div style="margin-bottom: 10px;">
                        <label style="display: flex; align-items: center; color: #eee;">
                            <input type="checkbox" name="courses[]" value="{{ $course->course_id }}"
                                style="margin-right: 10px;">
                            {{ $course->course->name }}
                        </label>
                    </div>
                @empty
                    <p style="color: #ccc;">No courses found for this semester.</p>
                @endforelse
            </div>

            <div style="text-align:center;">
                <button type="submit"
                    style="background: #e67e22; color:#fff; padding:10px 32px; border:none; border-radius:6px; font-size:1.1rem;">
                    Enroll Now
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
