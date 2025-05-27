<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\VisaDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgentVisaController extends Controller
{
    public function index()
    {
        $agentId = Auth::id();

        $visas = VisaDocument::whereHas('contract.interview', function ($q) use ($agentId) {
                $q->where('interviews.agent_id', $agentId);
            })
            ->with(['contract.interview.application.candidate'])
            ->latest()
            ->get();

        return view('agent.pages.visa.index', compact('visas'));
    }

    public function show(VisaDocument $visa)
    {
        $agentId = Auth::id();
        abort_if($visa->contract->interview->agent_id !== $agentId, 403);

        $visa->load('contract.interview.application.candidate');

        $raw = [
            'passport_scan.front'    => ['label'=>'Passport Scan (Front)',    'icon'=>'bi-passport-fill'],
            'passport_scan.back'     => ['label'=>'Passport Scan (Back)',     'icon'=>'bi-passport-fill'],
            'passport_photo'         => ['label'=>'Passport Photo',           'icon'=>'bi-person-fill'],
            'national_id.front'      => ['label'=>'National ID (Front)',      'icon'=>'bi-credit-card-fill'],
            'national_id.back'       => ['label'=>'National ID (Back)',       'icon'=>'bi-credit-card-fill'],
            'education_certificates' => ['label'=>'Education Certificates',   'icon'=>'bi-mortarboard-fill'],
            'experience_certificate' => ['label'=>'Experience Certificate',   'icon'=>'bi-briefcase-fill'],
            'police_clearance'       => ['label'=>'Police Clearance',         'icon'=>'bi-file-lock-fill'],
            'medical_certificate'    => ['label'=>'Medical Certificate',      'icon'=>'bi-heart-pulse-fill'],
            'visa_application_form'  => ['label'=>'Visa Application Form',    'icon'=>'bi-file-earmark-text-fill'],
            'offer_letter'           => ['label'=>'Offer Letter',             'icon'=>'bi-file-earmark-check-fill'],
            'resume_cv'              => ['label'=>'Resume / CV',              'icon'=>'bi-file-person-fill'],
            'declaration_consent'    => ['label'=>'Declaration / Consent',    'icon'=>'bi-clipboard2-check-fill'],
            'noc'                    => ['label'=>'No Objection Certificate', 'icon'=>'bi-shield-check-fill'],
        ];

        $fields = [];
        foreach ($raw as $key => $meta) {
            $parts    = explode('.', $key);
            $path     = data_get($visa, $parts);
            $slug     = str_replace('.', '_', $key);
            $fields[] = [
                'label'    => $meta['label'],
                'icon'     => $meta['icon'],
                'path'     => $path,
                'status'   => $visa->{"{$slug}_status"} ?? 'pending',
                'slug'     => $slug,
                'filename' => $path ? basename($path) : null,
                'remarks'  => $visa->{"{$slug}_remarks"},
            ];
        }

        return view('agent.pages.visa.show', compact('visa', 'fields'));
    }

    public function approve(Request $request, VisaDocument $visa, string $field)
    {
        $agentId = Auth::id();
        abort_if($visa->contract->interview->agent_id !== $agentId, 403);

        // 1) approve individual field
        $visa->update(["{$field}_status" => 'approved']);

        // 2) recalculate overall status
        $this->recalculateGlobalStatus($visa);

        return back()->with('success', ucfirst(str_replace('_', ' ', $field)) . ' approved.');
    }

    public function reject(Request $request, VisaDocument $visa, string $field)
    {
        $agentId = Auth::id();
        abort_if($visa->contract->interview->agent_id !== $agentId, 403);

        // 1) validate remarks
        $data = $request->validate([
            'remarks' => 'required|string|max:1000',
        ]);

        // 2) reject individual field
        $visa->update([
            "{$field}_status"  => 'rejected',
            "{$field}_remarks" => $data['remarks'],
        ]);

        // 3) recalculate overall status
        $this->recalculateGlobalStatus($visa);

        return back()->with('error', ucfirst(str_replace('_', ' ', $field)) . ' rejected.');
    }

    /**
     * Determine and persist the global status based on all individual statuses.
     */
    private function recalculateGlobalStatus(VisaDocument $visa): void
    {
        // fields to check
        $singleFields = [
            'passport_scan_front',
            'passport_scan_back',
            'national_id_front',
            'national_id_back',
            'passport_photo',
            'education_certificates',
            'experience_certificate',
            'police_clearance',
            'medical_certificate',
            'visa_application_form',
            'offer_letter',
            'resume_cv',
            'declaration_consent',
            'noc',
        ];

        $statuses = collect($singleFields)
            ->map(fn($slug) => $visa->{"{$slug}_status"} ?? 'pending');

        if ($statuses->contains('rejected')) {
            $overall = 'rejected';
        } elseif ($statuses->every(fn($s) => $s === 'approved')) {
            $overall = 'approved';
        } elseif ($statuses->contains('approved')) {
            $overall = 'inreview';
        } else {
            $overall = 'submitted';
        }

        if ($visa->status !== $overall) {
            $visa->status = $overall;
            $visa->save();
        }
    }






public function approved()
    {
        $agentId = Auth::id();

        $visas = VisaDocument::where('status', 'approved')
            ->whereHas('contract.interview', fn($q) => 
                $q->where('agent_id', $agentId)
            )
            ->with('contract.interview.application.candidate')
            ->latest()
            ->get();

        return view('agent.pages.visa.approved', compact('visas'));
    }





      public function scheduleFlight(VisaDocument $visa)
    {
        abort_unless(
            $visa->contract->interview->agent_id === Auth::id(),
            403,
            'Unauthorized.'
        );

        return view('agent.pages.flight.create', compact('visa'));
    }















}




