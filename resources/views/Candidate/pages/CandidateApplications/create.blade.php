{{-- resources/views/candidate/pages/candidateapplications/create.blade.php --}}
@extends('candidate.layouts.app')

@section('title', 'Apply for Job')

@section('content')
<div class="container py-4">
  <div class="card shadow-sm rounded-2 border-0">
    <div class="card-header bg-primary text-white py-2 px-3">
      <h5 class="mb-0 fw-semibold">
        <i class="bi bi-send-fill me-1"></i> Apply: {{ $job->title }}
      </h5>
      <small class="opacity-75">Job ID: {{ $job->id }}</small>
    </div>

    <div class="card-body p-4">
      <form action="{{ route('candidate.jobs.apply.submit', $job->id) }}"
            method="POST"
            enctype="multipart/form-data">
        @csrf

        {{-- 0. Required Skills --}}
        <h6 class="fw-semibold mb-2">
          0. Required Skills <span class="text-danger">*</span>
        </h6>
        <p class="small text-white mb-3">
          Select one or more skills you possess:
        </p>
        <div class="row gy-2 mb-3">
          @foreach($job->required_skills as $skill)
            <div class="col-md-4">
              <div class="form-check">
                <input class="form-check-input"
                       type="checkbox"
                       id="skill_{{ $loop->index }}"
                       name="skills[]"
                       value="{{ $skill }}"
                       {{ is_array(old('skills')) && in_array($skill, old('skills')) ? 'checked' : '' }}>
                <label class="form-check-label" for="skill_{{ $loop->index }}">
                  {{ ucfirst($skill) }}
                </label>
              </div>
            </div>
          @endforeach
        </div>
        @error('skills')
          <div class="text-danger small mb-3">{{ $message }}</div>
        @enderror

        <hr class="my-4"/>

        {{-- 1. Personal Information --}}
        <h6 class="fw-semibold mb-3">1. Personal Information</h6>
        <div class="row gy-3">
          <div class="col-md-6">
            <label for="full_name" class="form-label">
              Full Name <span class="text-danger">*</span>
            </label>
            <input type="text"
                   id="full_name"
                   name="full_name"
                   class="form-control @error('full_name') is-invalid @enderror"
                   value="{{ old('full_name') }}"
                   required>
            @error('full_name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="col-md-6">
            <label for="date_of_birth" class="form-label">
              Date of Birth <span class="text-danger">*</span>
            </label>
            <input type="date"
                   id="date_of_birth"
                   name="date_of_birth"
                   class="form-control @error('date_of_birth') is-invalid @enderror"
                   value="{{ old('date_of_birth') }}"
                   required>
            @error('date_of_birth')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="col-md-6">
            <label for="gender" class="form-label">
              Gender <span class="text-danger">*</span>
            </label>
            <select id="gender"
                    name="gender"
                    class="form-select @error('gender') is-invalid @enderror"
                    required>
              <option disabled value="">Select Gender</option>
              <option value="male"   {{ old('gender')=='male'   ? 'selected' : '' }}>Male</option>
              <option value="female" {{ old('gender')=='female' ? 'selected' : '' }}>Female</option>
              <option value="other"  {{ old('gender')=='other'  ? 'selected' : '' }}>Other</option>
            </select>
            @error('gender')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="col-md-6">
            <label for="nationality" class="form-label">
              Nationality <span class="text-danger">*</span>
            </label>
            <input type="text"
                   id="nationality"
                   name="nationality"
                   class="form-control @error('nationality') is-invalid @enderror"
                   value="{{ old('nationality') }}"
                   required>
            @error('nationality')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <hr class="my-4"/>

        {{-- 2. Contact Details --}}
        <h6 class="fw-semibold mb-3">2. Contact Details</h6>
        <div class="row gy-3">
          <div class="col-md-6">
            <label for="email" class="form-label">
              Email <span class="text-danger">*</span>
            </label>
            <input type="email"
                   id="email"
                   name="email"
                   class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email') }}"
                   required>
            @error('email')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="col-md-6">
            <label for="phone" class="form-label">
              Phone <span class="text-danger">*</span>
            </label>
            <input type="tel"
                   id="phone"
                   name="phone"
                   class="form-control @error('phone') is-invalid @enderror"
                   value="{{ old('phone') }}"
                   required>
            @error('phone')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="col-12">
            <label for="address" class="form-label">
              Address <span class="text-danger">*</span>
            </label>
            <textarea id="address"
                      name="address"
                      rows="2"
                      class="form-control @error('address') is-invalid @enderror"
                      required>{{ old('address') }}</textarea>
            @error('address')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="col-md-6">
            <label for="country" class="form-label">
              Country of Residence <span class="text-danger">*</span>
            </label>
            <input type="text"
                   id="country"
                   name="country"
                   class="form-control @error('country') is-invalid @enderror"
                   value="{{ old('country') }}"
                   required>
            @error('country')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <hr class="my-4"/>

        {{-- 3. Educational Background --}}
        <h6 class="fw-semibold mb-3">3. Educational Background</h6>
        <div class="row gy-3">
          <div class="col-md-6">
            <label for="highest_degree" class="form-label">
              Highest Degree <span class="text-danger">*</span>
            </label>
            <select id="highest_degree"
                    name="highest_degree"
                    class="form-select @error('highest_degree') is-invalid @enderror"
                    required>
              <option disabled value="">Select Degree</option>
              <option value="high_school" {{ old('highest_degree')=='high_school' ? 'selected':'' }}>High School</option>
              <option value="bachelor"    {{ old('highest_degree')=='bachelor'   ? 'selected':'' }}>Bachelor’s</option>
              <option value="master"      {{ old('highest_degree')=='master'     ? 'selected':'' }}>Master’s</option>
              <option value="phd"         {{ old('highest_degree')=='phd'        ? 'selected':'' }}>PhD</option>
              <option value="other"       {{ old('highest_degree')=='other'      ? 'selected':'' }}>Other</option>
            </select>
            @error('highest_degree')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="col-md-6">
            <label for="institution" class="form-label">
              Institution <span class="text-danger">*</span>
            </label>
            <input type="text"
                   id="institution"
                   name="institution"
                   class="form-control @error('institution') is-invalid @enderror"
                   value="{{ old('institution') }}"
                   required>
            @error('institution')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="col-md-6">
            <label for="field_of_study" class="form-label">
              Field of Study <span class="text-danger">*</span>
            </label>
            <input type="text"
                   id="field_of_study"
                   name="field_of_study"
                   class="form-control @error('field_of_study') is-invalid @enderror"
                   value="{{ old('field_of_study') }}"
                   required>
            @error('field_of_study')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="col-md-6">
            <label for="graduation_date" class="form-label">
              Graduation Date
            </label>
            <input type="date"
                   id="graduation_date"
                   name="graduation_date"
                   class="form-control @error('graduation_date') is-invalid @enderror"
                   value="{{ old('graduation_date') }}">
            @error('graduation_date')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <hr class="my-4"/>

        {{-- 4. Work Experience --}}
        <h6 class="fw-semibold mb-3">4. Work Experience</h6>
        <div class="row gy-3">
          <div class="col-md-6">
            <label for="years_experience" class="form-label">
              Years of Experience <span class="text-danger">*</span>
            </label>
            <input type="number"
                   id="years_experience"
                   name="years_experience"
                   min="0"
                   step="1"
                   class="form-control @error('years_experience') is-invalid @enderror"
                   value="{{ old('years_experience') }}"
                   required>
            @error('years_experience')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="col-md-6">
            <label for="last_employer" class="form-label">Most Recent Employer</label>
            <input type="text"
                   id="last_employer"
                   name="last_employer"
                   class="form-control"
                   value="{{ old('last_employer') }}">
          </div>
          <div class="col-md-6">
            <label for="last_position" class="form-label">Position Held</label>
            <input type="text"
                   id="last_position"
                   name="last_position"
                   class="form-control"
                   value="{{ old('last_position') }}">
          </div>
          <div class="col-md-6">
            <label for="employment_duration" class="form-label">
              Duration (e.g., Jan 2020–Dec 2022)
            </label>
            <input type="text"
                   id="employment_duration"
                   name="employment_duration"
                   class="form-control"
                   value="{{ old('employment_duration') }}">
          </div>
        </div>

        <hr class="my-4"/>

        {{-- 5. Additional Information --}}
        <h6 class="fw-semibold mb-3">5. Additional Information</h6>
        <div class="row gy-3">
          <div class="col-12">
            <label for="cover_letter" class="form-label">Cover Letter</label>
            <textarea id="cover_letter"
                      name="cover_letter"
                      rows="4"
                      class="form-control @error('cover_letter') is-invalid @enderror">{{ old('cover_letter') }}</textarea>
            @error('cover_letter')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="col-md-6">
            <label for="linkedin" class="form-label">LinkedIn URL</label>
            <input type="url"
                   id="linkedin"
                   name="linkedin"
                   class="form-control @error('linkedin') is-invalid @enderror"
                   value="{{ old('linkedin') }}">
            @error('linkedin')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="col-md-6">
            <label for="portfolio" class="form-label">Portfolio URL</label>
            <input type="url"
                   id="portfolio"
                   name="portfolio"
                   class="form-control @error('portfolio') is-invalid @enderror"
                   value="{{ old('portfolio') }}">
            @error('portfolio')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <hr class="my-4"/>

        {{-- 6. Attachments --}}
        <h6 class="fw-semibold mb-3">6. Attachments</h6>
        <div class="row gy-3">
          <div class="col-md-6">
            <label for="resume" class="form-label">
              Resume/CV (PDF/DOC) <span class="text-danger">*</span>
            </label>
            <input type="file"
                   id="resume"
                   name="resume"
                   class="form-control @error('resume') is-invalid @enderror"
                   accept=".pdf,.doc,.docx"
                   required>
            @error('resume')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="col-md-6">
            <label for="other_docs" class="form-label">Other Documents (Optional)</label>
            <input type="file"
                   id="other_docs"
                   name="other_docs[]"
                   class="form-control @error('other_docs.*') is-invalid @enderror"
                   accept=".pdf,.doc,.docx"
                   multiple>
            @error('other_docs.*')
              <div class="text-danger small">{{ $message }}</div>
            @enderror
          </div>
        </div>

        {{-- Submit --}}
        <div class="mt-4 text-end">
          <button type="submit"
                  class="btn btn-success px-4">
            <i class="bi bi-check-circle me-1"></i> Submit Application
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<style>
  .bg-primary {
    background: linear-gradient(135deg, #3b82f6, #2563eb) !important;
  }
</style>
@endsection
