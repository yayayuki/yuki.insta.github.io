@extends('layouts.app')

@section('title', 'Following')
    
@section('content')
    @include('users.profile.header')

    {{-- Show list of followers here --}}
    <div style="margin-top: 100px">
        @if ($user->following->isNotEmpty())
            <div class="row justify-content-center">
                <div class="col-4">
                    <h3 class="text-secondary text-center">Following</h3>

                    @foreach ($user->following as $following)
                        <div class="row align-items-center mt-3">
                            {{-- AVATAR --}}
                            <div class="col-auto">
                                <a href="{{ route('profile.show', $following->following->id) }}">
                                    @if ($following->following->avatar)
                                        <img src="{{ $following->following->avatar }}" alt="{{ $following->following->name }}" class="rounded-circle avatar-sm">
                                    @else
                                        <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                                    @endif
                                </a>
                            </div>
                            {{-- NAME --}}
                            <div class="col ps-0 text-truncate">
                                <a href="{{ route('profile.show', $following->following->id) }}" class="text-decoration-none text-dark fw-bold">{{ $following->following->name }}</a>
                            </div>
                            {{-- FOLLOW/UNFOLLOW BTN --}}
                            <div class="col-auto">
                                {{-- Show a Follow or Following btn. Do not show anythig if it's the Auth user. --}}
                                @if (Auth::user()->id !== $following->following->id)
                                    @if ($following->following->isFollowed())
                                        <form action="{{ route('follow.destroy', $following->following->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                
                                            <button type="submit" class="border-0 bg-transparent p-0 text-secondary">Following</button>
                                        </form>
                                    @else
                                        <form action="{{ route('follow.store', $following->following->id) }}" method="post">
                                            @csrf
                                            <button type="submit" class="border-0 bg-transparent p-0 text-primary">Follow</button>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <h3 class="text-secondary text-center">No Following Yet</h3>
        @endif
    </div>
@endsection