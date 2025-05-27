<?php
namespace App\Http\Controllers\candidate;

use App\Models\Contract;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class CandidateContractsController extends Controller
{



    /**
 * Show all contracts for the authenticated candidate.
 */
 public function index()
    {
        $contracts = Contract::whereHas('interview.application', function($q) {
            $q->where('candidate_id', auth::id());
        })
        ->orderBy('contract_date', 'desc')
        ->get();

        return view('candidate.pages.contracts.index', compact('contracts'));
    }

    /**
     * Display the contract and signature pad.
     */
      public function show(Contract $contract)
    {
        // ensure the candidate owns this contract by checking application.user_id
        abort_unless(
            Auth::id() === $contract->interview->application->candidate_id,
            403,
            'Unauthorized access to this contract.'
        );
    
           $details = [
        'Candidate'         => $contract->interview->application->full_name,
        'Job Title'         => $contract->interview->application->job->title,
        'Location'          => $contract->interview->application->job->location,
        'Contract Date'     => $contract->contract_date->format('d M Y'),
        'Start Date'        => $contract->start_date->format('d M Y'),
        'Deadline'          => $contract->deadline->format('d M Y'),
        'Salary'            => $contract->salary,
        'Working Hours'     => $contract->working_hours,
        'Leave Entitlement' => $contract->leave_entitlement,
        'Notice Period'     => $contract->notice_period,
        'Jurisdiction'      => $contract->jurisdiction,
    ];

        return view('candidate.pages.contracts.show', compact('contract','details'));
    }

    /**
     * Handle the candidate’s signature submission.
     */
    public function storeSignature(Request $request, Contract $contract)
    {
        $data = $request->validate([
            'signature' => 'required|string', // base64 image
        ]);

        // Decode base64 and save as PNG
        $sig = $data['signature'];
        if (preg_match('/^data:image\/png;base64,/', $sig)) {
            $sig = substr($sig, strpos($sig, ',') + 1);
        }
        $sig = base64_decode($sig);
        $filename = 'signatures/candidate_' . Str::uuid() . '.png';

        Storage::disk('public')->put($filename, $sig);

        // Update the contract record
        $contract->update([
            'signature_path' => $filename,
            'status'         => 'signed',
        ]);

        return redirect()
            ->route('candidate.contracts.index')
            ->with('success', 'Contract signed successfully.');
    }
}
