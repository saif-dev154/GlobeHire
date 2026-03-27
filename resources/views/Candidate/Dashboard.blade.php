@extends('candidate.layouts.app')

@section('title', 'Dashboard')

@push('styles')
<style>
    .stat-card { transition: transform .18s; }
    .stat-card:hover { transform: translateY(-3px); }
    .icon-box { width: 40px; height: 40px; border-radius: 9px; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; }
    .trend-pill { font-size: 9.5px; font-weight: 700; padding: 2px 9px; border-radius: 20px; }
    .bar-track { height: 3px; background: #f1f5f9; border-radius: 2px; margin-top: 10px; }
    .bar-fill { height: 3px; border-radius: 2px; }
    .status-pill { font-size: 9.5px; font-weight: 700; padding: 2px 9px; border-radius: 20px; white-space: nowrap; }
    .cav { width: 30px; height: 30px; border-radius: 50%; font-size: 10px; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .qa-card { border: 1.5px dashed #bfdbfe; border-radius: 9px; padding: 14px 10px; text-align: center; cursor: pointer; text-decoration: none; color: inherit; display: block; transition: all .18s; }
    .qa-card:hover { border-color: #2563eb; background: #eff6ff; }
    .row-divider { border-bottom: 1px solid #f8fafc; }
    .row-divider:last-child { border-bottom: none; }
</style>
@endpush

@section('content')
<div class="container-fluid px-4 py-4">

    {{-- Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
        <div>
            <h4 class="fw-bold mb-0" style="color:#0f172a">Welcome back, {{ auth()->user()->name }} 👋</h4>
            <p class="mb-0 text-muted" style="font-size:12px">{{ \Carbon\Carbon::now()->format('l, d F Y') }}</p>
        </div>
        <a href="{{ route('candidate.jobs.index') }}" class="btn btn-sm fw-semibold" style="background:#2563eb;color:#fff;border-radius:8px;font-size:12px">
            <i class="bi bi-search"></i> Browse Jobs
        </a>
    </div>

    {{-- Stat Cards --}}
    <div class="row g-3 mb-4">
        @php
            $stats = [
                ['label'=>'Total applications', 'value'=>$totalApplications, 'icon'=>'bi-send-fill',               'color'=>'#2563eb','bg'=>'#eff6ff','bar'=>100,'trend'=>$totalApplications.' total'],
                ['label'=>'Pending review',      'value'=>$pendingCount,      'icon'=>'bi-hourglass-split',          'color'=>'#d97706','bg'=>'#fffbeb','bar'=>70, 'trend'=>'Awaiting response'],
                ['label'=>'Interviews',          'value'=>$interviewCount,    'icon'=>'bi-calendar2-check-fill',    'color'=>'#059669','bg'=>'#f0fdf4','bar'=>50, 'trend'=>$upcomingInterviewCount.' upcoming'],
                ['label'=>'Contracts',           'value'=>$contractCount,     'icon'=>'bi-file-earmark-text-fill',  'color'=>'#7c3aed','bg'=>'#eef2ff','bar'=>30, 'trend'=>$signedCount.' signed'],
            ];
        @endphp
        @foreach($stats as $s)
        <div class="col-6 col-md-3">
            <div class="stat-card bg-white border rounded-3 p-3" style="border-color:#e2e8f0!important">
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

    <div class="row g-3 mb-3">

        {{-- Recent Applications --}}
        <div class="col-lg-7">
            <div class="bg-white border rounded-3 p-3 h-100" style="border-color:#e2e8f0!important">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="fw-bold mb-0" style="color:#0f172a;font-size:13px">My applications</h6>
                    <a href="{{ route('candidate.applications.index') }}" class="btn btn-sm" style="font-size:10.5px;color:#2563eb;background:#eff6ff;border:1px solid #bfdbfe;border-radius:6px">View all</a>
                </div>
                @forelse($recentApplications as $app)
                @php
                    $statusMap = [
                        'pending'     => ['bg'=>'#fffbeb','color'=>'#b45309','label'=>'Pending'],
                        'approved'    => ['bg'=>'#eff6ff','color'=>'#1d4ed8','label'=>'Approved'],
                        'rejected'    => ['bg'=>'#fef2f2','color'=>'#b91c1c','label'=>'Rejected'],
                        'shortlisted' => ['bg'=>'#f0fdf4','color'=>'#15803d','label'=>'Shortlisted'],
                        'hired'       => ['bg'=>'#eef2ff','color'=>'#4338ca','label'=>'Hired'],
                    ];
                    $sp = $statusMap[$app->status] ?? ['bg'=>'#f1f5f9','color'=>'#475569','label'=>ucfirst($app->status)];
                    $initials = strtoupper(substr($app->job->title ?? 'JO', 0, 2));
                    $bgPalette = ['#eff6ff','#f0fdf4','#fffbeb','#fef2f2','#eef2ff','#fdf2f8'];
                    $fgPalette = ['#2563eb','#059669','#d97706','#dc2626','#7c3aed','#db2777'];
                    $ci = abs(crc32($app->job->title ?? '')) % 6;
                @endphp
                <div class="d-flex align-items-center gap-2 py-2 row-divider">
                    <div class="icon-box" style="background:{{ $bgPalette[$ci] }};color:{{ $fgPalette[$ci] }};border-radius:8px;width:34px;height:34px;font-size:12px;font-weight:800">{{ $initials }}</div>
                    <div class="flex-grow-1 overflow-hidden">
                        <div class="fw-semibold text-truncate" style="font-size:12px;color:#0f172a">{{ $app->job->title ?? 'N/A' }}</div>
                        <div style="font-size:10px;color:#94a3b8">{{ $app->job->location ?? '' }} · {{ $app->created_at->diffForHumans() }}</div>
                    </div>
                    <div class="d-flex align-items-center gap-2 flex-shrink-0">
                        <span class="status-pill" style="background:{{ $sp['bg'] }};color:{{ $sp['color'] }}">{{ $sp['label'] }}</span>
                        <a href="{{ route('candidate.applications.show', $app->id) }}" class="btn btn-sm border px-2 py-1" style="font-size:10px;border-radius:6px">View</a>
                    </div>
                </div>
                @empty
                <p class="text-center text-muted py-3" style="font-size:13px">No applications yet. <a href="{{ route('candidate.jobs.index') }}">Browse jobs</a></p>
                @endforelse
            </div>
        </div>

        {{-- Interviews --}}
        <div class="col-lg-5">
            <div class="bg-white border rounded-3 p-3 h-100" style="border-color:#e2e8f0!important">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="fw-bold mb-0" style="color:#0f172a;font-size:13px">My interviews</h6>
                    <a href="{{ route('candidate.interviews.index') }}" class="btn btn-sm" style="font-size:10.5px;color:#2563eb;background:#eff6ff;border:1px solid #bfdbfe;border-radius:6px">View all</a>
                </div>

                {{-- Summary counts --}}
                <div class="row g-2 mb-3">
                    @php
                        $ivStats = [
                            ['label'=>'Upcoming','val'=>$upcomingInterviewCount, 'color'=>'#2563eb','bg'=>'#eff6ff'],
                            ['label'=>'Past',    'val'=>$pastInterviewCount,     'color'=>'#64748b','bg'=>'#f1f5f9'],
                        ];
                    @endphp
                    @foreach($ivStats as $iv)
                    <div class="col-6">
                        <div class="rounded-3 p-2 text-center" style="background:{{ $iv['bg'] }}">
                            <div class="fw-bold" style="font-size:20px;color:{{ $iv['color'] }}">{{ $iv['val'] }}</div>
                            <div style="font-size:10px;color:{{ $iv['color'] }}">{{ $iv['label'] }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="border-top pt-3" style="border-color:#f8fafc!important">
                    <div class="mb-2" style="font-size:9px;color:#94a3b8;text-transform:uppercase;letter-spacing:.5px;font-weight:700">Upcoming interviews</div>
                    @forelse($upcomingInterviews as $iv)
                    <div class="d-flex align-items-center gap-2 py-2 row-divider">
                        <div style="background:#eff6ff;border-radius:7px;padding:5px 9px;text-align:center;min-width:40px;flex-shrink:0">
                            <div style="font-size:8px;color:#2563eb;font-weight:700;text-transform:uppercase">{{ $iv->interview_date->format('D') }}</div>
                            <div style="font-size:14px;font-weight:800;color:#0f172a;line-height:1.1">{{ $iv->interview_date->format('d') }}</div>
                        </div>
                        <div class="flex-grow-1 overflow-hidden">
                            <div class="fw-semibold text-truncate" style="font-size:11.5px;color:#0f172a">{{ $iv->application->job->title ?? 'N/A' }}</div>
                            <div style="font-size:10px;color:#94a3b8">
                                {{ \Carbon\Carbon::parse($iv->start_time)->format('g:i A') }} – {{ \Carbon\Carbon::parse($iv->end_time)->format('g:i A') }}
                            </div>
                        </div>
                        <a href="{{ route('candidate.interviews.show', $iv->id) }}" class="btn btn-sm border px-2 py-1 flex-shrink-0" style="font-size:10px;border-radius:6px">View</a>
                    </div>
                    @empty
                    <p class="text-muted" style="font-size:12px">No upcoming interviews.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- Bottom Row --}}
    <div class="row g-3">

        {{-- Contracts --}}
        <div class="col-lg-4">
            <div class="bg-white border rounded-3 p-3" style="border-color:#e2e8f0!important">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="fw-bold mb-0" style="color:#0f172a;font-size:13px">My contracts</h6>
                    <a href="{{ route('candidate.contracts.index') }}" class="btn btn-sm" style="font-size:10.5px;color:#2563eb;background:#eff6ff;border:1px solid #bfdbfe;border-radius:6px">View all</a>
                </div>
                @forelse($recentContracts as $contract)
                @php
                    $csMap = [
                        'created'  => ['bg'=>'#f1f5f9','color'=>'#475569'],
                        'signed'   => ['bg'=>'#fffbeb','color'=>'#b45309'],
                        'approved' => ['bg'=>'#f0fdf4','color'=>'#15803d'],
                        'rejected' => ['bg'=>'#fef2f2','color'=>'#b91c1c'],
                    ];
                    $cs = $csMap[$contract->status] ?? $csMap['created'];
                    $jobTitle = $contract->interview->application->job->title ?? 'N/A';
                    $initials = strtoupper(substr($jobTitle, 0, 2));
                    $bgP = ['#eff6ff','#f0fdf4','#eef2ff','#fffbeb'];
                    $fgP = ['#2563eb','#059669','#7c3aed','#d97706'];
                    $ci  = abs(crc32($jobTitle)) % 4;
                @endphp
                <div class="d-flex align-items-center gap-2 py-2 row-divider">
                    <div class="icon-box" style="background:{{ $bgP[$ci] }};color:{{ $fgP[$ci] }};border-radius:8px;width:34px;height:34px;font-size:12px;font-weight:800">{{ $initials }}</div>
                    <div class="flex-grow-1 overflow-hidden">
                        <div class="fw-semibold text-truncate" style="font-size:11.5px;color:#0f172a">{{ $jobTitle }}</div>
                        <div style="font-size:10px;color:#94a3b8">
                            Start: {{ $contract->start_date ? \Carbon\Carbon::parse($contract->start_date)->format('d M Y') : 'N/A' }}
                        </div>
                    </div>
                    <div class="d-flex flex-column align-items-end gap-1 flex-shrink-0">
                        <span class="status-pill" style="background:{{ $cs['bg'] }};color:{{ $cs['color'] }}">{{ ucfirst($contract->status) }}</span>
                        @if($contract->status === 'created')
                        <a href="{{ route('candidate.contracts.sign', $contract->id) }}" style="font-size:9.5px;color:#2563eb">Sign now →</a>
                        @endif
                    </div>
                </div>
                @empty
                <p class="text-center text-muted py-3" style="font-size:13px">No contracts yet.</p>
                @endforelse
            </div>
        </div>

        {{-- Visa Documents --}}
        <div class="col-lg-4">
            <div class="bg-white border rounded-3 p-3" style="border-color:#e2e8f0!important">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="fw-bold mb-0" style="color:#0f172a;font-size:13px">Visa documents</h6>
                    <a href="{{ route('candidate.visa.index') }}" class="btn btn-sm" style="font-size:10.5px;color:#2563eb;background:#eff6ff;border:1px solid #bfdbfe;border-radius:6px">View all</a>
                </div>
                @forelse($recentVisas as $visa)
                @php
                    $vsMap = [
                        'submitted' => ['bg'=>'#fffbeb','color'=>'#b45309'],
                        'inreview'  => ['bg'=>'#eff6ff','color'=>'#1d4ed8'],
                        'approved'  => ['bg'=>'#f0fdf4','color'=>'#15803d'],
                        'rejected'  => ['bg'=>'#fef2f2','color'=>'#b91c1c'],
                    ];
                    $vs = $vsMap[$visa->status] ?? ['bg'=>'#f1f5f9','color'=>'#475569'];
                @endphp
                <div class="d-flex align-items-center gap-2 py-2 row-divider">
                    <div class="icon-box" style="background:#eef2ff;color:#7c3aed;border-radius:8px;width:34px;height:34px;font-size:15px">
                        <i class="bi bi-file-earmark-person-fill"></i>
                    </div>
                    <div class="flex-grow-1 overflow-hidden">
                        <div class="fw-semibold" style="font-size:11.5px;color:#0f172a">Visa Application</div>
                        <div style="font-size:10px;color:#94a3b8">Updated {{ $visa->updated_at->diffForHumans() }}</div>
                    </div>
                    <div class="d-flex flex-column align-items-end gap-1 flex-shrink-0">
                        <span class="status-pill" style="background:{{ $vs['bg'] }};color:{{ $vs['color'] }}">{{ ucfirst($visa->status) }}</span>
                        @if($visa->status === 'rejected')
                        <a href="{{ route('candidate.visa.edit', $visa->id) }}" style="font-size:9.5px;color:#dc2626">Re-upload →</a>
                        @endif
                    </div>
                </div>
                @empty
                <p class="text-center text-muted py-3" style="font-size:13px">No visa documents uploaded yet.</p>
                @endforelse
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="col-lg-4">
            <div class="bg-white border rounded-3 p-3" style="border-color:#e2e8f0!important">
                <h6 class="fw-bold mb-3" style="color:#0f172a;font-size:13px">Quick actions</h6>
                <div class="row g-2">
                    @php
                        $actions = [
                            ['icon'=>'bi-search',                  'label'=>'Browse jobs',  'sub'=>'Find opportunities',  'route'=>'candidate.jobs.index',        'color'=>'#2563eb'],
                            ['icon'=>'bi-send-fill',               'label'=>'Applications', 'sub'=>'Track your status',   'route'=>'candidate.applications.index','color'=>'#059669'],
                            ['icon'=>'bi-calendar2-check-fill',    'label'=>'Interviews',   'sub'=>'View schedule',       'route'=>'candidate.interviews.index',  'color'=>'#d97706'],
                            ['icon'=>'bi-file-earmark-text-fill',  'label'=>'Contracts',    'sub'=>'Sign & view',         'route'=>'candidate.contracts.index',   'color'=>'#7c3aed'],
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