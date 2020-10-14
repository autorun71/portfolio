<?php

namespace Webkul\Region\Http\Requests\Props;

use Illuminate\Foundation\Http\FormRequest;

class RegionPropsSaveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'      => 'required|min:2|max:200',
            'placeholder'      => 'required|min:2|max:200',
            'code'      => 'min:2|max:200|unique:region_props,code',
            'sort' => 'between:0,100000',
            'enable' => 'in:1,0',
        ];
    }
}
