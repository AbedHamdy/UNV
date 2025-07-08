@extends('Doctor.layouts.app')

@section('title', 'Dashboard')

@section('content')

    <div class="container" style="margin-top: 60px;">
        @if (session('success'))
            <div class="dashboard-alert dashboard-alert-success" id="success-alert"
                style="background: linear-gradient(to left, #27ae60 80%, #222 100%); color: #fff;">
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
            <div class="dashboard-alert dashboard-alert-error" id="error-alert"
                style="background: linear-gradient(to left, #c0392b 70%, #111 100%); color: #fff;">
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

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div
                    style="background: linear-gradient(to right, #111, #222); border: 1px solid #27ae60; border-radius: 16px; box-shadow: 0 4px 20px rgba(39, 174, 96, 0.2); padding: 30px; text-align: center; color: #fff;">

                    <img src="{{ asset('images/doctors/' . $doctor->image) }}" alt="Doctor Image"
                        style="width: 120px; height: 120px; object-fit: cover; border-radius: 50%; border: 3px solid #27ae60; margin-bottom: 20px;">

                    <h2 style="color: #27ae60; margin-bottom: 10px;">{{ $doctor->name }}</h2>

                    <p><strong>Email:</strong> {{ $doctor->email }}</p>
                    <p><strong>Course:</strong> {{ $course ? $course->name : 'Not Assigned' }}</p>

                    @if (isset($categories) && $categories->count())
                        <p><strong>Specializations:</strong></p>
                        <div style="margin-bottom: 15px;">
                            @foreach ($categories as $category)
                                {{-- {{ route('doctor.categories.show', $category->id) }} --}}
                                <a href="{{ route('all_students', $category->id) }}"
                                    style="background: #27ae60; color: #fff; padding: 6px 12px; border-radius: 20px; margin: 3px; display: inline-block; text-decoration: none;">
                                    {{ $category->name }}
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p><strong>Specializations:</strong> Not Assigned</p>
                    @endif

                    <hr style="border-top: 1px solid #27ae60; width: 60%; margin: 20px auto;">

                    <a href=""
                        style="display: inline-block; margin-top: 20px; padding: 10px 20px; background: #27ae60; color: #fff; border-radius: 8px; text-decoration: none; transition: background 0.3s;">
                        Change Password
                    </a>

                    <p style="opacity: 0.9;">Here you can view your info and access academic tools.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
