<?php namespace App\Http\Controllers\Api\V1;

use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class PingController extends Controller
{
    public function ping()
    {
        $agent = new Agent();
        return response()->json([
            'ping'    => true,
            'agent'   => [
                'devices'   => $agent->device(),
                'platform'  => $agent->platform(),
                'browser'   => $agent->browser(),
                'is_desktop'=> $agent->isDesktop(),
                'is_mobile' => $agent->isMobile(),
                'is_tablet' => $agent->isTablet(),
                'is_android' => $agent->isAndroidOS(),
                'browserVersion' => $agent->version($agent->browser()),
                'platformVersion' => $agent->version($agent->platform())
            ],
            'message' => 'success connect server...'
        ], 200);
    }
}