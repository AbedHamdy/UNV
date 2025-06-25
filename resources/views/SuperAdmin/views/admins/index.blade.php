@extends('SuperAdmin.layouts.app')
@section('title', 'All Admins')
@section('content')
    <div class="content" id="mainContent">
        <div class="container"
            style="max-width: 900px; margin: 36px auto; background: #fff; border-radius: 10px; box-shadow: 0 6px 32px 0 rgba(44,62,80,0.10); padding: 32px 26px;">
            <h2 style="text-align:center; color: #c0392b; margin-bottom: 18px; font-weight: bold;">
                All Admins
            </h2>
            @if (session('success'))
                <div class="dashboard-alert dashboard-alert-success" id="success-alert">
                    <span class="alert-text">{{ session('success') }}</span>
                    <button class="alert-close" onclick="this.parentElement.style.display='none'">&times;</button>
                </div>
            @endif
            @if (session('error'))
                <div class="dashboard-alert dashboard-alert-error" id="error-alert">
                    <span class="alert-text">{{ session('error') }}</span>
                    <button class="alert-close" onclick="this.parentElement.style.display='none'">&times;</button>
                </div>
            @endif

            <table style="width:100%; border-collapse:collapse; background:#fafafa;">
                <thead>
                    <tr style="background:linear-gradient(to left,#c0392b 80%,#111 100%); color:#fff;">
                        <th style="padding:10px;">#</th>
                        {{-- <th style="padding:10px;">Photo</th> --}}
                        <th style="padding:10px;">Name</th>
                        <th style="padding:10px;">Email</th>
                        <th style="padding:10px;">Category</th>
                        <th style="padding:10px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($admins as $i => $admin)
                        <tr style="border-bottom:1px solid #eee;">
                            <td style="color:#111; padding:10px 8px; text-align:center; vertical-align:middle;">{{ $i + 1 }}</td>
                            {{-- <td style="color:#111; padding:10px 8px; text-align:center; vertical-align:middle;">
                                @if ($admin->image)
                                    <img src="{{ asset('uploads/admins/' . $admin->image) }}" alt="Photo"
                                        style="width:40px; height:40px; border-radius:50%; object-fit:cover;">
                                @else
                                    <span style="color:#bbb;">No Image</span>
                                @endif
                            </td> --}}
                            <td style="color:#111; padding:10px 8px; text-align:center; vertical-align:middle;">{{ $admin->name }}</td>
                            <td style="color:#111; padding:10px 8px; text-align:center; vertical-align:middle;">{{ $admin->email }}</td>
                            <td style="color:#111; padding:10px 8px; text-align:center; vertical-align:middle;">
                                {{ $admin->category ? $admin->category->name : '-' }}
                            </td>
                            <td style="color:#111; padding:10px 8px; text-align:center; vertical-align:middle;">
                                <div style="display: flex; gap: 10px; justify-content: center;">
                                    <a href="{{ route('edit_admin', $admin->id) }}"
                                        style="background:linear-gradient(to left,#111,#c0392b);color:#fff;padding:6px 20px;border-radius:4px;text-decoration:none;font-size:0.97rem;display:inline-block;">
                                        Edit
                                    </a>
                                    <form action="{{ route('delete_admin', $admin->id) }}" method="POST" style="display:inline;">
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
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center; color:#c0392b; padding:22px;">No admins found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
