<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Survey;
use Carbon\Carbon;

class ApiController extends Controller 
{
    public function getServices(Request $request)
    {  
        $services = Service::get();

        if ($services) {               
            return response()->json([
                'message' => 'Success',
                'errors' => false,
                'data' => $services,
            ]);                               
   
        } else {
            return response()->json([
                'message' => 'Failed',
                'errors' => true,
            ]);
        } 
    
    }

    public function getSurveys(Request $request)
    {
        $surveys = Survey::join('services', 'services.id', 'surveys.service_id')
            ->get([
                'services.id', 
                'services.name', 
                'surveys.created_at', 
                'surveys.updated_at', 
               ]);

        if ($surveys) {               
            return response()->json([
                'message' => 'Success',
                'errors' => false,
                'data' => $surveys,
            ]);                               
   
        } else {
            return response()->json([
                'message' => 'Failed',
                'errors' => true,
            ]);
        } 

    } 

    public function getFilterSurveys(Request $request)
    {
        $year = $request->input('year');
        $month = $request->input('month');

        if (empty($year)) {
            $year = now()->year; // Default to the current year if year is empty
        }

        if (empty($month)) {
            $month = null;
        }

        $year = is_numeric($year) ? (int) $year : now()->year;

        // Validate the year value
        if ($year < 2023) {
            return response()->json([
                'message' => 'Invalid year format',
                'errors' => true,
            ]);
        }

        // Query based on year and optionally month
        $query = Survey::join('services', 'services.id', 'surveys.service_id')
            ->whereYear('surveys.created_at', $year);

        if ($month !== null) {
            $query->whereMonth('surveys.created_at', $month);
        }

        $surveys = $query->get([
            'services.id',
            'services.name',
            'surveys.created_at',
            'surveys.updated_at',
        ]);

        if ($surveys) {
            return response()->json([
                'message' => 'Success',
                'errors' => false,
                'data' => $surveys,
            ]);
        } else {
            return response()->json([
                'message' => 'Failed',
                'errors' => true,
            ]);
        }
    }

    public function addSurvey(Request $request)
    {
        $service_name = $request->service_name;
        $service = Service::where('name', $service_name)
            ->first('id');
      
        $add_survey = Survey::create([
            'service_id' => $service->id,
        ]);

        if($add_survey) {
            return response()->json([
                'message' => 'Success',
                'errors' => false,
            ]);

        } else  {
            return response()->json([
                'message' => 'Failed',
                'errors' => true,
            ]);
        } 

    } 

}