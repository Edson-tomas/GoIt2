<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Image;

class ImageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        if ($this->method() == 'PUT') {
            return [
                'title' => 'required'
            ];
        }
        return [
            'file' => 'required|image',
            'title' => 'nullable'

        ];
    }

    public function getData()
    {
        #the validated method will return an array with validated data
        $data = $this->validated() + [
            'user_id' => 1 #$this->user()->id,
        ];

        #to check if the file exists
        if ($this->hasFile('file')) {

            #makeDirectory will create a directory and subdirectory based on the current date and return it
            #created in Image Model
            $directory = Image::makeDirectory();

            $data['file'] = $this->file->store($directory);

            $data['dimensions'] = Image::getDimensions($data['file']);

        }

        return $data;
    }



}
