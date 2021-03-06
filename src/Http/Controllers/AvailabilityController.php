<?php

namespace Ambulatory\Http\Controllers;

use Ambulatory\Availability;
use Ambulatory\Http\Middleware\VerifiedDoctor;
use Ambulatory\Http\Requests\AvailabilityRequest;
use Ambulatory\Http\Resources\AvailabilityResource;

class AvailabilityController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(VerifiedDoctor::class);
    }

    /**
     * Update the specified availability in storage.
     *
     * @param  Availability  $availability
     * @return \Illuminate\Http\Resources\Json\JsonResource|\Illuminate\Http\JsonResponse
     */
    public function update(AvailabilityRequest $request, Availability $availability)
    {
        $this->authorize('manage', $availability);

        $availability->update($request->validated());

        return new AvailabilityResource($availability);
    }
}
