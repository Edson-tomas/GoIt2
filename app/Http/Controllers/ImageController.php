<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use App\Http\Requests\ImageRequest;

class ImageController extends Controller
{
    public function index()
    {
        $images = Image::published()->latest()->paginate(15);

        return view('image.index', compact('images'));
    }

    public function show(Image $image)
    {
        return view('image.show', compact('image'));
    }

    public function create()
    {
        return view('image.create');
    }

    public function store(ImageRequest $request)
    {
        Image::create($request->getData());

        return to_route('image.index')->with('message', 'Image has been uploaded successfully');
    }

    public function edit(Image $image)
    {

        return view('image.edit', compact('image'));
    }

    public function update(ImageRequest $request, Image $image)
    {
        $image->update($request->getData());
        return to_route('image.index')->with('message', 'Image has been updated successfully.');
    }

    public function destroy(Image $image)
    {
        $image->delete();

        return to_route('image.index')->with('message', 'Image has been deleted successfully.');
    }


}
