<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Visitor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Enum\VisitorTypeEnum;

class VisitorController extends Controller
{
    public function track(Request $request)
    {
        $ip = $request->ip();
        $userAgent = $request->userAgent();

        $visitor = Visitor::where('ip', $ip)
            ->where('user_agent', $userAgent)
            ->where('type', VisitorTypeEnum::SITE->value)
            ->first();

        if ($visitor) {
            $visitor->increment('hits');
            $visitor->update(['last_seen' => now()]);
        } else {
            Visitor::create([
                'ip' => $ip,
                'user_agent' => $userAgent,
                'first_seen' => now(),
                'last_seen' => now(),
                'type' => VisitorTypeEnum::SITE->value,
            ]);
        }

            return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => [],
        ], 200);
    }
}
