@extends('SuperAdmin.layouts.app')
@section('title', 'Show Category')
@section('content')
    <div class="content" id="mainContent">
        <div class="container"
            style="max-width: 700px; margin: 36px auto; background: #fff; border-radius: 10px; box-shadow: 0 6px 32px 0 rgba(44,62,80,0.10); padding: 32px 26px;">

            <h2 style="text-align:center; color: #c0392b; margin-bottom: 28px; font-weight: bold;">
                Category: <span style="color:#111;">{{ $category->name }}</span>
            </h2>

            @foreach ($category->levels as $level)
                <div style="margin-bottom:28px; border-bottom:1px solid #eee; padding-bottom:16px;">
                    <h3 style="color:#2c3e50; margin-bottom:14px;">
                        Level: {{ $level->number_level ?? $level->name }}
                    </h3>

                    @if ($level->semesters && $level->semesters->count())
                        @foreach ($level->semesters as $semester)
                            <div style="margin-bottom:16px; padding-left:12px;">
                                <h4 style="margin-bottom:8px; color:#2980b9;">
                                    Term:
                                    @php
                                        $termNames = [1 => 'First', 2 => 'Second', 3 => 'Summer'];
                                        $termName = $termNames[$semester->number_semester] ?? 'Unnamed Term';
                                    @endphp
                                    {{ $termName }}
                                </h4>
                                @if ($semester->courses && $semester->courses->count())
                                    <ul style="padding-left:30px;">
                                        @foreach ($semester->courses as $course)
                                            <li style="margin-bottom:6px; color:#111;">
                                                {{ $course->name }}
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <div style="color:#c0392b; font-size:1.01rem; padding-left:10px;">No courses</div>
                                @endif

                                {{-- زرار تعديل الكورسات لهذا التيرم --}}
                                <div style="margin-top:12px;">
                                    {{-- {{ route('category.level.semester.courses.edit', [$category->id, $level->id, $semester->id]) }} --}}
                                    <a href="{{ route("edit_courses_category", [$category->id, $level->id, $semester->id]) }}"
                                        style=
                                        "
                                            display: inline-block;
                                            background: linear-gradient(to left, #43a047 80%, #222 100%);
                                            color: #fff;
                                            border: none;
                                            padding: 8px 22px;
                                            border-radius: 5px;
                                            font-size: 1rem;
                                            font-weight: bold;
                                            text-decoration: none;
                                            box-shadow: 0 2px 8px rgba(44,62,80,0.08);
                                            transition: background 0.18s;
                                        "
                                        onmouseover="this.style.background='linear-gradient(to left,#2ecc71 80%,#222 100%)'"
                                        onmouseout="this.style.background='linear-gradient(to left,#43a047 80%,#222 100%)'">Edit
                                        Courses</a>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div style="color:#c0392b; font-size:1.01rem; padding-left:16px;">No terms</div>
                    @endif

                </div>
            @endforeach

        </div>
    </div>
@endsection
