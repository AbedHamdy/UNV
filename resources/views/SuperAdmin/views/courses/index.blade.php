@extends('SuperAdmin.layouts.app')
@section('title', 'All Courses')
@section('content')
    <div class="content" id="mainContent">
        <div class="container"
            style="max-width: 900px; margin: 36px auto; background: #fff; border-radius: 10px; box-shadow: 0 6px 32px 0 rgba(44,62,80,0.10); padding: 32px 26px;">
            <h2 style="text-align:center; color: #c0392b; margin-bottom: 18px; font-weight: bold;">
                All Courses
            </h2>

            @if (session('success'))
                <div class="dashboard-alert dashboard-alert-success" id="success-alert">
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

            @if ($courses->count())
                <table style="width:100%; border-collapse:collapse; background:#fafafa;">
                    <thead>
                        <tr style="background:linear-gradient(to left,#c0392b 80%,#111 100%); color:#fff;">
                            <th style="padding:10px;">#</th>
                            <th style="padding:10px;">Course Name</th>
                            <th style="padding:10px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($courses as $i => $course)
                            <tr style="border-bottom:1px solid #eee;">
                                <td style="color:#111; padding:10px 8px; text-align:center; vertical-align:middle;">
                                    {{ $courses->firstItem() + $i }}
                                </td>
                                <td style="color:#111; padding:10px 8px; text-align:center; vertical-align:middle;">
                                    {{ $course->name }}
                                </td>
                                <td style="color:#111; padding:10px 8px; text-align:center; vertical-align:middle;">
                                    <div style="display: flex; gap: 10px; justify-content: center;">
                                        <a href="{{ route('edit_course', $course->id) }}"
                                            style="background:linear-gradient(to left,#111,#c0392b);color:#fff;padding:6px 20px;border-radius:4px;text-decoration:none;font-size:0.97rem;display:inline-block;">
                                            Edit
                                        </a>
                                        <form action="{{ route('delete_course', $course->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Are you sure?')"
                                                style="background:#c0392b;color:#fff;padding:6px 18px;border:none;border-radius:4px;cursor:pointer;font-size:0.97rem;display:inline-block;">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div style="margin-top:24px; display:flex; justify-content:center;">
                    {{ $courses->links() }}
                </div>
            @else
                <div
                    style="background: linear-gradient(to left, #c0392b 80%, #333 100%); color: #fff; padding: 18px 24px; border-radius: 6px; text-align:center;">
                    No courses found, create course first
                    <br><br>
                    <a href="{{ route('create_course') }}"
                        style="display:inline-block; background:linear-gradient(to left,#43a047 80%, #222 100%); color:#fff; padding:10px 24px; border-radius:5px; font-weight:bold; text-decoration:none; font-size:1.08rem; margin-top:12px; box-shadow:0 2px 8px rgba(44,62,80,0.08); transition:background 0.2s;">
                        + Create Course
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
