<?php

namespace App\Http\Controllers\Employer;

use App\Models\Contract;
use App\Models\Interview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class EmployerContractsController extends Controller
{
    public function index(Request $request)
    {
        $employerId = Auth::id();
        $status     = $request->get('status', 'created');

        $baseQuery = Contract::with([
            'interview.application.candidate',
            'interview.application.job',
        ])->whereHas('interview.application.job', function ($q) use ($employerId) {
            $q->where('employer_id', $employerId);
        });

        $createdContracts  = (clone $baseQuery)->where('status', 'created')->get();
        $signedContracts   = (clone $baseQuery)->where('status', 'signed')->get();
        $approvedContracts = (clone $baseQuery)->where('status', 'approved')->get();
        $rejectedContracts = (clone $baseQuery)->where('status', 'rejected')->get();

        return view('employer.pages.contracts.index', compact(
            'createdContracts',
            'signedContracts',
            'approvedContracts',
            'rejectedContracts',
            'status'
        ));
    }

    public function create(int $interviewId)
    {
        $iv       = Interview::with(['application.job', 'application.candidate'])
                             ->findOrFail($interviewId);
        $contract = Contract::where('interview_id', $interviewId)->first();

        return view('employer.pages.contracts.create', compact('iv', 'contract'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'interview_id'      => 'required|exists:interviews,id',
            'contract_date'     => 'required|date',
            'start_date'        => 'required|date',
            'deadline'          => 'required|date',
            'salary'            => 'required|numeric|min:0',
            'body'              => 'required|string',
            'working_hours'     => 'nullable|string',
            'leave_entitlement' => 'nullable|string',
            'termination_terms' => 'nullable|string',
            'notice_period'     => 'nullable|string',
            'jurisdiction'      => 'nullable|string',
        ]);

        DB::transaction(function () use ($data) {
            $interview = Interview::with('application.job')
                                  ->findOrFail($data['interview_id']);

            // prevent duplicate on same interview
            if (Contract::where('interview_id', $interview->id)->exists()) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'interview_id' => 'A contract already exists for this interview. Please edit it.'
                ]);
            }

            Contract::create([
                'employer_id'       => Auth::id(),
                'interview_id'      => $interview->id,
                'contract_date'     => $data['contract_date'],
                'start_date'        => $data['start_date'],
                'deadline'          => $data['deadline'],
                'salary'            => $data['salary'],
                'working_hours'     => $data['working_hours'],
                'leave_entitlement' => $data['leave_entitlement'],
                'termination_terms' => $data['termination_terms'],
                'notice_period'     => $data['notice_period'],
                'jurisdiction'      => $data['jurisdiction'],
                'body'              => $data['body'],
                'status'            => 'created',
            ]);
        });

        return redirect()
               ->route('employer.contracts.index')
               ->with('success', 'Contract created.');
    }

    public function show(Contract $contract)
    {
        
        $employerId = Auth::id();
        abort_unless(
            $contract->interview
                     ->application
                     ->job
                     ->employer_id === $employerId,
            403
        );

        $contract->load([
            'interview.application.candidate',
            'interview.application.job',
        ]);


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



        return view('employer.pages.contracts.show', compact('contract','details'));
    }

    public function edit(Contract $contract)
    {
        abort_if($contract->status !== 'created', 403);

        $iv = Interview::with(['application.job', 'application.candidate'])
                       ->findOrFail($contract->interview_id);

        return view('employer.pages.contracts.create', compact('iv', 'contract'));
    }

    public function update(Request $request, Contract $contract)
    {
        abort_if($contract->status !== 'created', 403);

        $data = $request->validate([
            'contract_date'     => 'required|date',
            'start_date'        => 'required|date',
            'deadline'          => 'required|date',
            'salary'            => 'required|numeric|min:0',
            'body'              => 'required|string',
            'working_hours'     => 'nullable|string',
            'leave_entitlement' => 'nullable|string',
            'termination_terms' => 'nullable|string',
            'notice_period'     => 'nullable|string',
            'jurisdiction'      => 'nullable|string',
        ]);

        $contract->update($data);

        return redirect()
               ->route('employer.contracts.index')
               ->with('success', 'Contract updated.');
    }

    public function destroy(Contract $contract)
    {
        abort_if($contract->status !== 'created', 403);

        $contract->delete();

        return redirect()
               ->route('employer.contracts.index')
               ->with('success', 'Contract deleted.');
    }

    public function approve(Contract $contract)
    {
        abort_if($contract->status !== 'signed', 403);

        $contract->update(['status' => 'approved']);

        return redirect()
               ->route('employer.contracts.index')
               ->with('success', 'Contract approved.');
    }

    public function reject(Request $request, Contract $contract)
    {
        abort_if($contract->status !== 'signed', 403);

        $data = $request->validate([
            'remarks' => 'required|string|max:1000',
        ]);

        $contract->update([
            'status'  => 'rejected',
            'remarks' => $data['remarks'],
        ]);

        return redirect()
               ->route('employer.contracts.index')
               ->with('success', 'Contract rejected.');
    }

    public function showSignature(Contract $contract)
    {
        abort_unless(in_array($contract->status, ['signed', 'approved']), 403);


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
        return view('employer.pages.contracts.show', compact('contract','details'));
    }
}
