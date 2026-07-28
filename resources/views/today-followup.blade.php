{{-- filepath: resources/views/today-followup.blade.php --}}
@extends('layout.master')

@section('content')
<div class="page-header-row" style="width: 100% !important; display: flex !important; justify-content: space-between !important; align-items: center !important;">
    <div class="d-flex flex-column gap-1">
        <h2 class="display-font mb-0" style="font-weight: 800; letter-spacing: -0.03em;">Today's Follow-ups</h2>
        <p class="text-secondary mb-0">Follow-up actions scheduled for today ({{ \Carbon\Carbon::today()->format('d M, Y') }}).</p>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success border-0 shadow-sm p-3 mb-4 d-flex align-items-center justify-content-between" role="alert" style="background-color: rgba(16, 185, 129, 0.1); color: var(--success-color); border-radius: var(--border-radius-md);">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-check-circle-fill"></i>
            <span>{{ session('success') }}</span>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Desktop Layout: Table View -->
<div class="glass-card p-0 overflow-hidden desktop-table-view">
    <div class="table-wrapper">
        <table class="modern-table">
            <thead>
                <tr>
                    <th class="col-id">Inquiry ID</th>
                    <th class="col-name">Client Name</th>
                    <th class="col-category">Project Category</th>
                    <th class="col-status">Contact Method</th>
                    <th class="col-date">Scheduled Time</th>
                    <th>Remarks / Notes</th>
                </tr>
            </thead>
            <tbody>
                @forelse($followups as $followup)
                    @php
                        $contactIcon = 'bi-chat-dots-fill';
                        $iconColor = 'var(--accent-color)';
                        switch(strtolower($followup->type_of_contact)) {
                            case 'phone': $contactIcon = 'bi-telephone-fill'; $iconColor = 'var(--info-color)'; break;
                            case 'email': $contactIcon = 'bi-envelope-fill'; $iconColor = 'var(--danger-color)'; break;
                            case 'whatsapp': $contactIcon = 'bi-whatsapp'; $iconColor = 'var(--success-color)'; break;
                        }
                    @endphp
                    <tr>
                        <td>
                            @if($followup->inquiry)
                                <a href="{{ route('inquiry.view', $followup->inquiry->id) }}" class="fw-bold text-decoration-none text-primary">
                                    #{{ str_pad($followup->inquiry->id, 4, '0', STR_PAD_LEFT) }}
                                </a>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if($followup->inquiry)
                                <a href="{{ route('inquiry.view', $followup->inquiry->id) }}" class="fw-bold text-primary text-decoration-none">
                                    {{ $followup->inquiry->name }}
                                </a>
                            @else
                                <span class="text-muted">Deleted client</span>
                            @endif
                        </td>
                        <td>{{ $followup->inquiry->projectType->title ?? '-' }}</td>
                        <td>
                            <span class="fw-semibold" style="color: {{ $iconColor }}">
                                <i class="bi {{ $contactIcon }} me-2"></i>{{ ucfirst($followup->type_of_contact) }}
                            </span>
                        </td>
                        <td style="white-space: nowrap;"><i class="bi bi-clock me-2 text-muted"></i>{{ \Carbon\Carbon::parse($followup->followup_date)->format('h:i A') }}</td>
                        <td><span style="font-size:0.9rem;">{{ $followup->remarks ?? '-' }}</span></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">No follow-up calls or messages scheduled for today.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Mobile Layout: Card-based Checklist feed -->
<div class="mobile-card-feed">
    @forelse($followups as $followup)
        @php
            $contactIcon = 'bi-chat-dots-fill';
            $iconColor = 'var(--accent-color)';
            switch(strtolower($followup->type_of_contact)) {
                case 'phone': $contactIcon = 'bi-telephone-fill'; $iconColor = 'var(--info-color)'; break;
                case 'email': $contactIcon = 'bi-envelope-fill'; $iconColor = 'var(--danger-color)'; break;
                case 'whatsapp': $contactIcon = 'bi-whatsapp'; $iconColor = 'var(--success-color)'; break;
            }
        @endphp
        <div class="mobile-data-card glass-card p-3">
            <div class="d-flex justify-content-between align-items-center mb-2">
                @if($followup->inquiry)
                    <h5 class="mobile-card-title text-primary">{{ $followup->inquiry->name }}</h5>
                @else
                    <h5 class="mobile-card-title text-muted">Deleted client</h5>
                @endif
                <span class="fw-bold" style="font-size:0.75rem; color: {{ $iconColor }}">
                    <i class="bi {{ $contactIcon }} me-1"></i> {{ ucfirst($followup->type_of_contact) }}
                </span>
            </div>
            
            <div class="mobile-card-body" style="font-size:0.9rem;">
                @if($followup->inquiry)
                    <div class="mb-1"><i class="bi bi-tag-fill me-1 text-muted"></i> {{ $followup->inquiry->projectType->title ?? 'Uncategorized' }}</div>
                    <div class="mb-1">
                        <i class="bi bi-telephone-fill me-1 text-muted"></i> 
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $followup->inquiry->phone) }}" target="_blank" class="text-secondary fw-semibold">
                            {{ $followup->inquiry->phone }} <i class="bi bi-whatsapp text-success ms-1"></i>
                        </a>
                    </div>
                @endif
                <div class="mb-2"><i class="bi bi-clock-fill me-1 text-muted"></i> Scheduled Time: <strong>{{ \Carbon\Carbon::parse($followup->followup_date)->format('h:i A') }}</strong></div>
                <div class="p-2 rounded border" style="background-color: var(--bg-light); border-color: var(--border-color) !important; font-size:0.85rem;">
                    <strong>Remarks:</strong> {{ $followup->remarks ?? 'No remarks provided.' }}
                </div>
            </div>
            
            @if($followup->inquiry)
                <div class="mobile-card-footer d-flex justify-content-between align-items-center" style="margin-top: 10px; padding-top: 12px; border-top: 1px solid var(--border-color);">
                    <span class="text-muted fw-bold">ID: #{{ str_pad($followup->inquiry->id, 4, '0', STR_PAD_LEFT) }}</span>
                    <a href="{{ route('inquiry.view', $followup->inquiry->id) }}" class="modern-btn btn-secondary-modern py-1 px-3" style="font-size: 0.8rem; padding: 6px 12px !important;">
                        <i class="bi bi-eye"></i> View Profile
                    </a>
                </div>
            @endif
        </div>
    @empty
        <div class="text-center py-5 text-muted glass-card p-4">No follow-ups scheduled for today.</div>
    @endforelse
</div>
@endsection
