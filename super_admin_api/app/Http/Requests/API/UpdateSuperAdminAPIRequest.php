<?php

namespace App\Http\Requests\API;

use App\Models\SuperAdmin;
use InfyOm\Generator\Request\APIRequest;

class UpdateSuperAdminAPIRequest extends APIRequest
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
        $rules = SuperAdmin::$rules;

        return $rules;
    }
}
