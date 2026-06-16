<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Sector;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\SectorResource;

class SectorController extends Controller
{
    use ApiResponse;
    public function index()
    {
        $sectors = Sector::where('is_active', true)->get();
        return $this->success(SectorResource::collection($sectors) , 'Sectors retrieved successfully');
    }
}
