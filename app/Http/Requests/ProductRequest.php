<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'title'              => 'required',
            'category'           => 'required',
            'price'              => 'required|numeric|gte:0',
            'promo_price'        => 'nullable|numeric|min:0|lt:price',
            'variation'          => 'required_if:type,Вариация',
            'new_subvariation.*' => 'required_if:type,Вариация',
        ];
    }

    public function messages()
    {
        return [
            'promo_price.lt' => 'Промо цената трябва да бъде по-малка от цената на продукта',
            'required_if'    => 'Задължително',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $errorMessageForSameNames = 'Не може да има вариации с еднакви имена';

            if ($this->subvariation) {
                foreach ($this->subvariation as $key => $property) {
                    foreach ($this->subvariation as $key1 => $property1) {
                        if ($property != '' && $key != $key1 && $property == $property1) {
                            $validator->errors()->add("subvariation.$key", $errorMessageForSameNames);
                        }
                    }
                    if ($this->new_subvariation) {
                        foreach ($this->new_subvariation as $key1 => $property1) {
                            if ($property != '' && $property == $property1) {
                                $validator->errors()->add("subvariation.$key", $errorMessageForSameNames);
                                $validator->errors()->add("new_subvariation.$key1", $errorMessageForSameNames);
                            }
                        }
                    }
                }
            }
            if ($this->new_subvariation) {
                foreach ($this->new_subvariation as $key => $property) {
                    foreach ($this->new_subvariation as $key1 => $property1) {
                        if ($property != '' && $key != $key1 && $property == $property1) {
                            $validator->errors()->add("new_subvariation.$key", $errorMessageForSameNames);
                        }
                    }
                }
            }
        });
    }
}
