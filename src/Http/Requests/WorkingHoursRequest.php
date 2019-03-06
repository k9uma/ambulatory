<?php

namespace Reliqui\Ambulatory\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Reliqui\Ambulatory\ReliquiWorkingHours;

class WorkingHoursRequest extends FormRequest
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
            'id' => 'required|string',
            'location' => 'required|string|exists:reliqui_healthcare_locations,id',
            'doctor' => 'required|string|exists:reliqui_doctors,id',
            'start_date_time' => 'required|date',
            'end_date_time' => 'required|date|after:start_date_time',
            'service_time' => 'nullable|integer',
        ];
    }

    public function workingHoursForm()
    {
        $serviceTime = $this->service_time === null
            ? ReliquiWorkingHours::ESTIMATED_SERVICE_TIME
            : $this->service_time;

        return [
            'id' => $this->id,
            'start_date_time' => $this->start_date_time,
            'end_date_time' => $this->end_date_time,
            'estimated_service_time_in_minutes' => $serviceTime,
            'doctor_id' => $this->doctor,
            'location_id' => $this->location,
        ];
    }
}
