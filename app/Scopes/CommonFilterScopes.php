<?php


namespace App\Scopes;


use Carbon\Carbon;

trait CommonFilterScopes
{

    public function scopeWhereIf($query, $field, $value)
    {
        if ($value) {
            $query->where($field, $value);
        }

        return $query;
    }

    public function scopeWhereLikeIf($query, $field, $value)
    {
        if ($value) {
            $query->where($field, 'like', "%$value%");
        }

        return $query;
    }

    public function scopeWhereBeginsWith($query, $field, $value)
    {
        if ($value) {
            $query->where($field, 'like', "$value%");
        }

        return $query;
    }

    public function scopeWhereDateLessIf($query, $field, $value)
    {
        if ($value) {
            $query->whereDate($field, '<=', Carbon::createFromFormat('d-m-Y', $value));
        }

        return $query;
    }

    public function scopeWhereDateGreaterIf($query, $field, $value)
    {
        if ($value) {
            $query->whereDate($field, '>=', Carbon::createFromFormat('d-m-Y', $value));
        }

        return $query;
    }

    public function getCreatedAtAttribute($timestamp) {
        return Carbon::parse($timestamp)->format('d-m-Y H:i:s');
    }

    public function scopeWhereHasIf($query, $relation, $field, $value)
    {
        if ($value) {
            $query->whereHas(
                $relation,
                function ($query) use ($field, $value) {
                    $query->where($field, $value);
                }
            );
        }

        return $query;
    }
}
