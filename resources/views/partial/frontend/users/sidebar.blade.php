<div class="wn__sidebar">
    <aside class="widget recent_widget">
        <ul>
            <li class="list-group-item">
                <img src="{{ asset('assets/users/ibrahimhassann.png') }}" alt="{{ auth()->user()->name }}">
            </li>

            <li class="list-group-item"><a href="{{route('frontend.dashboard')}}">My Posts</a></li>
            <li class="list-group-item"><a href="{{route('users.post.create')}}">Create Post</a></li>
            <li class="list-group-item"><a href="{{route('users.comments')}}">Manage Comments</a></li>
            <li class="list-group-item"><a href="{{route('user.edit_info')}}">Update Information</a></li>
            <li class="list-group-item"><a href="" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
        </ul>
    </aside>
</div>
{{-- <div class="page-blog bg--white section-padding--lg blog-sidebar right-sidebar"> --}}
    <div class="col-3"></div>
    <div class="col-3"></div>
    <div class="col-3"></div>
    <div class="col-3"></div>