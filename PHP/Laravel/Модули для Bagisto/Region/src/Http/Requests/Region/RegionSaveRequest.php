<?php

namespace Webkul\Region\Http\Requests\Region;

use Illuminate\Foundation\Http\FormRequest;

class RegionSaveRequest extends FormRequest
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
            'alias'      => 'min:2|max:200|unique:regions,alias',
            'enable' => 'in:1,0',
        ];
    }
}
