@extends('layouts.app')
@section('content')
<div class="col-lg-9 col-12">
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>Title</th>
                <th>Comments</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @forelse($posts as $post)
                <tr>
                    <td>{{ $post->title }}</td>
                    <td><a href="">{{ $post->comments_count }}</a></td>
                    <td>{{ $post->status }}</td>
                    <td>
                        <a href="" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                        <a href="" onclick="if(confirm('Are You sure to Delete This Post ?')){document.getElementById('post-delete-{{$post->id}}').submit();} else{return false;}"  class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                        <form action="" method="post" id="post-delete-{{$post->id}}" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No posts found</td>
                </tr>
            @endforelse
            </tbody>
            <tfoot>
            <tr>
                <td colspan="4">{!! $posts->links() !!}</td>
            </tr>
            </tfoot>
        </table>

    </div>
</div>

<div class="col-lg-3 col-12 md-mt-40 sm-mt-40">
    @include('partial.frontend.users.sidebar')
</div>

@endsection