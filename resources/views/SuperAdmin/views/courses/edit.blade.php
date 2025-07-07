@extends('SuperAdmin.layouts.app')
@section('title', 'Edit Course')
@section('content')
    <div class="content" id="mainContent">
        <div class="container"
            style="max-width: 480px; margin: 36px auto; background: #fff; border-radius: 10px; box-shadow: 0 6px 32px 0 rgba(44,62,80,0.10); padding: 32px 26px;">
            <h2 style="text-align:center; color: #c0392b; margin-bottom: 18px; font-weight: bold;">
                Edit Course
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

            <form method="POST" action="{{ route('update_course', $course->id) }}">
                @csrf
                @method('PUT')
                <div style="margin-bottom: 18px;">
                    <label for="name" style="display:block; color:#111; font-weight:500; margin-bottom:6px;">Course Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $course->name) }}" required
                        style="width:100%; padding:10px 12px; border-radius:5px; border:1px solid #ddd; background:#fafafa; color:#111; font-size:1rem;">
                </div>
                <button type="submit"
                    style="width:100%; background: linear-gradient(to left, #c0392b, #111); color:#fff; border:none; padding:12px; border-radius:5px; font-size:1.07rem; font-weight:bold; cursor:pointer;">
                    Save Changes
                </button>
            </form>
        </div>
    </div>
@endsection
