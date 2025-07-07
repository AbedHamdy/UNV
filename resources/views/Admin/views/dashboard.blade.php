@extends("Admin.layouts.app")

@section('content')

<div class="container" style="margin-top: 60px;">
    @if (session('success'))
        <div class="dashboard-alert dashboard-alert-success" id="success-alert" style="background: linear-gradient(to left, #43a047 80%, #222 100%); color: #fff;">
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
        <div class="dashboard-alert dashboard-alert-error" id="error-alert" style="background: linear-gradient(to left, #e67e22 70%, #111 100%); color: #fff;">
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

            <div style=" background: linear-gradient(to right, #111, #222); border: 1px solid #e67e22; border-radius: 16px; box-shadow: 0 4px 20px rgba(230, 126, 34, 0.2); padding: 30px; text-align: center; color: #fff;">
                <img src="{{ asset('images/admins/' . $admin->image) }}" alt="Admin Image" style=" width: 120px; height: 120px; object-fit: cover; border-radius: 50%; border: 3px solid #e67e22; margin-bottom: 20px;">
                <h2 style="color: #e67e22; margin-bottom: 10px;">{{ $admin->name }}</h2>
                <p>
                    <strong>
                        Email:
                    </strong>
                    {{ $admin->email }}
                </p>
                <p>
                    <strong>
                        Specialization:
                    </strong>
                    {{ $category ? $category->name : 'Not Assigned' }}
                </p>

                <hr style="border-top: 1px solid #e67e22; width: 60%; margin: 20px auto;">
                {{-- {{ route('admin.change-password') }} --}}
                <a href="" style="display: inline-block; margin-top: 20px; padding: 10px 20px; background: #e67e22; color: #fff; border-radius: 8px; text-decoration: none; transition: background 0.3s;">
                    Change Password
                </a>

                <p style="opacity: 0.9;">Here you can manage students and provide academic guidance.</p>
            </div>

        </div>
    </div>
</div>
@endsection
