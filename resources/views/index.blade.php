{{-- filepath: resources/views/index.blade.php --}}
@extends('layout.master')

@section('content')
@php
    // Dynamically resolve category IDs from shared view variable
    $hospitalId = $sidebarProjectTypes->firstWhere('title', 'Hospital')->id ?? 0;
    $residentialId = $sidebarProjectTypes->firstWhere('title', 'Residential')->id ?? 0;
    $commercialId = $sidebarProjectTypes->firstWhere('title', 'Commercial')->id ?? 0;
    $industrialId = $sidebarProjectTypes->firstWhere('title', 'Industrial')->id ?? 0;
@endphp

<!-- Page Title -->
<div class="d-flex flex-column gap-2 mb-3">
    <h2 class="display-font mb-0" style="font-weight: 800; letter-spacing: -0.03em;">Workspace Dashboard</h2>
    <p class="text-secondary mb-0">Overview of client inquiries, status feeds, and yearly performance metrics.</p>
</div>

<!-- Statistics Grid -->
<div class="stats-grid mb-4">
    <!-- Stat Box: Total -->
    <div class="glass-card stat-card">
        <div class="stat-info">
            <span class="stat-label">Total Inquiries</span>
            <span class="stat-value">{{ $totalInquiries ?? 0 }}</span>
        </div>
        <div class="stat-icon-wrapper" style="background-color: rgba(59, 130, 246, 0.1); color: #3b82f6;">
            <i class="bi bi-folder-fill"></i>
        </div>
    </div>
    
    <!-- Stat Box: Hospital -->
    <a href="{{ $hospitalId ? url('/inquiry-by-type/' . $hospitalId) : '#' }}" class="glass-card stat-card text-decoration-none">
        <div class="stat-info">
            <span class="stat-label">Hospital</span>
            <span class="stat-value">{{ $hospitalCount ?? 0 }}</span>
        </div>
        <div class="stat-icon-wrapper" style="background-color: rgba(239, 68, 68, 0.1); color: #ef4444;">
            <i class="bi bi-hospital"></i>
        </div>
    </a>

    <!-- Stat Box: Residential -->
    <a href="{{ $residentialId ? url('/inquiry-by-type/' . $residentialId) : '#' }}" class="glass-card stat-card text-decoration-none">
        <div class="stat-info">
            <span class="stat-label">Residential</span>
            <span class="stat-value">{{ $residentialCount ?? 0 }}</span>
        </div>
        <div class="stat-icon-wrapper" style="background-color: rgba(16, 185, 129, 0.1); color: #10b981;">
            <i class="bi bi-house-door"></i>
        </div>
    </a>

    <!-- Stat Box: Commercial -->
    <a href="{{ $commercialId ? url('/inquiry-by-type/' . $commercialId) : '#' }}" class="glass-card stat-card text-decoration-none">
        <div class="stat-info">
            <span class="stat-label">Commercial</span>
            <span class="stat-value">{{ $commercialCount ?? 0 }}</span>
        </div>
        <div class="stat-icon-wrapper" style="background-color: rgba(6, 182, 212, 0.1); color: #06b6d4;">
            <i class="bi bi-building"></i>
        </div>
    </a>

    <!-- Stat Box: Industrial -->
    <a href="{{ $industrialId ? url('/inquiry-by-type/' . $industrialId) : '#' }}" class="glass-card stat-card text-decoration-none">
        <div class="stat-info">
            <span class="stat-label">Industrial</span>
            <span class="stat-value">{{ $industrialCount ?? 0 }}</span>
        </div>
        <div class="stat-icon-wrapper" style="background-color: rgba(245, 158, 11, 0.1); color: #f59e0b;">
            <i class="bi bi-gear-fill"></i>
        </div>
    </a>
</div>

<!-- Performance Chart Section -->
<div class="glass-card p-4 mb-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h5 class="mb-0" style="font-weight: 700;"><i class="bi bi-graph-up me-2 text-primary"></i>Inquiry Registration Performance ({{ now()->year }})</h5>
        <span class="badge bg-primary px-3 py-2 rounded-pill">Yearly Statistics</span>
    </div>
    <div id="dashboard-performance-chart" style="min-height: 250px; width: 100%;"></div>
</div>

