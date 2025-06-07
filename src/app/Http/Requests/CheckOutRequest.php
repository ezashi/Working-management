<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckOutRequest extends FormRequest
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
            //
        ];
    }


    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $user = auth()->user();
            if ($user->currentStatus() !== 'working') {
                $validator->errors()->add('status', '出勤中ではありません。');
            }

            $attendance = $user->todayAttendance();
            if ($attendance && $attendance->check_out) {
                $validator->errors()->add('attendance', '本日は既に退勤済みです。');
            }
        });
    }
}
