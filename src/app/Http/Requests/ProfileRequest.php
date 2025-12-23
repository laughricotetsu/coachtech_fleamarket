<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            // プロフィール画像
            'avatar_image' => ['nullable', 'image', 'mimes:jpeg,png'],

            // ユーザー名
            'name' => ['required', 'string', 'max:20'],

            // 郵便番号（ハイフンあり 123-4567）
            'postal_code' => ['required', 'regex:/^\d{3}-\d{4}$/'],

            // 住所
            'address' => ['required', 'string'],
        ];
    }

     public function messages()
    {
        return [
            'avatar_image.image' => 'プロフィール画像は画像ファイルを選択してください。',
            'avatar_image.mimes' => 'プロフィール画像は.jpeg または .png のみ対応しています。',

            'name.required' => 'ユーザー名は必須です。',
            'name.max' => 'ユーザー名は20文字以内で入力してください。',

            'postal_code.required' => '郵便番号は必須です。',
            'postal_code.regex' => '郵便番号は「123-4567」の形式で入力してください。',

            'address.required' => '住所は必須です。',
        ];
    }
}

