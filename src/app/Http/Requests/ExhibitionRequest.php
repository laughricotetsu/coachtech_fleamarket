<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            // 1. 商品名
            'name' => [
                'required',
                'string',
            ],

            // 2. 商品説明
            'description' => [
                'required',
                'string',
                'max:255',
            ],

            // 3. 商品画像
            'image' => [
                'required',
                'image',
                'mimes:jpeg,png',
            ],

            // 4. カテゴリー（チェックボックス）
            'categories' => [
                'required',
                'array',
            ],
            'categories.*' => [
                'exists:categories,id',
            ],

            // 5. 商品の状態
            'condition' => [
                'required',
                'string',
            ],

            // 6. 商品価格
            'price' => [
                'required',
                'numeric',
                'min:0',
            ],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '商品名を入力してください。',

            'description.required' => '商品説明を入力してください。',
            'description.max' => '商品説明は255文字以内で入力してください。',

            'image.required' => '商品画像をアップロードしてください。',
            'image.image' => '画像ファイルを選択してください。',
            'image.mimes' => '商品画像はjpegまたはpng形式で指定してください。',

            'categories.required' => '商品のカテゴリーを選択してください。',
            'categories.array' => 'カテゴリーの選択が正しくありません。',

            'condition.required' => '商品の状態を選択してください。',

            'price.required' => '販売価格を入力してください。',
            'price.numeric' => '販売価格は数値で入力してください。',
            'price.min' => '販売価格は0円以上で入力してください。',
        ];
    }
}
