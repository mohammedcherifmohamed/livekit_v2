<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Agence104\LiveKit\AccessToken;
use Agence104\LiveKit\AccessTokenOptions;
use Agence104\LiveKit\VideoGrant;

class MeetingController extends Controller
{
    public function getToken(Request $request)
    {
        $request->validate([
            'roomName' => 'required|string',
            'participantName' => 'required|string',
        ]);

        $roomName = $request->input('roomName');
        $participantName = $request->input('participantName');

        $tokenOptions = (new AccessTokenOptions())
            ->setIdentity($participantName . '__' . bin2hex(random_bytes(2)))
            ->setName($participantName);

        $videoGrant = (new VideoGrant())
            ->setRoomJoin(true)
            ->setRoomName($roomName)
            ->setCanPublish(true)
            ->setCanSubscribe(true);

        $token = (new AccessToken(
            config('services.livekit.api_key'),
            config('services.livekit.api_secret')
        ))
            ->init($tokenOptions)
            ->setGrant($videoGrant)
            ->toJwt();

        return response()->json([
            'serverUrl' => config('services.livekit.url'),
            'roomName' => $roomName,
            'participantToken' => $token,
            'participantName' => $participantName,
        ]);
    }
}
