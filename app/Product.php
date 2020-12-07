<?php

namespace App;

use App\Scopes\CommonFilterScopes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\URL;

class Product extends Model
{
    use CommonFilterScopes, SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
        'id',
        'name',
        'description',
        'picture_id',
        'category_id',
        'permalink',
        'price',
        'promo_price',
        'type',
    ];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function picture()
    {
        return $this->hasOne('App\Picture', 'id', 'picture_id');
    }

    public function subProperties()
    {
        return $this->hasMany('App\ProductSubProperties', 'product_id', 'id');
    }

    public function pictures()
    {
        return $this->belongsToMany(Picture::class);
    }

    public function variation()
    {
        return $this->hasOne('App\Variation');
    }

    public function getPicture(): string
    {
        return URL::to($this->picture ? $this->picture->filename : 'images/empty.jpg');
    }

    public function getPictureThumbnail(int $size = 3): string
    {
        return url($this->picture ? $this->picture->thumbnails->firstWhere('size', $size)->filename : "images/empty$size.jpg");
    }

    public function getPrimaryPictureThumbnail(int $size = 3): string
    {
        return url($this->picture_id ? Picture::find($this->picture_id)->thumbnails->firstWhere('size', $size)->filename : "images/empty$size.jpg");
    }

    public function getThumbnail(int $num = 1): string
    {
        return URL::to($this->picture ? $this->picture->thumbnails->where('size', $num)[$num]->filename : "images/empty{$num}.jpg");
    }

    public function priceText(): string
    {
        return (int)$this->price . '<sup>' . substr($this->price, strpos($this->price, '.') + 1) . '</sup>' . ' лв.';
    }

    public function realPrice()
    {
        return isset($this->promo_price) ? $this->promo_price . 'лв.' : $this->price . 'лв.';
    }

    public function promoPriceText(): string
    {
        if (isset($this->promo_price)) {
            return (int)$this->promo_price . '<sup>' . substr($this->promo_price, strpos($this->promo_price, '.') + 1) . '</sup>' . ' лв.';
        }
    }

    public function discountText(): string
    {
        return '-' . (100 - ($this->promo_price / $this->price) * 100) . '%';
    }

    public static function cyrillicToLatin(string $textcyr): string
    {
        $cyr = [
            'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п',
            'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я',
            'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П',
            'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я',
        ];
        $lat = [
            'a', 'b', 'v', 'g', 'd', 'e', 'io', 'zh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p',
            'r', 's', 't', 'u', 'f', 'h', 'ts', 'ch', 'sh', 'sht', 'a', 'i', 'y', 'e', 'yu', 'ya',
            'A', 'B', 'V', 'G', 'D', 'E', 'Io', 'Zh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P',
            'R', 'S', 'T', 'U', 'F', 'H', 'Ts', 'Ch', 'Sh', 'Sht', 'A', 'I', 'Y', 'e', 'Yu', 'Ya',
        ];

        return str_replace($cyr, $lat, $textcyr);
    }

    public static function sanitize(string $string, bool $force_lowercase = false, bool $anal = false): string
    {
        $strip = ["~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
                  "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
                  "â€”", "â€“", ",", "<", ".", ">", "/", "?"];
        $clean = trim(str_replace($strip, "-", strip_tags($string)));
        $clean = preg_replace('/\s+/', "-", $clean);
        $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean;

        return ($force_lowercase) ?
            (function_exists('mb_strtolower')) ?
                mb_strtolower($clean, 'UTF-8') :
                strtolower($clean) :
            $clean;
    }

    public function getRealPriceAttribute()
    {
        return $this->promo_price ?? $this->price;
    }

}
