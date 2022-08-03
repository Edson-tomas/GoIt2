<h1>All Images</h1>

<a href="{{route('image.create')}}">Upload new Image</a>

@if($message = session('message'))
{{ $message }}
@endif

@foreach ($images as $image)
<div>
    <a href="{{$image->permalink()}}">
        <img src="{{$image->fileUrl()}}" alt="{{$image->title}}" width="300">
    </a>
    <div>
        <a href="{{$image->route('edit')}}">Edit</a> |
        <form action="{{$image->route('destroy')}}" method="POST" style="display: inline">
            @csrf
            @method('DELETE')
            <button type="submit" onclick="return confirm('Are you sure you want to delete this image?')">Delete</button>
        </form>
    </div>
</div>

@endforeach
