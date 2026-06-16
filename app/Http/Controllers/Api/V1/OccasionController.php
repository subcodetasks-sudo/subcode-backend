<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\OccasionResource;
use App\Models\Occasion;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class OccasionController extends Controller
{
    use ApiResponse;
    public function index()
    {
        $occasions = Occasion::where('is_active', true)->get();

        return $this->success(OccasionResource::collection($occasions), 'Occasions retrieved successfully');
    }

    public function show($slugOrId)
    {
        $occasion = Occasion::where('is_active', true)->findBySlugOrId($slugOrId);

        if (! $occasion) {
            return $this->error(__('api.data_not_found'), 404);
        }

        return $this->success(new OccasionResource($occasion), 'Occasion retrieved successfully');
    }
}
