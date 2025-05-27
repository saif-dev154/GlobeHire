@extends('candidate.layouts.app')

@php
  $isEdit = $isEdit ?? false;

  // exact MIME/file filters:
  $acceptMap = [
    'passport_scan'          => 'application/pdf,image/jpeg,image/jpg,image/png',
    'national_id'            => 'application/pdf,image/jpeg,image/jpg,image/png',
    'passport_photo'         => 'image/jpeg,image/jpg,image/png',
    'education_certificates' => 'application/pdf',
    'experience_certificate' => 'application/pdf',
    'police_clearance'       => 'application/pdf',
    'medical_certificate'    => 'application/pdf',
    'visa_application_form'  => 'application/pdf',
    'offer_letter'           => 'application/pdf',
    'resume_cv'              => 'application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    'declaration_consent'    => 'application/pdf',
    'noc'                    => 'application/pdf',
  ];

  // human-readable badges:
  $formatMap = [
    'passport_scan'          => 'PDF, JPG, PNG (≤5 MB each)',
    'national_id'            => 'PDF, JPG, PNG (≤5 MB each)',
    'passport_photo'         => 'JPG, PNG (≤2 MB)',
    'education_certificates' => 'PDF (≤5 MB)',
    'experience_certificate' => 'PDF (≤5 MB)',
    'police_clearance'       => 'PDF (≤5 MB)',
    'medical_certificate'    => 'PDF (≤5 MB)',
    'visa_application_form'  => 'PDF (≤5 MB)',
    'offer_letter'           => 'PDF (≤5 MB)',
    'resume_cv'              => 'PDF, DOC, DOCX (≤5 MB)',
    'declaration_consent'    => 'PDF (≤5 MB)',
    'noc'                    => 'PDF (≤5 MB)',
  ];
@endphp

@section('title', $isEdit ? 'Edit Visa Documents' : 'Upload Required Visa Documents')

@section('content')
<div class="container py-4">
  <div class="card shadow-sm rounded">
    <div class="card-header bg-primary text-white d-flex align-items-center">
      <i class="bi bi-file-earmark-arrow-up-fill me-2"></i>
      <h5 class="mb-0">
        {{ $isEdit ? 'Upload Rejected Files' : 'Upload Required Visa Documents' }}
      </h5>
    </div>
    <div class="card-body">

      @if(!$isEdit || count($fields) > 0)
      <form
        action="{{ $isEdit
            ? route('candidate.visa.update', $visa->id)
            : route('candidate.visa.store') }}"
        method="POST"
        enctype="multipart/form-data"
      >
        @csrf
        @if($isEdit)
          @method('PUT')
        @else
          <input type="hidden" name="contract_id" value="{{ $contractId }}">
        @endif

        <div class="row g-4">
          @foreach($fields as $f)
            @php
              [$field, $side] = array_pad(explode('.', $f['errorKey']), 2, null);
              $accept   = $acceptMap[$field] ?? '';
              $fmt      = $formatMap[$field] ?? '';
              $slug     = str_replace('.', '_', $f['errorKey']);
              // name:
              $name = $isEdit
                ? $slug              // e.g. passport_scan_front
                : $f['inputName'];   // e.g. passport_scan[]
              $multiple = !$isEdit && $f['multiple'] ? 'multiple' : '';
            @endphp

            <div class="col-md-6">
              <label for="{{ $slug }}" class="form-label">
                <i class="bi {{ $f['icon'] }} me-1"></i>
                {{ $f['label'] }}
                @if($fmt)
                  <span class="badge bg-info ms-2">{{ $fmt }}</span>
                @endif
              </label>

              <input
                type="file"
                id="{{ $slug }}"
                name="{{ $name }}"
                class="form-control @error($slug) is-invalid @enderror"
                accept="{{ $accept }}"
                {{ $multiple }}
                @if(! $isEdit) required @endif
              >

              @if(! empty($f['remarks']))
                <div class="form-text text-warning">
                  Rejection reason: {{ $f['remarks'] }}
                </div>
              @else
                <div class="form-text text-light">
                  {{ $isEdit
                    ? 'Replace file if you wish to update it.'
                    : 'Please upload ' . Str::lower($f['label']) . '.'
                  }}
                </div>
              @endif

              @error($slug)
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          @endforeach
        </div>

        <div class="mt-4 text-end">
          <button type="submit" class="btn btn-primary">
            <i class="bi bi-cloud-upload-fill me-1"></i>
            {{ $isEdit ? 'Upload Rejected Files' : 'Upload Documents' }}
          </button>
        </div>
      </form>
      @endif

    </div>
  </div>
</div>
@endsection
