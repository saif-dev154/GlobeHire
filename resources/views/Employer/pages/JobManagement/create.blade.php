@extends('employer.layouts.app')

@section('title', isset($job) ? 'Edit Job Post' : 'Create New Job Post')

@section('content')
  <div class="container min-vh-100 d-flex flex-column">
    <main class="flex-grow-1">
      <div class="row justify-content-center">
        <div class="col-lg-9">
          <div class="card shadow border-0 rounded-4">
            <div class="card-header bg-primary bg-gradient text-light text-center py-3 rounded-top-2">
              <h4 class="mb-0 fw-bold">
                <i class="bi bi-briefcase-fill me-2"></i>
                {{ isset($job) ? 'Edit Job Post' : 'Create New Job Post' }}
              </h4>
              <small class="text-white fst-italic">
                {{ isset($job) ? 'Update job details below' : 'Fill the form below to create a new job post' }}
              </small>
            </div>
            <div class="card-body p-4">
              <form
                action="{{ isset($job) ? route('employer.jobs.update', $job->id) : route('employer.jobs.store') }}"
                method="POST" novalidate>
                @csrf
                @if(isset($job)) @method('PUT') @endif

                {{-- Job Title & Location --}}
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label for="jobTitle" class="form-label">Job Title</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="bi bi-briefcase-fill"></i></span>
                      <input
                        type="text"
                        class="form-control"
                        id="jobTitle"
                        name="title"
                        value="{{ old('title', $job->title ?? '') }}"
                        placeholder="Software Developer"
                        required>
                    </div>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="jobLocation" class="form-label">Job Location</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="bi bi-geo-alt-fill"></i></span>
                      <input
                        type="text"
                        class="form-control"
                        id="jobLocation"
                        name="location"
                        value="{{ old('location', $job->location ?? '') }}"
                        placeholder="New York, USA"
                        required>
                    </div>
                  </div>
                </div>

                {{-- Job Description --}}
                <div class="mb-3">
                  <label for="jobDescription" class="form-label">Job Description</label>
                  <textarea
                    class="form-control"
                    id="jobDescription"
                    name="description"
                    rows="4"
                    placeholder="Describe the responsibilities and requirements..."
                    required>{{ old('description', $job->description ?? '') }}</textarea>
                </div>

                {{-- Required Skills --}}
                <div class="mb-3">
                  <label for="requiredSkills" class="form-label">Required Skills</label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-tag-fill"></i></span>
                    <input
                      type="text"
                      class="form-control"
                      id="requiredSkillsInput"
                      placeholder="Type a skill and press Enter"
                      onkeydown="addSkill(event)">
                  </div>
                  @php
                    $existingSkills = old('required_skills', $job->required_skills ?? []);
                    if (!is_array($existingSkills) && is_string($existingSkills)) {
                      $decoded = json_decode($existingSkills, true);
                      $existingSkills = is_array($decoded) ? $decoded : [];
                    }
                  @endphp
                  <div id="skillsContainer" class="mt-2">
                    @foreach($existingSkills as $skill)
                      <span class="badge bg-secondary me-2 mb-2">
                        {{ $skill }}
                        <span class="bi bi-x-circle ms-2" onclick="removeSkill(this)"></span>
                        <input type="hidden" name="required_skills[]" value="{{ $skill }}">
                      </span>
                    @endforeach
                  </div>
                </div>

                {{-- Salary & Structure --}}
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label for="salary" class="form-label">Salary</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="bi bi-currency-dollar"></i></span>
                      <input
                        type="number"
                        class="form-control"
                        id="salary"
                        name="salary"
                        value="{{ old('salary', $job->salary ?? '') }}"
                        placeholder="50000"
                        required>
                    </div>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="salaryStructure" class="form-label">Salary Structure</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="bi bi-graph-up-arrow"></i></span>
                      <select class="form-select" id="salaryStructure" name="salary_structure" required>
                        <option disabled value="">Select Salary Structure</option>
                        @foreach(['hourly','daily','weekly','monthly','yearly','project'] as $opt)
                          <option
                            value="{{ $opt }}"
                            {{ old('salary_structure', $job->salary_structure ?? '') === $opt ? 'selected' : '' }}>
                            {{ $opt === 'project' ? 'Per Project' : ucfirst($opt) }}
                          </option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>

                {{-- Job Type & Experience --}}
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label for="jobType" class="form-label">Job Type</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="bi bi-journal-text"></i></span>
                      <select class="form-select" id="jobType" name="job_type" required>
                        <option disabled value="">Choose job type...</option>
                        @foreach(['full-time','part-time','contract','temporary','internship','freelance'] as $opt)
                          <option
                            value="{{ $opt }}"
                            {{ old('job_type', $job->job_type ?? '') === $opt ? 'selected' : '' }}>
                            {{ ucwords(str_replace('-', ' ', $opt)) }}
                          </option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="experienceLevel" class="form-label">Experience Level</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="bi bi-briefcase-fill"></i></span>
                      <select class="form-select" id="experienceLevel" name="experience_level" required>
                        <option disabled value="">Select Experience Level</option>
                        @foreach(['entry','mid','senior','manager','executive'] as $opt)
                          <option
                            value="{{ $opt }}"
                            {{ old('experience_level', $job->experience_level ?? '') === $opt ? 'selected' : '' }}>
                            {{ ucfirst($opt) }}
                          </option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>

                {{-- Education --}}
                <div class="mb-3">
                  <label for="education" class="form-label">Education</label>
                  <select class="form-select" id="education" name="education" required>
                    <option disabled value="">Select Education Level</option>
                    @foreach(['high_school','diploma','associate','bachelor','master','phd'] as $opt)
                      <option
                        value="{{ $opt }}"
                        {{ old('education', $job->education ?? '') === $opt ? 'selected' : '' }}>
                        {{ ucwords(str_replace('_', ' ', $opt)) }}
                      </option>
                    @endforeach
                  </select>
                </div>

                {{-- NEW: Job Status, Dates, Gender, Visa Sponsor --}}
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label for="status" class="form-label">Job Status</label>
                    <select class="form-select" id="status" name="status" required>
                      <option disabled value="">Select Status</option>
                      @foreach(['pending','active','closed'] as $opt)
                        <option
                          value="{{ $opt }}"
                          {{ old('status', $job->status ?? '') === $opt ? 'selected' : '' }}>
                          {{ ucfirst($opt) }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="application_start_date" class="form-label">Application Start Date</label>
                    <input
                      type="date"
                      class="form-control"
                      id="application_start_date"
                      name="application_start_date"
                      value="{{ old('application_start_date', optional($job)->application_start_date?->format('Y-m-d')) }}"
                      required>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="application_deadline" class="form-label">Application Deadline</label>
                    <input
                      type="date"
                      class="form-control"
                      id="application_deadline"
                      name="application_deadline"
                      value="{{ old('application_deadline', optional($job)->application_deadline?->format('Y-m-d')) }}"
                      required>
                  </div>

                  <div class="col-md-6 mb-3">
                    <label for="gender" class="form-label">Gender</label>
                    <select class="form-select" id="gender" name="gender" required>
                      <option disabled value="">Select Gender</option>
                      @foreach(['male','female','any','other'] as $opt)
                        <option
                          value="{{ $opt }}"
                          {{ old('gender', $job->gender ?? '') === $opt ? 'selected' : '' }}>
                          {{ ucfirst($opt) }}
                        </option>
                      @endforeach
                    </select>
                  </div>

                  <div class="col-md-6 mb-3">
                    <label for="visa_sponsor" class="form-label">Visa Sponsor?</label>
                    <select class="form-select" id="visa_sponsor" name="visa_sponsor" required>
                      <option disabled value="">Select Option</option>
                      <option value="1" {{ old('visa_sponsor', $job->visa_sponsor ?? '') == '1' ? 'selected' : '' }}>
                        Yes
                      </option>
                      <option value="0" {{ old('visa_sponsor', $job->visa_sponsor ?? '') == '0' ? 'selected' : '' }}>
                        No
                      </option>
                    </select>
                  </div>
                </div>

                {{-- Assign Agents --}}
                @php
                  $selectedAgents = old('agent_ids', $job->agent_ids ?? []);
                  if (is_string($selectedAgents)) {
                    $decoded = json_decode($selectedAgents, true);
                    $selectedAgents = is_array($decoded) ? $decoded : [];
                  }
                @endphp
                <div class="mb-3">
                  <label for="assignAgents" class="form-label">Assign Agents</label>
                  <select
                    class="form-select"
                    id="assignAgents"
                    name="agent_ids[]"
                    multiple
                    required>
                    @foreach($agents as $agent)
                      <option
                        value="{{ $agent->id }}"
                        {{ in_array($agent->id, $selectedAgents) ? 'selected' : '' }}>
                        {{ $agent->name }}
                      </option>
                    @endforeach
                  </select>
                  <small class="form-text text-warning">Hold Ctrl (Cmd on Mac) to select multiple.</small>
                </div>

                {{-- Submit & Reset --}}
                <div class="d-flex justify-content-between">
                  <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-check-circle me-1"></i>
                    {{ isset($job) ? 'Update' : 'Post Job' }}
                  </button>
                  <button type="reset" class="btn btn-outline-secondary px-4">
                    <i class="bi bi-arrow-clockwise me-1"></i> Reset
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
@endsection

@push('scripts')
<script>
  const skillsContainer = document.getElementById('skillsContainer');
  const skillsInput     = document.getElementById('requiredSkillsInput');

  function addSkill(event) {
    if (event.key !== 'Enter') return;
    const raw = skillsInput.value.trim();
    if (!raw) return event.preventDefault();

    const newSkill = raw.toLowerCase();
    const existing = Array.from(skillsContainer.querySelectorAll('input[name="required_skills[]"]'))
      .map(i => i.value.toLowerCase());

    if (existing.includes(newSkill)) {
      skillsInput.value = '';
      return event.preventDefault();
    }

    const tag = document.createElement('span');
    tag.classList.add('badge','bg-secondary','me-2','mb-2');
    tag.innerHTML = `
      ${raw}
      <span class="bi bi-x-circle ms-2" onclick="removeSkill(this)"></span>
      <input type="hidden" name="required_skills[]" value="${raw}">
    `;
    skillsContainer.appendChild(tag);
    skillsInput.value = '';
    event.preventDefault();
  }

  function removeSkill(el) {
    el.parentElement.remove();
  }
</script>
@endpush
