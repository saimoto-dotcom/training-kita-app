<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminUserUpdateRequest extends FormRequest
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
            'last_name' => ['required', 'string', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                // 自分自身は除外して重複チェック
                Rule::unique('admin_users', 'email')->ignore($this->route('admin_user')),
            ],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // 前後空白をトリムする処理
        $this->merge([
            'last_name' => trim($this->last_name ?? ''),
            'first_name' => trim($this->first_name ?? ''),
            'email' => trim($this->email ?? ''),
        ]);
    }
}
