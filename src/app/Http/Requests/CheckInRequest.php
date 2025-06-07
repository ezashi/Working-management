<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckInRequest extends FormRequest
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
            if ($user->currentStatus() !== 'not_working') {
                $validator->errors()->add('status', '既に出勤しています。');
            }

            if ($user->todayAttendance()) {
                $validator->errors()->add('attendance', '本日は既に出勤済みです。');
            }
        });
    }
}
