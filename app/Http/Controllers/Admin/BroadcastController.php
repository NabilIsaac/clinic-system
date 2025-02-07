<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BroadcastController extends Controller
{
    protected $arkeselApiKey;

    public function __construct()
    {
        $this->arkeselApiKey = config('services.arkesel.api_key');
    }

    public function index()
    {
        return view('admin.broadcasts.index');
    }

    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:918',
            'recipient_type' => 'required|in:all,patients,employees'
        ]);

        // Get recipients based on type
        $recipients = $this->getRecipients($request->recipient_type);
        
        // Get phone numbers
        $phoneNumbers = $recipients->pluck('phone_number')->filter()->toArray();

        if (empty($phoneNumbers)) {
            return back()->with('error', 'No valid phone numbers found for selected recipient type.');
        }

        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'api-key' => $this->arkeselApiKey
            ])->post('https://sms.arkesel.com/api/v2/sms/send', [
                'sender' => config('app.name'),
                'message' => $request->message,
                'recipients' => $phoneNumbers,
                'sandbox' => false  // Set to true for testing
            ]);
        
            $responseData = $response->json();
            Log::info('Arkesel API Response:', [
                'headers' => $response->headers(),
                'body' => $responseData,
                'api_key_used' => $this->arkeselApiKey // Log this temporarily for debugging
            ]);
        
            if ($response->successful() && ($responseData['status'] ?? '') === 'success') {
                return back()->with('success', 'Broadcast message sent successfully!');
            }
        
            Log::error('Arkesel API Error:', [
                'status' => $response->status(),
                'response' => $responseData,
                'request_data' => [
                    'sender' => config('app.name'),
                    'recipients' => $phoneNumbers,
                    'message_length' => strlen($request->message)
                ]
            ]);
            
            return back()->with('error', 'Failed to send broadcast message: ' . ($responseData['message'] ?? 'Unknown error'));
        } catch (\Exception $e) {
            Log::error('Error sending broadcast message: ' . $e->getMessage(), [
                'exception' => $e,
                'api_key_used' => $this->arkeselApiKey // Log this temporarily for debugging
            ]);
            return back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    private function getRecipients($type)
    {
        switch ($type) {
            case 'patients':
                return User::role('patient')->get();
            case 'employees':
                return User::whereHas('roles', function($query) {
                    $query->whereNotIn('name', ['patient', 'super-admin', 'nurse', 'receptionist', 'doctor']);
                })->get();
            default:
                return User::all();
        }
    }
}