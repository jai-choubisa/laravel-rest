<?php
declare(strict_types = 1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\DetailRequest;
use Carbon\Carbon;

class DetailsController extends Controller
{
    /**
     * function to return JSON response for /api/details Get request
     */
    public function index(DetailRequest $request) : JsonResponse
    {
        //1. check which third party api to call
        if($request['sourceId'] == 'space')
        {
            $url = 'https://api.spacexdata.com/v2/launches?launch_year='.$request['year'].'&limit='.$request['limit'];
        } else if($request['sourceId'] == 'comics')
        {
            $url = 'https://xkcd.com/'.$request['comicId'].'/info.0.json';
        } else 
        {
            abort(404, 'Api Request not Found');
        }

        //2. call getDetail with url of get request
        $result = $this->getDetails($url);
        
        //3. format data into response array
        $response = $this->formatDataForResponse($result,$request);
        
        //4. return response
        return response()->json($response);
    }

    /**
     * Get request to third party url
     */
    public function getDetails(string $url) : string
    {
        try 
        {
            $client = new \GuzzleHttp\Client();
            $response = $client->get($url);
            $data = $response->getBody()->getContents();
            return $data;
        } catch (\Exception $ex) 
        {
            abort(404, 'Unable To Call Third Party Api Request');
        }
    }

    /**
     * Format Result to Response Data Format
     */
    public function formatDataForResponse(string $body,DetailRequest $request) : array
    {
        $data = [];
        $result = json_decode($body);
        if($request['sourceId'] == 'space')
        {
            $data['meta'] = [
                "request" => [
                    "sourceId" => $request['sourceId'],
	        		"year" => $request['year'],
	        		"limit" => $request['limit']
                ],
                "timestamp" => Carbon::now()->toISOString()
            ];
            $data['data'] = []; 
            foreach ($result as $value) {
                $data['data'][] = [
                    "number" => $value->flight_number,
                    "date" => Carbon::parse($value->launch_date_utc, 'UTC')->toDateString(),
                    "name" => $value->mission_name,
                    "link" => $value->links->article_link,
                    "details" => $value->details
                ];        		
            }
        }else if($request['sourceId'] == 'comics')
        {
            $data['meta'] = [
                "request" => [
                    "sourceId" => $request['sourceId'],
	        		"comicId" => $request['comicId']
                ],
                "timestamp" => Carbon::now()->toISOString()
            ];
            $data['data'] = []; 
            $data['data'][] = [
                "number" => $result->num,
                "date" => Carbon::createFromDate($result->year, $result->month, $result->day)->toDateString(),
                "name" => $result->title,
                "link" => $result->img,
                "details" => $result->transcript
            ];     
        }

        return $data;
    }
}
