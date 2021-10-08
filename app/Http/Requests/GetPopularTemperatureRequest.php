<?php

namespace App\Http\Requests;

use App\Resolvers\WeatherSourceResolver;
use Illuminate\Foundation\Http\FormRequest;

class GetPopularTemperatureRequest extends FormRequest
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
            'min_count' => 'int|required',
            'city'      => 'string|nullable',
            'from_date' => 'nullable|date',
        ];
    }
}
