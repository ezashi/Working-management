<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Models\ModificationRequest;


class ModificationRequestController extends Controller
{
  public function index()
  {
    $user = auth()->user();

    $pendingRequests = $user->modificationRequests()
      ->with('attendance')
      ->where('status', 'pending')
      ->orderBy('created_at', 'desc')
      ->get();

    $approvedRequests = $user->modificationRequests()
      ->with('attendance')
      ->where('status', 'approved')
      ->orderBy('approved_at', 'desc')
      ->get();

    return view('stamp_correction_request.list', compact('pendingRequests', 'approvedRequests'));
    }
}