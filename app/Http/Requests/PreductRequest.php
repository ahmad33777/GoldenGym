<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PreductRequest extends FormRequest
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
            'product_name' => 'required|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|numeric|min:0',
            'image' => 'nullable|image',
            'category_id' => 'required',
            'production_date' => 'nullable|date',
            'expiry_date' => 'nullable|date|after:production_date',
            'description' => 'nullable|string|min:15',
        ];
    }

    public function messages()
    {
        return [
            'product_name.required' => 'مطلوب حقل اسم المنتج',
            'product_name.string' => 'يجب أن يكون اسم المنتج عبارة عن حروف  أو على  الأقل يحتوي على حرف معبر ',
            'price.numeric' => 'يجل ان يكون سعر المنتح رقم يعبر عن السعر',
            'price.min' => 'لا يمكن أن يكون سعر المنتج أقل من صفر',
            'image.image' => 'الملف المختار غير صحيح أو غير مدعوم من قبل النظام',
            'category_id.required' => 'يجب أن يكون المنتج ذو تصنيف',
            'production_date.date' => 'يجب أن يكون  تاريخ',
            'expiry_date.date' => 'يجب أن يكون تاريخ ',
            'expiry_date.after' => 'يجب أن يكون تاريخ إنتهاء صلاحية المنتج بعد تاريخ الإنتاج !!!',
            'price.required' => 'حقل السعر مطلوب',
            'quantity.required' => 'حقل الكمية مطلوب',
            'description.string' => 'يجب لأن يكون وصف المنتج نص يعبر عن المنتج الجديد',
            'description.min' => 'وصف المنتج يجب أن يكن أكبر من 15 حرف',

        ];
    }
}