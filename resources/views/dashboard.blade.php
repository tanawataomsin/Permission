@extends('layouts.app')
@section('title', 'Dashboard')
@section('contents')

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-0 rounded">
                    <div class="card-header bg-primary text-white">{{ __('Dashboard') }}</div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <img src="https://via.placeholder.com/150" class="rounded-circle" alt="User Image">
                        </div>
                        <div class="text-center">
                            <h5>{{ $user->name }}</h5>
                            <p>{{ $user->email }}</p>
                            <p>
                                Role:
                                @if (!@empty($user->getRoleNames()))
                                    @foreach ($user->getRoleNames() as $rolename)
                                        <label class="badge badge-info mx-1">{{ $rolename }}</label>
                                    @endforeach
                                @endif
                            </p>
                            <p>Joined on: {{ $user->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection
