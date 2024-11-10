@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
    <div class="row justify-content-center">
        <div class="col-8">
            <form action="{{ route('profile.update', $user->id) }}" method="post" class="bg-white shadow rounded-3 p-5" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <h3 class="text-secondary fw-light mb-3">Update Profile</h3>

                <div class="row mb-3">
                    <div class="col-4">
                        @if ($user->avatar)
                            <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="rounded-circle d-block mx-auto avatar-lg img-thumbnail">
                        @else
                            <i class="fa-solid fa-circle-user text-secondary d-block text-center icon-lg"></i>
                        @endif
                    </div>
                    <div class="col-auto align-self-end">
                        <input type="file" name="avatar" id="avatar" class="form-control form-control-sm" aria-describedby="avatar-info">
                        <div class="form-text" id="avatar-info">
                            Acceptable formats are jpeg, jpg, png, gif only. <br>
                            Max file size is 1048kb.
                        </div>
                        {{-- error --}}
                        @error('avatar')
                            <p class="text-danger small">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-2">
                    <label for="name" class="form-label fw-bold">Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" autofocus>
                    {{-- error --}}
                    @error('name')
                        <p class="text-danger small">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-2">
                    <label for="email" class="form-label fw-bold">E-Mail Address</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}">
                    {{-- error --}}
                    @error('email')
                        <p class="text-danger small">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="introduction" class="form-label fw-bold">Introduction</label>
                    <textarea name="introduction" id="introduction" cols="30" rows="5" class="form-control" placeholder="Describe yourself">{{ old('introduction', $user->introduction) }}</textarea>
                    {{-- error --}}
                    @error('introduction')
                        <p class="text-danger small">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="btn btn-warning px-5">Save</button>
            </form>
        </div>
    </div>
@endsection