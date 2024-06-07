<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;


class BusController extends Controller
{
    public function getBus()
    {
        
        // Create a new Guzzle client instance
        $client = new Client();

        // API endpoint URL with your desired location and units (e.g., London, Metric units)
        $apiUrl = "https://www.zditm.szczecin.pl/api/v1/vehicles";

        try {

           
            // Make a GET request to the OpenWeather API
            $response = $client->get($apiUrl);

            // Get the response body as an array
            $data = json_decode($response->getBody(), true);
            $data = collect($data["data"]);
            
            $data = $data->sortByDesc('velocity')->values()->all();
            
            $data = collect($data);
            $data10 = $data->take(10);
            $dataDN = $data->countBy("line_type");
            $velocities = [];
            $linesVelo =[];
            $times = [];
            $types =[];
            $dataType = $data->countBy("line_subtype");
            $data10MostEarly = $data->sortByDesc("punctuality")->take(10);
            $data10MostLate = $data->sortBy("punctuality")->take(10);
            $punctuality=[];
            $punctualityNames=[];
            $punctualityValues=[];

            foreach($data10 as $velocity)
            {
                array_push($velocities, $velocity["velocity"]);
            }
            foreach($data10 as $lineNumber){
               array_push($linesVelo, "Linia: {$lineNumber["line_number"]}");
            }
            foreach($dataDN as $time){
                array_push($times, $time);
            }
            
            if(!$dataType->has('normal')){
                $dataType = $dataType->put('normal', 0);
            }
            if(!$dataType->has('semi-fast')){
                $dataType = $dataType->put('semi-fast', 0);
            }
            if(!$dataType->has('fast')){
                $dataType = $dataType->put('fast', 0);
            }
            if(!$dataType->has('replacement')){
                $dataType = $dataType->put('replacement', 0);
            }
            if(!$dataType->has('additional')){
                $dataType = $dataType->put('additional', 0);
            }
            if(!$dataType->has('special')){
                $dataType = $dataType->put('special', 0);
            }
            if(!$dataType->has('tourist')){
                $dataType = $dataType->put('tourist', 0);
            }
           
            foreach($data10MostEarly as $early){
                $punctuality[$early["line_number"]] = abs($early["punctuality"]);
            }
            foreach($data10MostLate as $late){
                $punctuality[$late["line_number"]] = abs($late["punctuality"]);
            }
           
            // dd(collect($punctualityNames));

            $punctuality = collect($punctuality);
            $punctuality = $punctuality->sortDesc()->take(10);
            for($i = 0; $i < 10; $i++){
                $punctualityNames[] = implode("",$punctuality->slice($i,1)->keys()->toArray());
                $punctualityValues[] = implode("",$punctuality->slice($i,1)->values()->toArray());
            }    




            // Handle the retrieved weather data as needed (e.g., pass it to a view)
            return view('bus', ['busData' => $data, 'velocities' => $velocities, 'labels' => $linesVelo, 'times' => $times, 'typeData' => $dataType, 'punctualityNames' => $punctualityNames, 'punctualityValues' => $punctualityValues]);
        } catch (\Exception $e) {
            // Handle any errors that occur during the API request
            return view('api_error', ['error' => $e->getMessage()]);
        }
    }
}