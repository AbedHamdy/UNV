@extends('Doctor.layouts.app')

@section('title', 'All Students in this Course')

@section('content')
    <div class="content" id="mainContent">
        <div class="container"
            style="max-width: 1000px; margin: 36px auto; background: #111; border-radius: 16px; box-shadow: 0 6px 32px rgba(39, 174, 96, 0.2); padding: 32px 26px; color: #fff;">

            <h2 style="text-align:center; color: #27ae60; margin-bottom: 12px; font-weight: bold;">
                Course: {{ $course ?? 'N/A' }}
            </h2>

            {{-- Success Message --}}
            @if (session('success'))
                <div class="dashboard-alert dashboard-alert-success" id="success-alert"
                    style="display: flex; justify-content: space-between; align-items: center; background: linear-gradient(to left, #27ae60 80%, #222 100%); color: #fff; border-radius: 8px; padding: 12px 20px; margin-bottom: 16px;">
                    <div>
                        <svg width="20" height="20" style="vertical-align:middle; margin-left:8px;" fill="#fff"
                            viewBox="0 0 24 24">
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.59L6.41 13l-1.41 1.41L10 19.41l9-9-1.41-1.41z" />
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.style.display='none'"
                        style="background: none; border: none; color: white; font-size: 20px;">&times;</button>
                </div>
            @endif

            {{-- Error Message --}}
            @if (session('error'))
                <div class="dashboard-alert dashboard-alert-error" id="error-alert"
                    style="display: flex; justify-content: space-between; align-items: center; background: linear-gradient(to left, #c0392b 70%, #111 100%); color: #fff; border-radius: 8px; padding: 12px 20px; margin-bottom: 16px;">
                    <div>
                        <svg width="20" height="20" style="vertical-align:middle; margin-left:8px;" fill="#fff"
                            viewBox="0 0 24 24">
                            <path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z" />
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                    <button onclick="this.parentElement.style.display='none'"
                        style="background: none; border: none; color: white; font-size: 20px;">&times;</button>
                </div>
            @endif

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="dashboard-alert dashboard-alert-error" id="validation-alert"
                    style="background: linear-gradient(to left, #e74c3c 70%, #111 100%); color: #fff; border-radius: 8px; padding: 12px 20px; margin-bottom: 16px;">
                    <div style="display: flex; align-items: center;">
                        <svg width="20" height="20" style="vertical-align:middle; margin-left:8px;" fill="#fff"
                            viewBox="0 0 24 24">
                            <path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z" />
                        </svg>
                        <ul style="margin: 0 0 0 16px; padding: 0; list-style: disc;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button onclick="this.parentElement.style.display='none'"
                        style="background: none; border: none; color: white; font-size: 20px;">&times;</button>
                </div>
            @endif

            <table style="width:100%; border-collapse:collapse; background: #1b1b1b; border-radius: 8px; overflow: hidden;">
                <thead>
                    <tr style="background:linear-gradient(to left, #27ae60 80%, #111 100%); color:#fff;">
                        <th style="padding:12px;">#</th>
                        <th style="padding:12px;">Student Code</th>
                        <th style="padding:12px;">Student Name</th>
                        <th style="padding:12px;">Grade</th>
                        <th style="padding:12px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $i => $record)
                        <tr style="border-bottom:1px solid #333;">
                            <td style="padding:10px; text-align:center;">{{ $i + 1 }}</td>
                            <td style="padding:10px; text-align:center;">{{ $record->student->code ?? '-' }}</td>
                            <td style="padding:10px; text-align:center;">{{ $record->student->name ?? '-' }}</td>

                            <form action="{{ route('update_grade', $record->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <td style="padding:10px; text-align:center;">
                                    <input type="number" name="grade"
                                        value="{{ $record->grade->grade ?? '' }}"
                                        class="form-control" placeholder="Enter grade"
                                        min="0" max="100"
                                        style="width: 100px; margin: auto; background: #222; color: #fff; border: 1px solid #444; border-radius: 6px;">
                                </td>
                                <td style="padding:10px; text-align:center;">
                                    <button type="submit"
                                        style="background:linear-gradient(to left,#111,#27ae60);color:#fff;padding:6px 18px;border-radius:6px;text-decoration:none;font-size:0.95rem; border: none;">
                                        Save
                                    </button>
                                </td>
                            </form>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align:center; padding: 24px; color: #ccc;">
                                No students found in this course.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div style="margin-top: 24px;">
                {{ $students->links() }}
            </div>
        </div>
    </div>
@endsection
