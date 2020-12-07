<?php

namespace App;

use App\Scopes\CommonFilterScopes;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use CommonFilterScopes;

    protected $table = 'categories';

    protected $fillable = [
        'id', 'title', 'alias', 'parent_id',
    ];

    public function products()
    {
        return $this->hasMany('App\Product');
    }

    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    public function parent()
    {
        return $this->belongsTo(Category::class);
    }

    protected static function haveSubCategories(Collection $categories, int $id): bool
    {
        foreach ($categories as $category) {
            if ($category->parent_id == $id) {
                return true;
            }
        }

        return false;
    }

    protected static function getCategory(string &$html, Collection $categories, $parent = null)
    {
        foreach ($categories->where('parent_id', $parent) as $category) {
            if (self::haveSubCategories($categories, $category->id)) {
                $html .= '<li class="hassubs">';
                $html .= '<a href="' . route('products.index', $category->alias) . '">' . $category->title .
                         '<i class="fas fa-chevron-right"></i></a>';
                $html .= '<ul>';
                $html .= self::getCategory($html, $categories, $category->id);
                $html .= '</li></ul>';
            } else {
                $html .= '<li><a href="' . route('products.index', $category->alias) . '">' . $category->title .
                         '<i class="fas fa-chevron-right"></i></a></li>';
                $html .= '</li>';
            }
        }
    }

    public static function generateMenu(Collection $categories): string
    {
        $html = '<ul class="cat_menu">';
        self::getCategory($html, $categories);
        $html .= '</ul>';

        return $html;
    }}
