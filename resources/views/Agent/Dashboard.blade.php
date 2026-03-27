@extends('agent.layouts.app')

@section('title', 'Dashboard')

@push('styles')
<style>
    .stat-card { transition: transform .18s; }
    .stat-card:hover { transform: translateY(-3px); }
    .icon-box { width: 40px; height: 40px; border-radius: 9px; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; }
    .trend-pill { font-size: 9.5px; font-weight: 700; padding: 2px 9px; border-radius: 20px; }
    .bar-track { height: 3px; background: #f1f5f9; border-radius: 2px; margin-top: 10px; }
    .bar-fill  { height: 3px; border-radius: 2px; }
    .status-pill { font-size: 9.5px; font-weight: 700; padding: 2px 9px; border-radius: 20px; white-space: nowrap; }
    .cav { width: 30px; height: 30px; border-radius: 50%; font-size: 10px; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .qa-card { border: 1.5px dashed #bbf7d0; border-radius: 9px; padding: 14px 10px; text-align: center; cursor: pointer; text-decoration: none; color: inherit; display: block; transition: all .18s; }
    .qa-card:hover { border-color: #059669; background: #f0fdf4; }
    .row-divider { border-bottom: 1px solid #f8fafc; }
    .row-divider:last-child { border-bottom: none; }
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
            <a href="{{ route('agent.applications.index') }}" class="btn btn-sm fw-semibold" style="background:#059669;color:#fff;border-radius:8px;font-size:12px">
                <i class="bi bi-person-lines-fill"></i> My Applications
            </a>
        </div>
    </div>

    {{-- Stat Cards --}}
    <div class="row g-3 mb-4">
        @php
            $stats = [
                ['label'=>'Assigned applications', 'value'=>$totalAssigned,    'icon'=>'bi-person-lines-fill',      'color'=>'#059669','bg'=>'#f0fdf4','bar'=>100,'trend'=>$totalAssigned.' total'],
                ['label'=>'Pending review',         'value'=>$pendingCount,     'icon'=>'bi-hourglass-split',        'color'=>'#d97706','bg'=>'#fffbeb','bar'=>70, 'trend'=>'Awaiting action'],
                ['label'=>'Interviews scheduled',   'value'=>$upcomingCount,    'icon'=>'bi-calendar2-check-fill',  'color'=>'#2563eb','bg'=>'#eff6ff','bar'=>50, 'trend'=>'Upcoming'],
                ['label'=>'Visa docs in review',    'value'=>$visaInReview,     'icon'=>'bi-file-earmark-person-fill','color'=>'#7c3aed','bg'=>'#eef2ff','bar'=>35,'trend'=>'In progress'],
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

        {{-- Assigned Applications --}}
        <div class="col-lg-7">
            <div class="bg-white border rounded-3 p-3 h-100" style="border-color:#e2e8f0!important">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="fw-bold mb-0" style="color:#0f172a;font-size:13px">Assigned applications</h6>
                    <a href="{{ route('agent.applications.index') }}" class="btn btn-sm" style="font-size:10.5px;color:#059669;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:6px">View all</a>
                </div>
                @forelse($recentApplications as $app)
                @php
                    $statusMap = [
                        'pending'     => ['bg'=>'#fffbeb','color'=>'#b45309','label'=>'Pending'],
                        'approved'    => ['bg'=>'#eff6ff','color'=>'#1d4ed8','label'=>'Approved'],
                        'rejected'    => ['bg'=>'#fef2f2','color'=>'#b91c1c','label'=>'Rejected'],
                        'shortlisted' => ['bg'=>'#f0fdf4','color'=>'#15803d','label'=>'Shortlisted'],
                    ];
                    $sp = $statusMap[$app->status] ?? ['bg'=>'#f1f5f9','color'=>'#475569','label'=>ucfirst($app->status)];
                    $name = $app->candidate->name ?? 'N/A';
                    $initials = collect(explode(' ',$name))->map(fn($w)=>strtoupper($w[0]))->take(2)->implode('');
                    $avPalette = [['#f0fdf4','#059669'],['#eff6ff','#2563eb'],['#fdf2f8','#db2777'],['#fffbeb','#d97706']];
                    $av = $avPalette[abs(crc32($name)) % 4];
                @endphp
                <div class="d-flex align-items-center gap-2 py-2 row-divider">
                    <div class="cav" style="background:{{ $av[0] }};color:{{ $av[1] }}">{{ $initials }}</div>
                    <div class="flex-grow-1 overflow-hidden">
                        <div class="fw-semibold text-truncate" style="font-size:12px;color:#0f172a">{{ $name }}</div>
                        <div class="text-truncate" style="font-size:10px;color:#94a3b8">{{ $app->job->title ?? 'N/A' }} · {{ $app->created_at->diffForHumans() }}</div>
                    </div>
                    <div class="d-flex align-items-center gap-2 flex-shrink-0">
                        <span class="status-pill" style="background:{{ $sp['bg'] }};color:{{ $sp['color'] }}">{{ $sp['label'] }}</span>
                        <a href="{{ route('agent.applications.show', $app->id) }}" class="btn btn-sm border px-2 py-1" style="font-size:10px;border-radius:6px">View</a>
                    </div>
                </div>
                @empty
                <p class="text-center text-muted py-3" style="font-size:13px">No applications assigned yet.</p>
                @endforelse
            </div>
        </div>

        {{-- Interview Overview --}}
        <div class="col-lg-5">
            <div class="bg-white border rounded-3 p-3 h-100" style="border-color:#e2e8f0!important">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="fw-bold mb-0" style="color:#0f172a;font-size:13px">Interview overview</h6>
                    <a href="{{ route('agent.interviews.index') }}" class="btn btn-sm" style="font-size:10.5px;color:#059669;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:6px">View all</a>
                </div>
                @php
                    $ivStats = [
                        ['label'=>'Upcoming', 'val'=>$upcomingCount,  'color'=>'#2563eb','bg'=>'#eff6ff'],
                        ['label'=>'Pass',     'val'=>$passCount,      'color'=>'#15803d','bg'=>'#f0fdf4'],
                        ['label'=>'Fail',     'val'=>$failCount,      'color'=>'#b91c1c','bg'=>'#fef2f2'],
                        ['label'=>'Postponed','val'=>$postponedCount, 'color'=>'#b45309','bg'=>'#fffbeb'],
                    ];
                @endphp
                <div class="row g-2 mb-3">
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
                            <div style="font-size:8px;color:#2563eb;font-weight:700;text-transform:uppercase">{{ $iv['model']->interview_date->format('D') }}</div>
                            <div style="font-size:14px;font-weight:800;color:#0f172a;line-height:1.1">{{ $iv['model']->interview_date->format('d') }}</div>
                        </div>
                        <div class="flex-grow-1 overflow-hidden">
                            <div class="fw-semibold text-truncate" style="font-size:11.5px;color:#0f172a">{{ $iv['model']->application->candidate->name ?? 'N/A' }}</div>
                            <div class="text-truncate" style="font-size:10px;color:#94a3b8">{{ $iv['startFmt'] }} – {{ $iv['endFmt'] }}</div>
                        </div>
                        <span class="status-pill" style="background:#dbeafe;color:#1e40af;flex-shrink:0">{{ $iv['progress'] }}</span>
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

        {{-- Visa Documents --}}
        <div class="col-lg-4">
            <div class="bg-white border rounded-3 p-3" style="border-color:#e2e8f0!important">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="fw-bold mb-0" style="color:#0f172a;font-size:13px">Visa documents</h6>
                    <a href="{{ route('agent.visa.index') }}" class="btn btn-sm" style="font-size:10.5px;color:#059669;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:6px">View all</a>
                </div>
                @php
                    $visaStatusMap = [
                        'submitted' => ['bg'=>'#fffbeb','color'=>'#b45309'],
                        'inreview'  => ['bg'=>'#eff6ff','color'=>'#1d4ed8'],
                        'approved'  => ['bg'=>'#f0fdf4','color'=>'#15803d'],
                        'rejected'  => ['bg'=>'#fef2f2','color'=>'#b91c1c'],
                    ];
                @endphp
                @forelse($recentVisas as $visa)
                @php
                    $vname = $visa->contract->interview->application->candidate->name ?? 'N/A';
                    $vi = collect(explode(' ',$vname))->map(fn($w)=>strtoupper($w[0]))->take(2)->implode('');
                    $vp = $visaStatusMap[$visa->status] ?? ['bg'=>'#f1f5f9','color'=>'#475569'];
                    $vav = [['#f0fdf4','#059669'],['#eff6ff','#2563eb'],['#fdf2f8','#db2777'],['#fffbeb','#d97706']];
                    $va = $vav[abs(crc32($vname)) % 4];
                @endphp
                <div class="d-flex align-items-center gap-2 py-2 row-divider">
                    <div class="cav" style="background:{{ $va[0] }};color:{{ $va[1] }}">{{ $vi }}</div>
                    <div class="flex-grow-1 overflow-hidden">
                        <div class="fw-semibold text-truncate" style="font-size:11.5px;color:#0f172a">{{ $vname }}</div>
                        <div style="font-size:10px;color:#94a3b8">{{ $visa->updated_at->diffForHumans() }}</div>
                    </div>
                    <span class="status-pill" style="background:{{ $vp['bg'] }};color:{{ $vp['color'] }};flex-shrink:0">{{ ucfirst($visa->status) }}</span>
                </div>
                @empty
                <p class="text-muted text-center py-3" style="font-size:13px">No visa documents yet.</p>
                @endforelse
            </div>
        </div>

        {{-- Flight Schedules --}}
        <div class="col-lg-4">
            <div class="bg-white border rounded-3 p-3" style="border-color:#e2e8f0!important">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="fw-bold mb-0" style="color:#0f172a;font-size:13px">Flight schedules</h6>
                    <a href="{{ route('agent.visa.schedules') }}" class="btn btn-sm" style="font-size:10.5px;color:#059669;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:6px">View all</a>
                </div>
                @php
                    $flightStatusMap = [
                        'scheduled'       => ['bg'=>'#eff6ff','color'=>'#1d4ed8'],
                        'ticket_uploaded' => ['bg'=>'#f0fdf4','color'=>'#15803d'],
                        'checked_in'      => ['bg'=>'#f0fdf4','color'=>'#15803d'],
                        'boarding'        => ['bg'=>'#fffbeb','color'=>'#b45309'],
                        'in_flight'       => ['bg'=>'#eef2ff','color'=>'#4338ca'],
                        'completed'       => ['bg'=>'#f0fdf4','color'=>'#15803d'],
                        'cancelled'       => ['bg'=>'#fef2f2','color'=>'#b91c1c'],
                        'delayed'         => ['bg'=>'#fef2f2','color'=>'#b91c1c'],
                        'rescheduled'     => ['bg'=>'#fffbeb','color'=>'#b45309'],
                    ];
                @endphp
                @forelse($recentFlights as $flight)
                @php
                    $fname = $flight->visaDocument->contract->interview->application->candidate->name ?? 'N/A';
                    $fi = collect(explode(' ',$fname))->map(fn($w)=>strtoupper($w[0]))->take(2)->implode('');
                    $fp = $flightStatusMap[$flight->travel_status] ?? ['bg'=>'#f1f5f9','color'=>'#475569'];
                    $fav = [['#f0fdf4','#059669'],['#eff6ff','#2563eb'],['#fdf2f8','#db2777'],['#fffbeb','#d97706']];
                    $fa = $fav[abs(crc32($fname)) % 4];
                @endphp
                <div class="d-flex align-items-center gap-2 py-2 row-divider">
                    <div class="cav" style="background:{{ $fa[0] }};color:{{ $fa[1] }}">{{ $fi }}</div>
                    <div class="flex-grow-1 overflow-hidden">
                        <div class="fw-semibold text-truncate" style="font-size:11.5px;color:#0f172a">{{ $fname }}</div>
                        <div style="font-size:10px;color:#94a3b8">
                            {{ $flight->departure_airport }} → {{ $flight->arrival_airport }} · {{ \Carbon\Carbon::parse($flight->departure_datetime)->format('d M') }}
                        </div>
                    </div>
                    <span class="status-pill" style="background:{{ $fp['bg'] }};color:{{ $fp['color'] }};flex-shrink:0">{{ ucfirst(str_replace('_',' ',$flight->travel_status)) }}</span>
                </div>
                @empty
                <p class="text-muted text-center py-3" style="font-size:13px">No flights scheduled yet.</p>
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
                            ['icon'=>'bi-person-lines-fill',      'label'=>'Applications', 'sub'=>'View assigned',    'route'=>'agent.applications.index',  'color'=>'#059669'],
                            ['icon'=>'bi-calendar2-check-fill',   'label'=>'Interviews',   'sub'=>'Manage schedule',  'route'=>'agent.interviews.index',    'color'=>'#2563eb'],
                            ['icon'=>'bi-file-earmark-person-fill','label'=>'Visa Docs',   'sub'=>'Review documents', 'route'=>'agent.visa.index',          'color'=>'#7c3aed'],
                            ['icon'=>'bi-airplane-fill',          'label'=>'Flights',      'sub'=>'View schedules',   'route'=>'agent.visa.schedules',      'color'=>'#0891b2'],
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