<?php

namespace Xoxoday\Disclaimer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class XouserRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|regex:/^[\pL\s\.]+$/u|max:50',
            'email' => 'nullable|email',
            'mobile' => 'required|digits:10',
            'code' => 'required',
            'city' => 'nullable|max:50',
            'g-recaptcha-response' => 'required|recaptchav3:form,0.5'
        ];
    }


    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            'name.max' => 'The maximum characters allowed for name is 50.',
            'name.regex:/^[\pL\s\.]+$/u' => 'The name format is invalid.',
            'email.email' => 'The email format is invalid.',
            'mobile.required' => 'Mobile number required.',
            'mobile.digits_between:1,11' => 'Mobile number must be of 10 digit.',
            'code.required' => 'Unique Code required.',
            'city.max:50' => 'The maximum characters allowed for city is 50.',
            'g-recaptcha-response.required' => 'Captcha required.',
            'g-recaptcha-response.recaptchav3:form,0.5' => 'Captcha could not be verified.'
        ];
    }
}
