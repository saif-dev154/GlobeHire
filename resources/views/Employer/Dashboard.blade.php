@extends('employer.layouts.app')

@section('title', 'Dashboard')

@push('styles')
<style>
    .stat-card { transition: transform .18s; }
    .stat-card:hover { transform: translateY(-3px); }
    .icon-box { width: 40px; height: 40px; border-radius: 9px; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; }
    .trend-pill { font-size: 9.5px; font-weight: 700; padding: 2px 9px; border-radius: 20px; }
    .bar-track { height: 3px; background: #f1f5f9; border-radius: 2px; margin-top: 10px; }
    .bar-fill { height: 3px; border-radius: 2px; }
    .jl-logo { width: 34px; height: 34px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 800; flex-shrink: 0; }
    .status-pill { font-size: 9.5px; font-weight: 700; padding: 2px 9px; border-radius: 20px; white-space: nowrap; }
    .funnel-track { background: #f1f5f9; border-radius: 3px; height: 5px; }
    .funnel-fill { border-radius: 3px; height: 5px; }
    .cav { width: 28px; height: 28px; border-radius: 50%; font-size: 10px; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .qa-card { border: 1.5px dashed #c7d2fe; border-radius: 9px; padding: 14px 10px; text-align: center; cursor: pointer; text-decoration: none; display: block; color: inherit; transition: all .18s; }
    .qa-card:hover { border-color: #6366f1; background: #fafbff; }
</style>
@endpush

@section('content')
<div class="container-fluid px-4 py-4">

    {{-- Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
        <div>
            <h4 class="fw-bold mb-0" style="color:#0f172a">Good morning, {{ auth()->user()->name }} 👋</h4>
            <p class="mb-0 text-muted" style="font-size:12px">{{ \Carbon\Carbon::now()->format('l, d F Y') }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('employer.jobs.create') }}" class="btn btn-sm fw-semibold" style="background:#6366f1;color:#fff;border-radius:8px;font-size:12px">
                <i class="bi bi-plus-lg"></i> Post a Job
            </a>
            <button class="btn btn-sm border fw-semibold" style="border-radius:8px;font-size:12px;color:#6366f1;border-color:#c7d2fe;background:#eef2ff">
                <i class="bi bi-download"></i> Export
            </button>
        </div>
    </div>

    {{-- Stat Cards --}}
    <div class="row g-3 mb-4">
        @php
            $stats = [
                ['label'=>'Job listings',          'value'=>$totalJobs,         'icon'=>'bi-briefcase-fill',           'color'=>'#6366f1','bg'=>'#eef2ff','bar'=>100,'trend'=>$totalJobs.' active'],
                ['label'=>'Passed interviews',      'value'=>$passedInterviews,  'icon'=>'bi-check-circle-fill',        'color'=>'#16a34a','bg'=>'#f0fdf4','bar'=>70, 'trend'=>'Interview passed'],
                ['label'=>'Shortlisted candidates', 'value'=>$shortlistedCount,  'icon'=>'bi-star-fill',                'color'=>'#d97706','bg'=>'#fffbeb','bar'=>40, 'trend'=>'Shortlisted'],
                ['label'=>'Contracts created',      'value'=>$totalContracts,    'icon'=>'bi-file-earmark-text-fill',   'color'=>'#db2777','bg'=>'#fdf2f8','bar'=>30, 'trend'=>'Signed: '.$signedContracts],
            ];
        @endphp
        @foreach($stats as $s)
        <div class="col-6 col-md-3">
            <div class="stat-card bg-white border rounded-3 p-3" style="border-color:#e8eaf6!important">
                <div class="d-flex align-items-start justify-content-between mb-2">
                    <div class="icon-box" style="background:{{ $s['bg'] }};color:{{ $s['color'] }}">
                        <i class="bi {{ $s['icon'] }}"></i>
                    </div>
                    <span class="trend-pill" style="background:{{ $s['bg'] }};color:{{ $s['color'] }}">{{ $s['trend'] }}</span>
                </div>
                <div class="fw-bold" style="font-size:26px;color:#0f172a;line-height:1">{{ $s['value'] }}</div>
                <div style="font-size:10.5px;color:#94a3b8;margin-top:3px">{{ $s['label'] }}</div>
                <div class="bar-track"><div class="bar-fill" style="width:{{ $s['bar'] }}%;background:{{ $s['color'] }}"></div></div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Jobs + Funnel --}}
    <div class="row g-3 mb-3">

        {{-- Job Listings --}}
        <div class="col-lg-7">
            <div class="bg-white border rounded-3 p-3 h-100" style="border-color:#e8eaf6!important">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="fw-bold mb-0" style="color:#0f172a;font-size:13px">My job listings</h6>
                    <a href="{{ route('employer.jobs.index') }}" class="btn btn-sm" style="font-size:10.5px;color:#6366f1;background:#eef2ff;border:1px solid #c7d2fe;border-radius:6px">View all</a>
                </div>
                @forelse($jobs as $job)
                @php
                    $statusMap = [
                        'active'  => ['bg'=>'#f0fdf4','color'=>'#15803d','label'=>'Active'],
                        'pending' => ['bg'=>'#fffbeb','color'=>'#b45309','label'=>'Pending'],
                        'closed'  => ['bg'=>'#fef2f2','color'=>'#b91c1c','label'=>'Closed'],
                    ];
                    $sp = $statusMap[$job->status] ?? ['bg'=>'#f1f5f9','color'=>'#475569','label'=>ucfirst($job->status)];
                    $initials = strtoupper(substr($job->title, 0, 2));
                    $bgPalette = ['#eef2ff','#eff6ff','#fffbeb','#fef2f2','#f0fdf4','#fdf2f8'];
                    $fgPalette = ['#6366f1','#2563eb','#d97706','#dc2626','#16a34a','#db2777'];
                    $ci = abs(crc32($job->title)) % 6;
                @endphp
                <div class="d-flex align-items-center gap-2 py-2 border-bottom" style="border-color:#f8fafc!important">
                    <div class="jl-logo" style="background:{{ $bgPalette[$ci] }};color:{{ $fgPalette[$ci] }}">{{ $initials }}</div>
                    <div class="flex-grow-1 overflow-hidden">
                        <div class="fw-semibold text-truncate" style="font-size:12px;color:#0f172a">{{ $job->title }}</div>
                        <div style="font-size:10px;color:#94a3b8">
                            {{ $job->location }} · {{ ucfirst(str_replace('-',' ',$job->job_type)) }} · Deadline: {{ \Carbon\Carbon::parse($job->application_deadline)->format('d M') }}
                        </div>
                    </div>
                    <div class="text-end flex-shrink-0">
                        <span class="status-pill" style="background:{{ $sp['bg'] }};color:{{ $sp['color'] }}">{{ $sp['label'] }}</span>
                        <div style="font-size:10px;color:#94a3b8;margin-top:2px">{{ $job->applications_count ?? 0 }} applicants</div>
                    </div>
                </div>
                @empty
                <p class="text-center text-muted py-3" style="font-size:13px">No jobs posted yet.</p>
                @endforelse
            </div>
        </div>

        {{-- Hiring Funnel + Contract Breakdown --}}
        <div class="col-lg-5">
            <div class="bg-white border rounded-3 p-3 h-100" style="border-color:#e8eaf6!important">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="fw-bold mb-0" style="color:#0f172a;font-size:13px">Hiring funnel</h6>
                    <span style="font-size:9.5px;background:#f1f5f9;border:1px solid #e2e8f0;color:#64748b;padding:2px 8px;border-radius:6px">All jobs</span>
                </div>
                @php
                    $base = max($totalApplications, 1);
                    $funnel = [
                        ['label'=>'Applications received','val'=>$totalApplications,'color'=>'#6366f1'],
                        ['label'=>'Interviews passed',    'val'=>$passedInterviews, 'color'=>'#22c55e'],
                        ['label'=>'Shortlisted',          'val'=>$shortlistedCount, 'color'=>'#f59e0b'],
                        ['label'=>'Contracts created',    'val'=>$totalContracts,   'color'=>'#ec4899'],
                        ['label'=>'Contracts signed',     'val'=>$signedContracts,  'color'=>'#0ea5e9'],
                        ['label'=>'Contracts approved',   'val'=>$approvedContracts,'color'=>'#8b5cf6'],
                    ];
                @endphp
                <div class="d-flex flex-column gap-2 mb-3">
                    @foreach($funnel as $f)
                    <div>
                        <div class="d-flex justify-content-between mb-1" style="font-size:10.5px;color:#64748b">
                            <span>{{ $f['label'] }}</span>
                            <span class="fw-bold" style="color:#0f172a">{{ $f['val'] }}</span>
                        </div>
                        <div class="funnel-track">
                            <div class="funnel-fill" style="width:{{ $base ? round($f['val']/$base*100) : 0 }}%;background:{{ $f['color'] }}"></div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="border-top pt-3" style="border-color:#f8fafc!important">
                    <div class="mb-2" style="font-size:9px;color:#94a3b8;text-transform:uppercase;letter-spacing:.5px;font-weight:700">Contract breakdown</div>
                    @php
                        $contractBreakdown = [
                            ['label'=>'Created', 'val'=>$createdContracts, 'bg'=>'#eff6ff','color'=>'#1d4ed8'],
                            ['label'=>'Signed',  'val'=>$signedContracts,  'bg'=>'#fffbeb','color'=>'#b45309'],
                            ['label'=>'Approved','val'=>$approvedContracts,'bg'=>'#f0fdf4','color'=>'#15803d'],
                            ['label'=>'Rejected','val'=>$rejectedContracts,'bg'=>'#fef2f2','color'=>'#b91c1c'],
                        ];
                    @endphp
                    <div class="d-flex flex-column gap-1">
                        @foreach($contractBreakdown as $cb)
                        <div class="d-flex justify-content-between align-items-center" style="font-size:10.5px;color:#64748b">
                            <span>{{ $cb['label'] }}</span>
                            <span class="status-pill" style="background:{{ $cb['bg'] }};color:{{ $cb['color'] }}">{{ $cb['val'] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Bottom Row --}}
    <div class="row g-3">

        {{-- Shortlisted Candidates --}}
        <div class="col-lg-4">
            <div class="bg-white border rounded-3 p-3" style="border-color:#e8eaf6!important">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="fw-bold mb-0" style="color:#0f172a;font-size:13px">Shortlisted candidates</h6>
                    <a href="{{ route('employer.interviews.shortlisted') }}" class="btn btn-sm" style="font-size:10.5px;color:#6366f1;background:#eef2ff;border:1px solid #c7d2fe;border-radius:6px">View all</a>
                </div>
                @forelse($shortlistedInterviews as $iv)
                @php
                    $name = $iv->application->candidate->name ?? 'N/A';
                    $jobTitle = $iv->application->job->title ?? '';
                    $initials = collect(explode(' ',$name))->map(fn($w)=>strtoupper($w[0]))->take(2)->implode('');
                    $avPalette = [['#eef2ff','#6366f1'],['#f0fdf4','#16a34a'],['#fdf2f8','#db2777'],['#fffbeb','#d97706']];
                    $av = $avPalette[abs(crc32($name)) % 4];
                @endphp
                <div class="d-flex align-items-center gap-2 py-2 border-bottom" style="border-color:#f8fafc!important">
                    <div class="cav" style="background:{{ $av[0] }};color:{{ $av[1] }}">{{ $initials }}</div>
                    <div class="flex-grow-1 overflow-hidden">
                        <div class="fw-semibold text-truncate" style="font-size:11.5px;color:#0f172a">{{ $name }}</div>
                        <div class="text-truncate" style="font-size:10px;color:#94a3b8">{{ $jobTitle }}</div>
                    </div>
                    <span class="status-pill" style="background:#eef2ff;color:#4338ca;flex-shrink:0">Shortlisted</span>
                </div>
                @empty
                <p class="text-muted text-center py-3" style="font-size:13px">No shortlisted candidates yet.</p>
                @endforelse
            </div>
        </div>

        {{-- Recent Contracts --}}
        <div class="col-lg-4">
            <div class="bg-white border rounded-3 p-3" style="border-color:#e8eaf6!important">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="fw-bold mb-0" style="color:#0f172a;font-size:13px">Recent contracts</h6>
                    <a href="{{ route('employer.contracts.index') }}" class="btn btn-sm" style="font-size:10.5px;color:#6366f1;background:#eef2ff;border:1px solid #c7d2fe;border-radius:6px">View all</a>
                </div>
                @forelse($recentContracts as $contract)
                @php
                    $cname    = $contract->interview->application->candidate->name ?? 'N/A';
                    $crole    = $contract->interview->application->job->title ?? '';
                    $cstatus  = $contract->status;
                    $csMap    = ['created'=>['bg'=>'#eff6ff','color'=>'#1d4ed8'],'signed'=>['bg'=>'#fffbeb','color'=>'#b45309'],'approved'=>['bg'=>'#f0fdf4','color'=>'#15803d'],'rejected'=>['bg'=>'#fef2f2','color'=>'#b91c1c']];
                    $cs       = $csMap[$cstatus] ?? $csMap['created'];
                    $ci       = collect(explode(' ',$cname))->map(fn($w)=>strtoupper($w[0]))->take(2)->implode('');
                    $cav      = [['#eef2ff','#6366f1'],['#f0fdf4','#16a34a'],['#fdf2f8','#db2777'],['#fffbeb','#d97706']];
                    $ca       = $cav[abs(crc32($cname)) % 4];
                @endphp
                <div class="d-flex align-items-center gap-2 py-2 border-bottom" style="border-color:#f8fafc!important">
                    <div class="cav" style="background:{{ $ca[0] }};color:{{ $ca[1] }}">{{ $ci }}</div>
                    <div class="flex-grow-1 overflow-hidden">
                        <div class="fw-semibold text-truncate" style="font-size:11.5px;color:#0f172a">{{ $cname }}</div>
                        <div class="text-truncate" style="font-size:10px;color:#94a3b8">{{ Str::limit($crole, 24) }}</div>
                    </div>
                    <span class="status-pill" style="background:{{ $cs['bg'] }};color:{{ $cs['color'] }};flex-shrink:0">{{ ucfirst($cstatus) }}</span>
                </div>
                @empty
                <p class="text-muted text-center py-3" style="font-size:13px">No contracts yet.</p>
                @endforelse
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="col-lg-4">
            <div class="bg-white border rounded-3 p-3" style="border-color:#e8eaf6!important">
                <h6 class="fw-bold mb-3" style="color:#0f172a;font-size:13px">Quick actions</h6>
                <div class="row g-2">
                    @php
                        $actions = [
                            ['icon'=>'bi-plus-circle-fill','label'=>'Post job',    'sub'=>'New listing',    'route'=>'employer.jobs.create',             'color'=>'#6366f1'],
                            ['icon'=>'bi-check-circle-fill','label'=>'Passed',     'sub'=>'View interviews','route'=>'employer.interviews.passed',        'color'=>'#16a34a'],
                            ['icon'=>'bi-star-fill',        'label'=>'Shortlisted','sub'=>'Manage list',    'route'=>'employer.interviews.shortlisted',   'color'=>'#d97706'],
                            ['icon'=>'bi-file-earmark-text-fill','label'=>'Contracts','sub'=>'Review & approve','route'=>'employer.contracts.index',      'color'=>'#db2777'],
                        ];
                    @endphp
                    @foreach($actions as $a)
                    <div class="col-6">
                        <a href="{{ route($a['route']) }}" class="qa-card">
                            <div style="font-size:18px;color:{{ $a['color'] }};margin-bottom:5px"><i class="bi {{ $a['icon'] }}"></i></div>
                            <div class="fw-bold" style="font-size:11.5px;color:#0f172a">{{ $a['label'] }}</div>
                            <div style="font-size:9.5px;color:#94a3b8;margin-top:1px">{{ $a['sub'] }}</div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</div>
@endsection