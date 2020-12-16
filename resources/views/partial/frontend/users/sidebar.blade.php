<div class="wn__sidebar">
    <aside class="widget recent_widget">
        <ul>
            <li class="list-group-item">
                <img src="{{ asset('assets/users/ibrahimhassann.png') }}" alt="{{ auth()->user()->name }}">
            </li>

            <li class="list-group-item"><a href="">My Posts</a></li>
            <li class="list-group-item"><a href="{{route('users.post.create')}}">Create Post</a></li>
            <li class="list-group-item"><a href="">Manage Comments</a></li>
            <li class="list-group-item"><a href="">Update Information</a></li>
            <li class="list-group-item"><a href="" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
        </ul>
    </aside>
</div>