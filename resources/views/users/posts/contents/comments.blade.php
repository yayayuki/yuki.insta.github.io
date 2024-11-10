<div class="mt-3">
    {{-- Show all comments here --}}
    @if ($post->comments->isNotEmpty())
        <hr>
        <ul class="list-group">
            @foreach ($post->comments->take(3) as $comment)
                <li class="list-group-item bg-transparent border-0 p-0 mb-2">
                    <a href="{{ route('profile.show', $comment->user_id) }}" class="text-decoration-none text-dark fw-bold">{{ $comment->user->name }}</a>
                    &nbsp;
                    <p class="d-inline fw-light">{{ $comment->body }}</p>

                    <form action="{{ route('comment.destroy', $comment->id) }}" method="post">
                        @csrf
                        @method('DELETE')

                        <span class="text-uppercase text-secondary xsmall">{{ date('M d, Y', strtotime($comment->created_at)) }}</span>

                        {{-- If the Auth user is the OWNER of the comment, show a delete btn. --}}
                        @if (Auth::user()->id === $comment->user->id )
                            &middot;    {{-- &middot; = middle dot - it add a dot --}}

                            <button type="submit" class="border-0 bg-transparent text-danger p-0 xsmall">Delete</button>
                        @endif
                    </form>
                </li>
            @endforeach

            @if ($post->comments->count() > 3)
                <a href="{{ route('post.show', $post->id) }}" class="text-decoration-none small mb-2">View all {{ $post->comments->count() }} comments</a>
            @endif
        </ul>
    @endif



    <form action="{{ route('comment.store', $post->id) }}" method="post">
        @csrf

        <div class="input-group">
            <textarea name="comment_body{{ $post->id }}" cols="30" rows="1" class="form-control form-control-sm" placeholder="Add a comment...">{{ old('comment_body' . $post->id) }}</textarea>
            <button type="submit" class="btn btn-outline-secondary btn-sm" title="Post"><i class="fa-regular fa-paper-plane"></i></button>
        </div>
        {{-- Error --}}
        @error('comment_body' . $post->id)
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </form>
</div>