<!-- Dashboard Dual Column section -->
<div class="row g-4">
    <!-- Latest Inquiries Section (col-lg-8) -->
    <div class="col-lg-8">
        <div class="glass-card h-100 p-4">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h5 class="mb-0" style="font-weight: 700;"><i class="bi bi-list-stars me-2 text-primary"></i>Latest Inquiries</h5>
                <a href="/inquiries" class="modern-btn btn-secondary-modern py-1 px-3" style="font-size: 0.85rem;">View All</a>
            </div>
            
            <!-- Desktop Layout: Structured Table -->
            <div class="table-wrapper desktop-table-view">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th style="width: 8%;">ID</th>
                            <th>Client Name</th>
                            <th>Project Category</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($latestInquiries as $inq)
                            @php
                                $badgeClass = 'badge-received';
                                switch($inq->status) {
                                    case 'Quotation Sent': $badgeClass = 'badge-quotation-sent'; break;
                                    case 'Quotation Required': $badgeClass = 'badge-quotation-required'; break;
                                    case 'Pending': $badgeClass = 'badge-pending'; break;
                                    case 'In Progress': $badgeClass = 'badge-in-progress'; break;
                                    case 'Completed': $badgeClass = 'badge-completed'; break;
                                    case 'Cancelled': $badgeClass = 'badge-cancelled'; break;
                                }
                            @endphp
                            <tr>
                                <td>
                                    <a href="{{ route('inquiry.view', $inq->id) }}" class="fw-bold text-decoration-none text-primary">
                                        #{{ str_pad($inq->id, 4, '0', STR_PAD_LEFT) }}
                                    </a>
                                </td>
                                <td><span class="fw-semibold">{{ $inq->name }}</span></td>
                                <td>{{ $inq->projectType->title ?? 'N/A' }}</td>
                                <td>
                                    <span class="modern-badge {{ $badgeClass }}">
                                        {{ $inq->status }}
                                    </span>
                                </td>
                                <td><i class="bi bi-calendar-event me-2 text-muted"></i>{{ \Carbon\Carbon::parse($inq->date)->format('d M, Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">No inquiries found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Mobile Layout: App style card list -->
            <div class="mobile-card-feed">
                @forelse($latestInquiries as $inq)
                    @php
                        $badgeClass = 'badge-received';
                        switch($inq->status) {
                            case 'Quotation Sent': $badgeClass = 'badge-quotation-sent'; break;
                            case 'Quotation Required': $badgeClass = 'badge-quotation-required'; break;
                            case 'Pending': $badgeClass = 'badge-pending'; break;
                            case 'In Progress': $badgeClass = 'badge-in-progress'; break;
                            case 'Completed': $badgeClass = 'badge-completed'; break;
                            case 'Cancelled': $badgeClass = 'badge-cancelled'; break;
                        }
                    @endphp
                    <a href="{{ route('inquiry.view', $inq->id) }}" class="mobile-data-card">
                        <div class="mobile-card-header">
                            <span class="mobile-card-title">{{ $inq->name }}</span>
                            <span class="modern-badge {{ $badgeClass }}" style="font-size: 0.7rem; padding: 4px 8px;">
                                {{ $inq->status }}
                            </span>
                        </div>
                        <div class="mobile-card-body">
                            <div><i class="bi bi-tag-fill me-1"></i> {{ $inq->projectType->title ?? 'N/A' }}</div>
                            <div><i class="bi bi-calendar-fill me-1"></i> {{ \Carbon\Carbon::parse($inq->date)->format('d M, Y') }}</div>
                        </div>
                        <div class="mobile-card-footer text-primary fw-semibold" style="font-size: 0.8rem;">
                            <span>ID: #{{ str_pad($inq->id, 4, '0', STR_PAD_LEFT) }}</span>
                            <span>Tap to View <i class="bi bi-chevron-right ms-1"></i></span>
                        </div>
                    </a>
                @empty
                    <div class="text-center py-4 text-muted">No inquiries found.</div>
                @endforelse
            </div>
        </div>
    </div>
    
    <!-- Status Breakdown Column (col-lg-4) -->
    <div class="col-lg-4">
        <div class="glass-card p-4 h-100">
            <h5 class="mb-4" style="font-weight: 700;"><i class="bi bi-pie-chart me-2 text-primary"></i>Inquiries by Status</h5>
            
            <div class="d-flex flex-column gap-3">
                @php
                    $statusStyles = [
                        'Received' => ['bg' => 'rgba(30,41,59,0.1)', 'color' => 'var(--text-secondary)', 'icon' => 'bi-inbox-fill'],
                        'Quotation Sent' => ['bg' => 'rgba(6,182,212,0.1)', 'color' => 'var(--info-color)', 'icon' => 'bi-send-fill'],
                        'Quotation Required' => ['bg' => 'rgba(239,68,68,0.1)', 'color' => 'var(--danger-color)', 'icon' => 'bi-file-earmark-text-fill'],
                        'Pending' => ['bg' => 'rgba(245,158,11,0.1)', 'color' => 'var(--warning-color)', 'icon' => 'bi-hourglass-split'],
                        'In Progress' => ['bg' => 'rgba(59,130,246,0.1)', 'color' => 'var(--accent-color)', 'icon' => 'bi-arrow-repeat'],
                        'Completed' => ['bg' => 'rgba(16,185,129,0.1)', 'color' => 'var(--success-color)', 'icon' => 'bi-check-circle-fill'],
                        'Cancelled' => ['bg' => 'rgba(239,68,68,0.15)', 'color' => 'var(--danger-color)', 'icon' => 'bi-x-circle-fill'],
                    ];
                @endphp

                @foreach($statusStyles as $status => $style)
                    @php
                        $count = $statusCounts[$status] ?? 0;
                    @endphp
                    <a href="{{ route('inquiries.byStatus', ['status' => $status]) }}" class="d-flex align-items-center justify-content-between p-3 rounded text-decoration-none" style="background-color: {{ $style['bg'] }}; border: 1px solid var(--border-color); transition: all 0.2s ease;" onmouseover="this.style.borderColor='var(--border-hover)'" onmouseout="this.style.borderColor='var(--border-color)'">
                        <div class="d-flex align-items-center gap-3">
                            <span class="fs-5" style="color: {{ $style['color'] }}"><i class="bi {{ $style['icon'] }}"></i></span>
                            <span class="fw-semibold text-secondary" style="font-size: 0.95rem;">{{ $status }}</span>
                        </div>
                        <span class="badge rounded-pill fw-bold px-3 py-2" style="background-color: var(--bg-surface-solid); border: 1px solid var(--border-color); color: var(--text-primary); font-size: 0.85rem;">{{ $count }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Load ApexCharts -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.49.0/dist/apexcharts.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Retrieve database monthly counts mapped securely
        const rawMonthlyCounts = @json($monthlyCounts ?? []);
        const chartData = Array(12).fill(0);
        
        // Pluck counts to calendar months 1-12
        for (let m = 1; m <= 12; m++) {
            chartData[m-1] = rawMonthlyCounts[m] || 0;
        }
        
        const monthLabels = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        
        // Render Chart option styled to fit both Light and Dark mode variables
        const chartOptions = {
            chart: {
                height: 280,
                type: 'area',
                toolbar: { show: false },
                fontFamily: 'Inter, sans-serif',
                background: 'transparent'
            },
            series: [{
                name: 'Inquiries Received',
                data: chartData
            }],
            xaxis: {
                categories: monthLabels,
                labels: {
                    style: {
                        colors: 'var(--text-secondary)',
                        fontSize: '11px'
                    }
                },
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: {
                labels: {
                    style: {
                        colors: 'var(--text-secondary)',
                        fontSize: '11px'
                    }
                }
            },
            stroke: {
                curve: 'smooth',
                width: 3,
                colors: ['var(--accent-color)']
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.45,
                    opacityTo: 0.05,
                    stops: [0, 90, 100],
                    colorStops: [
                        {
                            offset: 0,
                            color: 'var(--accent-color)',
                            opacity: 0.4
                        },
                        {
                            offset: 100,
                            color: 'var(--accent-color)',
                            opacity: 0.01
                        }
                    ]
                }
            },
            dataLabels: { enabled: false },
            grid: {
                borderColor: 'var(--border-color)',
                strokeDashArray: 4,
                padding: { top: 0, right: 10, bottom: 0, left: 10 }
            },
            theme: {
                mode: document.documentElement.classList.contains('dark-theme') ? 'dark' : 'light'
            },
            markers: {
                size: 4,
                colors: ['var(--accent-color)'],
                strokeColors: 'var(--bg-surface-solid)',
                strokeWidth: 2,
                hover: { size: 6 }
            },
            tooltip: {
                theme: document.documentElement.classList.contains('dark-theme') ? 'dark' : 'light'
            }
        };

        const chart = new ApexCharts(document.querySelector("#dashboard-performance-chart"), chartOptions);
        chart.render();
        
        // Listen to theme toggles to live update the chart styling
        const themeBtn = document.getElementById('theme-toggle-btn');
        if (themeBtn) {
            themeBtn.addEventListener('click', () => {
                const isDark = document.documentElement.classList.contains('dark-theme');
                chart.updateOptions({
                    theme: { mode: isDark ? 'dark' : 'light' },
                    tooltip: { theme: isDark ? 'dark' : 'light' }
                });
            });
        }
    });
</script>
@endpush
