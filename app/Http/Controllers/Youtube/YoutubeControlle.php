<?php

namespace App\Http\Controllers\Youtube;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Psr7\Response;


class YoutubeControlle extends Controller
{
    //return youtube livestreaming id
    public function liveStream()
    {
        $client = new \GuzzleHttp\Client();

        $chanelID = 'UC1WREaxq8LRhdOOmzSFg2pA'; // shraddha tv Live id;
        // $chanelID = 'UCM3bQBUJ0PEbgfe9lAw_Y3Q'; // shraddha tv daily id;
        // $chanelID = 'UCu7cGbQEMgGk8TD0ZYucM5g';
        $apiKey = 'AIzaSyCLaZJEeGlLguMXIEyUxSj-hl4RMQMVAJQ';

        $fullUrl = 'https://www.googleapis.com/youtube/v3/search?part=snippet&channelId=UCM3bQBUJ0PEbgfe9lAw_Y3Q&eventType=live&type=video&key=AIzaSyCLaZJEeGlLguMXIEyUxSj-hl4RMQMVAJQ';

        $url = "https://www.googleapis.com/youtube/v3/search?part=snippet&channelId=$chanelID&eventType=live&type=video&key=$apiKey";

        // $live_data = $client->get($url)->getBody()->getContents();

        // $arrayData = json_decode($live_data, true);

        // $dataAll = collect($arrayData)->collapse();

        // $liveStream_videoID = $dataAll->get('0')['id']['videoId'];

        $request = $client->get($url);
        $response = $request->getBody();
        $data = json_decode($response);
        $liveStream_videoID = $data->items[0]->id->videoId;


        $youtubeID = [
            'video_id' => $liveStream_videoID,
            'url_1' => "https://youtu.be/$liveStream_videoID",
            'url_2' => "https://www.youtube.com/watch?v=$liveStream_videoID"
        ];

        return response($youtubeID, 200)
                  ->header('Content-Type', 'text/plain');

    }
}

