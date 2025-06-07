<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ModificationRequestStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'attendance_id' => ['required', 'exists:attendances, id'],
            'modified_check_in' => ['nullable', 'date_format:H:i', 'before:modified_check_out'],
            'modified_check_out' => ['nullable', 'date_format:H:i', 'after:modified_check_in'],
            'modified_breaks' => ['nullable', 'array'],
            'modified_breaks.*.start_time' => ['required_with:modified_breaks', 'date_format:H:i', 'before:modified_breaks.*.end_time'],
            'modified_breaks.*.end_time' => ['nullable', 'date_format:H:i', 'after:modified_breaks.*.start_time'],
            'modified_note' => ['required', 'string', 'max:1000'],
        ];
    }

    public function messages()
    {
        return [
            'modified_check_in.before' => '出勤時間もしくは退勤時間が不適切な値です。',
            'modified_check_out.after' => '出勤時間もしくは退勤時間が不適切な値です。',
            'modified_breaks.*.start_time.before' => '休憩時間が勤務時間外です。',
            'modified_breaks.*.end_time.after' => '休憩時間が勤務時間外です。',
            'modified_note.required' => '備考を記入してください',
        ];
    }
}
