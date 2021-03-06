@extends('layout')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-12">
        @if (session('message'))
        <div class="alert alert-success" role="alert">
            {{ session('message') }}
        </div>
        @endif
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                User Profile
            </div>
            <div class="row justify-content-center">
                <div class="col-md-3">
                    <img src="/avatar/{{ $user->avatar }}" class="img-fluid">
                    <div class="row justify-content-center mt-4 mb-4">
                        <h2 class="title">
                            {{ $user->first_name }} {{ $user->last_name }}
                        </h2>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="row justify-content-center">
                                <h3>
                                    {{ $user->followers->count() }}
                                </h3>
                            </div>
                            <div class="row justify-content-center">
                                Followers
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row justify-content-center">
                                <h3>
                                    {{ $user->following->count() }}
                                </h3>
                            </div>
                            <div class="row justify-content-center">
                                Following
                            </div>
                        </div>
                    </div>
                    @if (Auth::user()->id !== $user->id)
                    <form action="/relationship/{{ $relationship != null ? $relationship->id : '' }}" method="POST">
                        @csrf
                        @method($relationship != null ? "DELETE" : "POST")
                        <input type="hidden" name="follower_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="followed_id" value="{{ $user->id}} ">
                        <div class="row justify-content-center mt-4">
                            <div class="col">
                                <button class="btn btn-primary btn-block" type="submit">
                                    {{ $relationship != null ? "Unfollow" : "Follow" }}
                                </button>
                            </div>
                        </div>
                    </form>
                    @endif
                    <div class="row justify-content-center mt-4 mb-4">
                        <a href="/answer/{{ $user->id }}">
                            Learned {{ $user->getLearnedWords()->count() }} words
                        </a>
                    </div>
                </div>
                <div class="col-md-9">
                    <ul class="list-unstyled">
                        @foreach ($user->activities->sortByDesc('created_at')->take(10) as $activity)
                        <li class="media mt-4">
                            <img src="/avatar/{{ $user->avatar }}" width="75" class="mr-3 img-fluid" alt="...">
                            <div class="media-body">
                                <p>
                                    <a href="/profile/{{ $activity->user->id }}">
                                        {{ $activity->user->id === auth()->user()->id ? 'You' : $activity->user->first_name }}
                                    </a>
                                    {{ $activity->content }}
                                </p>
                                <small
                                    class="muted">{{ Carbon\Carbon::parse($activity->created_at)->diffForHumans() }}</small>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
