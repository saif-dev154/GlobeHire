<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\VisaDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CandidateVisaController extends Controller
{
    public function index()
    {
        $visas = VisaDocument::where('candidate_id', Auth::id())
            ->latest()
            ->get();

        return view('candidate.pages.visa.index', compact('visas'));
    }

    public function create($contractId)
    {
        // ensure contract belongs to candidate & is approved
        $contract = Contract::where('id', $contractId)
            ->whereHas(
                'interview.application',
                fn($q) => $q->where('candidate_id', Auth::id())
            )->firstOrFail();

        $raw = [
            'passport_scan.front'    => ['label' => 'Passport Scan (Front)',    'icon' => 'bi-passport-fill',   'inputName' => 'passport_scan[]',       'multiple' => true],
            'passport_scan.back'     => ['label' => 'Passport Scan (Back)',     'icon' => 'bi-passport-fill',   'inputName' => 'passport_scan[]',       'multiple' => true],
            'passport_photo'         => ['label' => 'Passport Photo',           'icon' => 'bi-person-fill',     'inputName' => 'passport_photo',        'multiple' => false],
            'national_id.front'      => ['label' => 'National ID (Front)',      'icon' => 'bi-credit-card-fill', 'inputName' => 'national_id[]',         'multiple' => true],
            'national_id.back'       => ['label' => 'National ID (Back)',       'icon' => 'bi-credit-card-fill', 'inputName' => 'national_id[]',         'multiple' => true],
            'education_certificates' => ['label' => 'Education Certificates',   'icon' => 'bi-mortarboard-fill', 'inputName' => 'education_certificates', 'multiple' => false],
            'experience_certificate' => ['label' => 'Experience Certificate',   'icon' => 'bi-briefcase-fill',  'inputName' => 'experience_certificate', 'multiple' => false],
            'police_clearance'       => ['label' => 'Police Clearance',         'icon' => 'bi-file-lock-fill',  'inputName' => 'police_clearance',      'multiple' => false],
            'medical_certificate'    => ['label' => 'Medical Certificate',      'icon' => 'bi-heart-pulse-fill', 'inputName' => 'medical_certificate',   'multiple' => false],
            'visa_application_form'  => ['label' => 'Visa Application Form',    'icon' => 'bi-file-earmark-text-fill', 'inputName' => 'visa_application_form', 'multiple' => false],
            'offer_letter'           => ['label' => 'Offer Letter',             'icon' => 'bi-file-earmark-check-fill', 'inputName' => 'offer_letter', 'multiple' => false],
            'resume_cv'              => ['label' => 'Resume / CV',              'icon' => 'bi-file-person-fill', 'inputName' => 'resume_cv',             'multiple' => false],
            'declaration_consent'    => ['label' => 'Declaration / Consent',    'icon' => 'bi-clipboard2-check-fill', 'inputName' => 'declaration_consent', 'multiple' => false],
            'noc'                    => ['label' => 'No Objection Certificate', 'icon' => 'bi-shield-check-fill', 'inputName' => 'noc',                  'multiple' => false],
        ];

        $fields = [];
        foreach ($raw as $key => $meta) {
            $fields[] = array_merge($meta, [
                'errorKey' => str_replace('.', '_', $key),
            ]);
        }

        return view('candidate.pages.visa.create', [
            'isEdit' => false,
            'fields' => $fields,
            'contractId' => $contractId, 
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'contract_id'             => 'required|exists:contracts,id',
            'passport_scan'           => 'required|array|size:2',
            'passport_scan.*'         => 'file|mimes:pdf,jpeg,jpg,png|max:5120',
            'national_id'             => 'required|array|size:2',
            'national_id.*'           => 'file|mimes:pdf,jpeg,jpg,png|max:5120',
            'passport_photo'          => 'required|file|mimes:jpeg,jpg,png|max:2048',
            'education_certificates'  => 'required|file|mimes:pdf|max:5120',
            'experience_certificate'  => 'nullable|file|mimes:pdf|max:5120',
            'police_clearance'        => 'required|file|mimes:pdf|max:5120',
            'medical_certificate'     => 'required|file|mimes:pdf|max:5120',
            'visa_application_form'   => 'required|file|mimes:pdf|max:5120',
            'offer_letter'            => 'required|file|mimes:pdf|max:5120',
            'resume_cv'               => 'required|file|mimes:pdf,doc,docx|max:5120',
            'declaration_consent'     => 'required|file|mimes:pdf|max:5120',
            'noc'                     => 'nullable|file|mimes:pdf|max:5120',
        ]);

        $candidateId = Auth::id();
        $ps = $this->storePair($request->file('passport_scan'), 'passport_scan', $candidateId);
        $nid = $this->storePair($request->file('national_id'),    'national_id', $candidateId);

        $single = [
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
        $uploads = [];
        foreach ($single as $f) {
            if ($request->hasFile($f)) {
                $uploads[$f] = $request->file($f)
                    ->store("visa_documents/{$candidateId}/{$f}", 'public');
            }
        }

        VisaDocument::create(array_merge([
            'candidate_id'  => $candidateId,
            'contract_id'   => $data['contract_id'],
            'passport_scan' => $ps,
            'national_id'   => $nid,
            'status'        => 'submitted',
        ], $uploads));

        return redirect()
            ->route('candidate.contracts.index')
            ->with('success', 'Visa documents uploaded successfully.');
    }

    /**
     * Show the form for editing only rejected visa document fields.
     */
    public function edit(VisaDocument $visa)
    {
        // 1) Ownership guard
        abort_if($visa->candidate_id !== Auth::id(), 403);

        // 2) Build the same raw field definitions as in create()
        $raw = [
            'passport_scan.front'    => ['label' => 'Passport Scan (Front)',    'icon' => 'bi-passport-fill',   'inputName' => 'passport_scan[]',       'multiple' => true],
            'passport_scan.back'     => ['label' => 'Passport Scan (Back)',     'icon' => 'bi-passport-fill',   'inputName' => 'passport_scan[]',       'multiple' => true],
            'passport_photo'         => ['label' => 'Passport Photo',           'icon' => 'bi-person-fill',     'inputName' => 'passport_photo',        'multiple' => false],
            'national_id.front'      => ['label' => 'National ID (Front)',      'icon' => 'bi-credit-card-fill', 'inputName' => 'national_id[]',         'multiple' => true],
            'national_id.back'       => ['label' => 'National ID (Back)',       'icon' => 'bi-credit-card-fill', 'inputName' => 'national_id[]',         'multiple' => true],
            'education_certificates' => ['label' => 'Education Certificates',   'icon' => 'bi-mortarboard-fill', 'inputName' => 'education_certificates', 'multiple' => false],
            'experience_certificate' => ['label' => 'Experience Certificate',   'icon' => 'bi-briefcase-fill',  'inputName' => 'experience_certificate', 'multiple' => false],
            'police_clearance'       => ['label' => 'Police Clearance',         'icon' => 'bi-file-lock-fill',  'inputName' => 'police_clearance',      'multiple' => false],
            'medical_certificate'    => ['label' => 'Medical Certificate',      'icon' => 'bi-heart-pulse-fill', 'inputName' => 'medical_certificate',   'multiple' => false],
            'visa_application_form'  => ['label' => 'Visa Application Form',    'icon' => 'bi-file-earmark-text-fill', 'inputName' => 'visa_application_form', 'multiple' => false],
            'offer_letter'           => ['label' => 'Offer Letter',             'icon' => 'bi-file-earmark-check-fill', 'inputName' => 'offer_letter', 'multiple' => false],
            'resume_cv'              => ['label' => 'Resume / CV',              'icon' => 'bi-file-person-fill', 'inputName' => 'resume_cv',             'multiple' => false],
            'declaration_consent'    => ['label' => 'Declaration / Consent',    'icon' => 'bi-clipboard2-check-fill', 'inputName' => 'declaration_consent', 'multiple' => false],
            'noc'                    => ['label' => 'No Objection Certificate', 'icon' => 'bi-shield-check-fill', 'inputName' => 'noc',                  'multiple' => false],
        ];

        // 3) Filter to only the fields that have been rejected
        $fields = [];
        foreach ($raw as $key => $meta) {
            $slug    = str_replace('.', '_', $key);
            $status  = $visa->{$slug . '_status'}  ?? 'pending';
            $remarks = $visa->{$slug . '_remarks'} ?? null;

            if ($status === 'rejected') {
                $fields[] = array_merge($meta, [
                    'status'   => $status,
                    'remarks'  => $remarks,
                    'errorKey' => $slug,
                ]);
            }
        }

        // 4) Render the same create.blade.php form, in edit mode
        return view('candidate.pages.visa.create', [
            'isEdit' => true,
            'visa'   => $visa,
            'fields' => $fields,
        ]);
    }

    public function update(Request $request, VisaDocument $visa)
    {
        // 1) Ownership guard
        abort_if($visa->candidate_id !== Auth::id(), 403);

        // 2) Validate incoming files
        $rules = [
            'passport_scan_front'      => 'sometimes|file|mimes:pdf,jpeg,jpg,png|max:5120',
            'passport_scan_back'       => 'sometimes|file|mimes:pdf,jpeg,jpg,png|max:5120',
            'national_id_front'        => 'sometimes|file|mimes:pdf,jpeg,jpg,png|max:5120',
            'national_id_back'         => 'sometimes|file|mimes:pdf,jpeg,jpg,png|max:5120',
            'passport_photo'           => 'sometimes|file|mimes:jpeg,jpg,png|max:2048',
            'education_certificates'   => 'sometimes|file|mimes:pdf|max:5120',
            'experience_certificate'   => 'nullable|file|mimes:pdf|max:5120',
            'police_clearance'         => 'sometimes|file|mimes:pdf|max:5120',
            'medical_certificate'      => 'sometimes|file|mimes:pdf|max:5120',
            'visa_application_form'    => 'sometimes|file|mimes:pdf|max:5120',
            'offer_letter'             => 'sometimes|file|mimes:pdf|max:5120',
            'resume_cv'                => 'sometimes|file|mimes:pdf,doc,docx|max:5120',
            'declaration_consent'      => 'sometimes|file|mimes:pdf|max:5120',
            'noc'                      => 'nullable|file|mimes:pdf|max:5120',
        ];
        $request->validate($rules);

        $cid     = Auth::id();
        $updates = [];

        // Helper to reset status & remarks for a given slug
        $resetField = function(string $slug) use (&$updates) {
            $updates["{$slug}_status"]  = 'pending';
            $updates["{$slug}_remarks"] = null;
        };

        //
        // 3) Passport Scan Front/Back
        //
        $ps = $visa->passport_scan ?: [];
        if ($request->hasFile('passport_scan_front')) {
            $ps['front'] = $request->file('passport_scan_front')
                              ->store("visa_documents/{$cid}/passport_scan", 'public');
            $updates['passport_scan'] = $ps;
            $resetField('passport_scan_front');
        }
        if ($request->hasFile('passport_scan_back')) {
            $ps['back'] = $request->file('passport_scan_back')
                             ->store("visa_documents/{$cid}/passport_scan", 'public');
            $updates['passport_scan'] = $ps;
            $resetField('passport_scan_back');
        }

        //
        // 4) National ID Front/Back
        //
        $nid = $visa->national_id ?: [];
        if ($request->hasFile('national_id_front')) {
            $nid['front'] = $request->file('national_id_front')
                              ->store("visa_documents/{$cid}/national_id", 'public');
            $updates['national_id'] = $nid;
            $resetField('national_id_front');
        }
        if ($request->hasFile('national_id_back')) {
            $nid['back'] = $request->file('national_id_back')
                             ->store("visa_documents/{$cid}/national_id", 'public');
            $updates['national_id'] = $nid;
            $resetField('national_id_back');
        }

        //
        // 5) Single‐file fields
        //
        $singleFields = [
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
        foreach ($singleFields as $field) {
            if ($request->hasFile($field)) {
                // delete old file
                if ($visa->$field) {
                    Storage::disk('public')->delete($visa->$field);
                }
                // store new file
                $updates[$field] = $request->file($field)
                                          ->store("visa_documents/{$cid}/{$field}", 'public');
                $resetField($field);
            }
        }

        // 6) Apply per-field updates
        if (!empty($updates)) {
            $visa->update($updates);
        }

        // 7) Refresh to get latest status columns
        $visa->refresh();

        // 8) Define exactly your status columns (matching migration)
        $statusFields = array_merge(
            ['passport_scan_front','passport_scan_back','national_id_front','national_id_back'],
            $singleFields
        );

        // 9) Gather each field's status (NULL → pending)
        $statuses = collect($statusFields)
            ->map(fn($slug) => $visa->{"{$slug}_status"} ?? 'pending');

        // 10) Determine overall status:
        if ($statuses->contains('rejected')) {
            $overall = 'rejected';
        } elseif ($statuses->every(fn($s) => $s === 'approved')) {
            $overall = 'approved';
        } elseif ($statuses->contains('approved')) {
            $overall = 'inreview';
        } else {
            // all are still 'pending'
            $overall = 'submitted';
        }

        // 11) Persist overall status if changed
        if ($visa->status !== $overall) {
            $visa->status = $overall;
            $visa->save();
        }

        // 12) Redirect back with a message
        return redirect()
            ->route('candidate.visa.index')
            ->with('success', 'Documents updated successfully');
    }

    public function show(VisaDocument $visa)
    {
        abort_if($visa->candidate_id !== Auth::id(), 403);

        // Define the label/icon metadata
        $raw = [
            'passport_scan.front'    => ['label' => 'Passport Scan (Front)',    'icon' => 'bi-passport-fill'],
            'passport_scan.back'     => ['label' => 'Passport Scan (Back)',     'icon' => 'bi-passport-fill'],
            'passport_photo'         => ['label' => 'Passport Photo',           'icon' => 'bi-person-fill'],
            'national_id.front'      => ['label' => 'National ID (Front)',      'icon' => 'bi-credit-card-fill'],
            'national_id.back'       => ['label' => 'National ID (Back)',       'icon' => 'bi-credit-card-fill'],
            'education_certificates' => ['label' => 'Education Certificates',   'icon' => 'bi-mortarboard-fill'],
            'experience_certificate' => ['label' => 'Experience Certificate',   'icon' => 'bi-briefcase-fill'],
            'police_clearance'       => ['label' => 'Police Clearance',         'icon' => 'bi-file-lock-fill'],
            'medical_certificate'    => ['label' => 'Medical Certificate',      'icon' => 'bi-heart-pulse-fill'],
            'visa_application_form'  => ['label' => 'Visa Application Form',    'icon' => 'bi-file-earmark-text-fill'],
            'offer_letter'           => ['label' => 'Offer Letter',             'icon' => 'bi-file-earmark-check-fill'],
            'resume_cv'              => ['label' => 'Resume / CV',              'icon' => 'bi-file-person-fill'],
            'declaration_consent'    => ['label' => 'Declaration / Consent',    'icon' => 'bi-clipboard2-check-fill'],
            'noc'                    => ['label' => 'No Objection Certificate', 'icon' => 'bi-shield-check-fill'],
        ];

        $fields = [];
        foreach ($raw as $key => $meta) {
            // split into [field, side?]
            $parts = explode('.', $key);
            if (count($parts) === 2) {
                [$field, $side] = $parts;
                $path = $visa->{$field}[$side] ?? null;
            } else {
                $field = $parts[0];
                $path  = $visa->{$field} ?? null;
            }

            $slug = str_replace('.', '_', $key);

            $fields[] = [
                'label'    => $meta['label'],
                'icon'     => $meta['icon'],
                'path'     => $path,
                'filename' => $path ? basename($path) : null,
                'status'   => $visa->{$slug . '_status'}  ?? 'pending',
                'remarks'  => $visa->{$slug . '_remarks'} ?? null,
            ];
        }

        return view('candidate.pages.visa.show', compact('visa', 'fields'));
    }

    public function destroy(VisaDocument $visa)
    {
        abort_if($visa->candidate_id !== Auth::id(), 403);

        foreach (
            [
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
            ] as $f
        ) {
            Storage::disk('public')->delete($visa->$f);
        }

        $visa->delete();

        return redirect()
            ->route('candidate.dashboard')
            ->with('success', 'All visa documents deleted.');
    }

    private function storePair(array $files, string $field, int $candidateId): array
    {
        $sides = ['front', 'back'];
        $out = [];
        foreach ($sides as $i => $side) {
            $out[$side] = $files[$i]
                ->store("visa_documents/{$candidateId}/{$field}", 'public');
        }
        return $out;
    }
}
