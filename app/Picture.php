<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class Picture extends Model
{
    protected $fillable = ['filename'];

    const MAX_WIDTH  = 800;
    const MAX_HEIGHT = 1200;

    public function thumbnails()
    {
        return $this->hasMany(Thumbnail::class);
    }

    public function cropImage($source, $width, $height): void
    {
        $image    = Image::make($source);
        $newImage = Image::canvas($width, $height);
        if ($image->width() / $width > $image->height() / $height) {
            $image->widen($width);
            $newImage->insert($image, 'top', 0, round($height / 2 - $image->height() / 2));
        } else {
            $image->heighten($height);
            $newImage->insert($image, 'top', round($width / 2 - $image->width() / 2), 0);
        }
        $newImage->save($this->filename);
    }

    public static function generateUniqueFilename(string $fname): string
    {
        $year  = Carbon::today()->year;
        $month = Carbon::today()->month;
//        $path     = substr($fname, 0, strrpos($fname, '/') + 1);
        $path     = '/' . $year . '/' . $month . '/';
        $filename = substr($fname, strrpos($fname, '/') + 1);
        $filename = Product::sanitize(substr($filename, 0, strrpos($filename, '.')));
        $ext      = substr($fname, strrpos($fname, '.') + 1);

        $permalinks = Picture::select('filename')->where('filename', 'like', 'storage' . $path . $filename . '%')->get();
        if ($permalinks->where('filename', '=', "storage$path$filename.$ext")->count() == 0) {
            return "storage$path$filename.$ext";
        } else {
            $counter = 0;
            while ($permalinks->where('filename', '=', "storage$path$filename-" . ++$counter . ".$ext")->count() > 0) {
            }

            Storage::makeDirectory($path . 'thumbnails');

            return 'storage' . $path . $filename . '-' . $counter . '.' . $ext;
        }
    }

    public function generateThumbnails(string $source): void
    {
        $path     = substr($this->filename, 0, strrpos($this->filename, '/') + 1) . 'thumbnails/';
        $filename = substr($this->filename, strrpos($this->filename, '/') + 1);
        $filename = substr($filename, 0, strrpos($filename, '.'));
        $ext      = substr($this->filename, strrpos($this->filename, '.') + 1);

        $pathToThumbnails = substr($path, strpos($path, '/') + 1);

        foreach (Thumbnail::$thumbnails as $key => $thumbnail) {
            $thumbnailFilename = "$path$filename-$thumbnail[0]x$thumbnail[1].$ext";

            Thumbnail::create([
                'filename'   => $thumbnailFilename,
                'picture_id' => $this->id,
                'size'       => $key,
            ]);

            // за да използвам същия метод, които оразмерява снимките в класа Picture
            $picture = new Picture(['filename' => $thumbnailFilename]);
            $picture->cropImage($source, $thumbnail[0], $thumbnail[1]);
        }
    }
}
