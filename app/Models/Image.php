<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{

    use HasFactory;

    #fillable will allow us to save large amounts of data
    protected $fillable = ['title', 'file', 'dimensions', 'user_id', 'slug'];

    #create dir with subfolders in date format
    public static function makeDirectory()
    {
        $subfolder = 'images/' . date("Y/m/d");

        Storage::makeDirectory($subfolder);

        return $subfolder;
    }

    #this method will return the image size
    #getimagesize() will return an array with the image dimensions where the first two items are width and height
    #we will define two array variables for the first two items of the array returned by getimagesize() => width and height
    #the method will return a concatenated variables
    #the static keyword will allow us to use the method without instantiating the model
    public static function getDimensions($image)
    {
        [$width, $height] = getimagesize(Storage::path($image));
        return $width . 'x' . $height;
    }

    public static function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function fileUrl()
    {
        $info = Storage::url($this->file);

        // $fileParts = pathinfo($info);

        // if (!isset($fileParts['filename'])) {
        //     $fileParts['filename'] = substr($fileParts['basename'], 0, strrpos($fileParts['basename'], '.'));
        // }

        // $name = $fileParts['basename'];

        return $info;

    }

    public function permalink()
    {
        return $this->slug ? route("image.show", $this->slug) : '#';
    }

    public function route($method, $key = 'id')
    {
        return route("image.{$method}", $this->$key);
    }

    #the method below will check if a slug exists in the db
    #if it exists will return a slug and number
    public function getSlug()
    {

        $slug = str($this->title)->slug();

        $numSlugsFound = static::where('slug', 'regexp', "^" . $slug . "(-[0-9])?")->count();

        if ($numSlugsFound > 0) {
            return $slug . "-" . $numSlugsFound + 1;
        }

        return $slug;
    }

    protected static function booted()
    {
        #will allow the creation of new image/ model with published set to true
        static::creating(function ($image) {
            if ($image->title) {
                $image->slug = $image->getSlug();
                $image->is_published = true;
            }
        });

        #will update the title and prevent the slug to be updated
        static::updating(function ($image) {
            if ($image->title && !$image->slug) {
                $image->slug = $image->getSlug();
                $image->is_published = true;
            }
        });

        #will remove the image that was deleted from the database
        static::deleted(function ($image) {
            Storage::delete($image->file);
        });
    }
}
