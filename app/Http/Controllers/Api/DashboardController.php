<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Property;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Models\SupportTicket;
use App\Models\FinanceRequest;
use App\Models\ServiceRequest;
use App\Models\PropertyRequest;
use App\Models\MarketingRequest;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
   use ApiResponse;
   public function dashboard()
   {
       try {
            return $this->successResponse([]);
       } catch (Exception $e) {
            return $this->serverError('Something went wrong');
       }
   }
}
