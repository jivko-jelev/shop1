<?php

namespace App\Http\Requests;

use App\Property;
use App\SubProperty;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
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
            'title'                        => [
                'required',
                Rule::unique('categories')
                    ->where(function ($query) {
                        return $query->where('title', $this->request->get('title'))
                                     ->where('parent_id', $this->request->get('parent_id'));
                    })->ignore($this->category),],
            'alias'                        => [
                'required',
                Rule::unique('categories')
                    ->where('alias', $this->request->get('alias'))
                    ->ignore($this->category),],
            'subproperty.*.*'              => 'required',
            'new_subproperty.*.*'          => 'required',
            'new_property_subproperty.*.*' => 'required',
            'new_property.*'               => 'required',
            'property.*'                   => 'required',
            'parent_id'                    => [
                'nullable',
                Rule::notIn([$this->category->id ?? null]),
            ],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $errorMessageForProperties    = 'В една категория не може да има 2 атрибута с еднакви имена';
            $errorMessageForSubproperties = 'Към един атрибут не може да има 2 податрибута с еднакви имена';

            if ($this->request->get('property')) {
                foreach ($this->request->get('property') as $key => $property) {
                    foreach ($this->request->get('property') as $key1 => $property1) {
                        if ($property != '' && $key != $key1 && $property == $property1) {
                            $validator->errors()->add("property.$key", $errorMessageForProperties);
                        }
                    }

                    if ($this->request->get('new_property')) {
                        foreach ($this->request->get('new_property') as $key2 => $property2) {
                            if ($property != '' && $property == $property2) {
                                $validator->errors()->add("property.$key", $errorMessageForProperties);
                                $validator->errors()->add("new_property.$key2", $errorMessageForProperties);
                            }
                        }
                    }
                }
            }

            if ($this->request->get('new_property')) {
                foreach ($this->request->get('new_property') as $key => $property) {
                    foreach ($this->request->get('new_property') as $key1 => $property1) {
                        if ($property != '' && $key != $key1 && $property == $property1) {
                            $validator->errors()->add("new_property.$key", $errorMessageForProperties);
                        }
                    }
                }
            }

            if ($this->request->get("subproperty")) {
                foreach ($this->request->get('subproperty') as $key => $property) {
                    foreach ($property as $key1 => $subProperty) {
                        foreach ($property as $key2 => $subProperty1) {
                            if ($key1 != $key2 && $subProperty == $subProperty1) {
                                $validator->errors()->add("subproperty.$key.$key1", $errorMessageForSubproperties);
                            }
                        }
                        if ($this->request->get("new_subproperty")) {
                            foreach ($this->request->get("new_subproperty") as $key3 => $property1) {
                                if ($key == $key3) {
                                    foreach ($property1 as $key4 => $subProperty1) {
                                        if ($subProperty == $subProperty1) {
                                            $validator->errors()->add("subproperty.$key.$key1", $errorMessageForSubproperties);
                                            $validator->errors()->add("new_subproperty.$key.$key4", $errorMessageForSubproperties);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

            $this->validateNewSubproperties($validator, 'new_subproperty', $errorMessageForSubproperties);
            $this->validateNewSubproperties($validator, 'new_property_subproperty', $errorMessageForSubproperties);
        });
    }

    public function validateNewSubproperties($validator, string $name, string $errorMessage): void
    {
        if ($this->request->get($name)) {
            foreach ($this->request->get($name) as $key => $property) {
                foreach ($property as $key1 => $subProperty) {
                    if ($subProperty != '') {
                        foreach ($property as $key2 => $item) {
                            if ($key1 != $key2 && $item == $subProperty) {
                                $validator->errors()->add("$name.$key.$key1", $errorMessage);
                            }
                        }
                    }
                }
            }
        }
    }

    public function messages()
    {
        return [
            "title.unique"                        => "Вече съществува такава Категория със същата Главна Категория",
            'subproperty.*.required'              => 'Името на податрибута е задължително',
            'new_subproperty.*.required'          => 'Името на податрибута е задължително',
            'new_property_subproperty.*.required' => 'Името на податрибута е задължително',
            'new_property.*.required'             => 'Името на атрибута е задължително',
            'property.*.required'                 => 'Името на атрибута е задължително',
        ];
    }

}
