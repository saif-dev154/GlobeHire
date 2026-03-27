@extends('admin.layouts.app')

@section('title', 'Dashboard')

@push('styles')
<style>
    .stat-card { transition: transform .18s ease, box-shadow .18s ease; }
    .stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,0,0,.08); }
    .icon-box { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0; }
    .trend-badge { font-size: 11px; font-weight: 600; padding: 3px 8px; border-radius: 20px; }
    .activity-dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; margin-top: 5px; }
    .quick-action { border: 1.5px dashed #dee2e6; border-radius: 12px; padding: 20px; text-align: center; cursor: pointer; transition: all .2s; text-decoration: none; color: inherit; display: block; }
    .quick-action:hover { border-color: #6366f1; background: #f5f3ff; color: #6366f1; }
    .table-avatar { width: 34px; height: 34px; border-radius: 50%; font-size: 13px; font-weight: 600; display: flex; align-items: center; justify-content: center; }
    .sidebar-mini { width: 4px; height: 100%; border-radius: 2px; position: absolute; left: 0; top: 0; }
    .progress-sm { height: 6px; border-radius: 3px; }
    @media (max-width: 768px) { .stat-grid { grid-template-columns: 1fr 1fr !important; } }
    @media (max-width: 480px) { .stat-grid { grid-template-columns: 1fr !important; } }
</style>
@endpush

@section('content')
<div class="container-fluid px-4 py-4">

    {{-- ── Page Header ── --}}
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
        <div>
            <h4 class="fw-semibold mb-0" style="color:#1e1b4b">
                Overview
            </h4>
            <p class="text-muted mb-0" style="font-size:13px">
                {{ \Carbon\Carbon::now()->format('l, d F Y') }}
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-primary d-flex align-items-center gap-1" style="background:#6366f1;border-color:#6366f1;border-radius:8px">  {{-- admin.users.create ✓ --}}
                <i class="bi bi-plus-lg"></i> New User
            </a>
            <button class="btn btn-sm btn-light border d-flex align-items-center gap-1" style="border-radius:8px">
                <i class="bi bi-download"></i> Export
            </button>
        </div>
    </div>

    {{-- ── Stat Cards ── --}}
    <div class="stat-grid mb-4" style="display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:16px">

        @php
            $stats = [
                ['label'=>'Total Users','value'=>$totalUsers,'icon'=>'bi-people-fill','color'=>'#6366f1','bg'=>'#eef2ff','trend'=>'+12%','up'=>true],
                ['label'=>'Employers','value'=>$totalEmployers,'icon'=>'bi-briefcase-fill','color'=>'#0ea5e9','bg'=>'#e0f2fe','trend'=>'+5%','up'=>true],
                ['label'=>'Agents','value'=>$totalAgents,'icon'=>'bi-person-badge-fill','color'=>'#f59e0b','bg'=>'#fef3c7','trend'=>'+8%','up'=>true],
                ['label'=>'Candidates','value'=>$totalCandidates,'icon'=>'bi-person-lines-fill','color'=>'#10b981','bg'=>'#d1fae5','trend'=>'-2%','up'=>false],
            ];
        @endphp

        @foreach($stats as $s)
        <div class="stat-card bg-white border rounded-3 p-3 position-relative overflow-hidden">
            <div style="position:absolute;top:0;right:0;width:80px;height:80px;border-radius:50%;background:{{ $s['bg'] }};opacity:.5;transform:translate(20px,-20px)"></div>
            <div class="d-flex align-items-start justify-content-between mb-3">
                <div class="icon-box" style="background:{{ $s['bg'] }};color:{{ $s['color'] }}">
                    <i class="bi {{ $s['icon'] }}"></i>
                </div>
                <span class="trend-badge {{ $s['up'] ? 'text-success bg-success' : 'text-danger bg-danger' }} bg-opacity-10">
                    <i class="bi bi-arrow-{{ $s['up'] ? 'up' : 'down' }}-right"></i>
                    {{ $s['trend'] }}
                </span>
            </div>
            <div class="fw-bold mb-0" style="font-size:26px;color:#1e1b4b">{{ number_format($s['value']) }}</div>
            <div class="text-muted" style="font-size:12px;margin-top:2px">{{ $s['label'] }}</div>
        </div>
        @endforeach
    </div>

    <div class="row g-4">

        {{-- ── Role Distribution Chart ── --}}
        <div class="col-lg-5">
            <div class="bg-white border rounded-3 p-4 h-100">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="fw-semibold mb-0" style="color:#1e1b4b">User distribution</h6>
                    <span class="badge bg-light text-muted border" style="font-size:11px">All time</span>
                </div>
                <canvas id="donutChart" height="200"></canvas>
                <div class="mt-3 d-flex flex-column gap-2">
                    @php
                        $total = $totalUsers ?: 1;
                        $dist = [
                            ['label'=>'Candidates','val'=>$totalCandidates,'color'=>'#10b981'],
                            ['label'=>'Employers','val'=>$totalEmployers,'color'=>'#0ea5e9'],
                            ['label'=>'Agents','val'=>$totalAgents,'color'=>'#f59e0b'],
                        ];
                    @endphp
                    @foreach($dist as $d)
                    <div>
                        <div class="d-flex justify-content-between mb-1" style="font-size:12px">
                            <span class="d-flex align-items-center gap-2">
                                <span style="width:8px;height:8px;border-radius:50%;background:{{ $d['color'] }};display:inline-block"></span>
                                {{ $d['label'] }}
                            </span>
                            <span class="fw-semibold">{{ $d['val'] }}</span>
                        </div>
                        <div class="progress progress-sm bg-light">
                            <div class="progress-bar" style="width:{{ $total ? round($d['val']/$total*100) : 0 }}%;background:{{ $d['color'] }}"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ── Recent Users ── --}}
        <div class="col-lg-7">
            <div class="bg-white border rounded-3 p-4 h-100">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="fw-semibold mb-0" style="color:#1e1b4b">Recent users</h6>
                                            <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-light border" style="font-size:12px;border-radius:8px">View all</a> {{-- admin.users.index ✓ --}}
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="font-size:13px">
                        <thead>
                            <tr style="color:#6b7280;font-size:11px;text-transform:uppercase;letter-spacing:.5px;border-bottom:1px solid #f3f4f6">
                                <th class="pb-2 ps-0 fw-semibold border-0">User</th>
                                <th class="pb-2 fw-semibold border-0">Role</th>
                                <th class="pb-2 fw-semibold border-0">Status</th>
                                <th class="pb-2 fw-semibold border-0">Joined</th>
                                <th class="pb-2 pe-0 fw-semibold border-0"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentUsers as $user)
                            @php
                                $roleColors = ['candidate'=>['bg'=>'#d1fae5','color'=>'#065f46'],'employer'=>['bg'=>'#e0f2fe','color'=>'#0c4a6e'],'agent'=>['bg'=>'#fef3c7','color'=>'#78350f']];
                                $rc = $roleColors[$user->role] ?? ['bg'=>'#f3f4f6','color'=>'#374151'];
                                $initials = collect(explode(' ', $user->name))->map(fn($w)=>strtoupper($w[0]))->take(2)->implode('');
                                $avatarColors = [['#eef2ff','#6366f1'],['#fce7f3','#db2777'],['#d1fae5','#059669'],['#fef3c7','#d97706']];
                                $ac = $avatarColors[crc32($user->email) % 4];
                            @endphp
                            <tr>
                                <td class="ps-0 border-0">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="table-avatar" style="background:{{ $ac[0] }};color:{{ $ac[1] }}">{{ $initials }}</div>
                                        <div>
                                            <div class="fw-semibold" style="color:#1e1b4b">{{ $user->name }}</div>
                                            <div class="text-muted" style="font-size:11px">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="border-0">
                                    <span style="background:{{ $rc['bg'] }};color:{{ $rc['color'] }};padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;text-transform:capitalize">
                                        {{ $user->role }}
                                    </span>
                                </td>
                                <td class="border-0">
                                    @if($user->status === 'active')
                                        <span class="d-flex align-items-center gap-1" style="color:#059669;font-size:12px">
                                            <span style="width:6px;height:6px;border-radius:50%;background:#10b981;display:inline-block"></span> Active
                                        </span>
                                    @else
                                        <span class="d-flex align-items-center gap-1" style="color:#dc2626;font-size:12px">
                                            <span style="width:6px;height:6px;border-radius:50%;background:#ef4444;display:inline-block"></span> Inactive
                                        </span>
                                    @endif
                                </td>
                                <td class="border-0 text-muted" style="font-size:12px">{{ $user->created_at->diffForHumans() }}</td>
                                <td class="pe-0 border-0">
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-light border px-2" style="border-radius:6px" title="Edit"> {{-- admin.users.edit ✓ --}}
                                            <i class="bi bi-pencil" style="font-size:12px"></i>
                                        </a>
                                        <form action="{{ route('admin.users.toggle-status', $user->id) }}" method="POST" class="d-inline"> {{-- admin.users.toggle-status ✓ --}}
                                            @csrf @method('PATCH')
                                            <button class="btn btn-sm btn-light border px-2" style="border-radius:6px" title="Toggle status">
                                                <i class="bi bi-toggle-{{ $user->status==='active'?'on text-success':'off text-muted' }}" style="font-size:12px"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center text-muted py-4 border-0">No users found</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    {{-- ── Quick Actions ── --}}
    <div class="row g-3 mt-1">
        <div class="col-12">
            <h6 class="fw-semibold mb-3" style="color:#1e1b4b">Quick actions</h6>
        </div>
        @php
                                    $actions = [
                ['icon'=>'bi-person-plus-fill','label'=>'Add user','sub'=>'Create a new account','route'=>'admin.users.create','color'=>'#6366f1'],
                ['icon'=>'bi-briefcase-fill','label'=>'Employers','sub'=>'View all employers','route'=>'admin.users.employers.index','color'=>'#0ea5e9'],
                ['icon'=>'bi-person-badge-fill','label'=>'Agents','sub'=>'Manage agents','route'=>'admin.users.agents.index','color'=>'#f59e0b'],
                ['icon'=>'bi-bar-chart-fill','label'=>'Reports','sub'=>'Analytics & exports','route'=>'admin.dashboard','color'=>'#10b981'],
            ];
        @endphp
        @foreach($actions as $a)
        <div class="col-6 col-md-3">
            <a href="{{ route($a['route']) }}" class="quick-action">
                <div style="font-size:22px;color:{{ $a['color'] }};margin-bottom:8px"><i class="bi {{ $a['icon'] }}"></i></div>
                <div class="fw-semibold" style="font-size:13px">{{ $a['label'] }}</div>
                <div class="text-muted" style="font-size:11px">{{ $a['sub'] }}</div>
            </a>
        </div>
        @endforeach
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>
<script>
const ctx = document.getElementById('donutChart');
if (ctx) {
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Candidates', 'Employers', 'Agents'],
            datasets: [{
                data: [{{ $totalCandidates }}, {{ $totalEmployers }}, {{ $totalAgents }}],
                backgroundColor: ['#10b981', '#0ea5e9', '#f59e0b'],
                borderWidth: 0,
                hoverOffset: 6,
            }]
        },
        options: {
            cutout: '70%',
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => ` ${ctx.label}: ${ctx.parsed.toLocaleString()}`
                    }
                }
            }
        }
    });
}
</script>
@endpush