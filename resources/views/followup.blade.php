{{-- filepath: resources/views/followup.blade.php --}}
@extends('layout.master')

@section('content')
<div class="page-header-row" style="width: 100% !important; display: flex !important; justify-content: space-between !important; align-items: center !important;">
    <div class="d-flex flex-column gap-1">
        <h2 class="display-font mb-0" style="font-weight: 800; letter-spacing: -0.03em;">Activity Log History</h2>
        <p class="text-secondary mb-0">Follow-up timeline history for Client: <strong>{{ $inquiry->name }}</strong>.</p>
    </div>
    
    <div class="d-flex flex-wrap gap-2 page-header-actions">
        <a href="{{ route('followups.create', $inquiry->id) }}" class="modern-btn btn-primary-modern flex-grow-1 flex-md-grow-0">
            <i class="bi bi-plus-circle"></i> Add Follow-up Log
        </a>
        <a href="{{ route('inquiry.view', $inquiry->id) }}" class="modern-btn btn-secondary-modern flex-grow-1 flex-md-grow-0">
            <i class="bi bi-person-badge"></i> Back to Profile
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success border-0 shadow-sm p-3 mb-4 d-flex align-items-center justify-content-between" role="alert" style="background-color: rgba(16, 185, 129, 0.1); color: var(--success-color); border-radius: var(--border-radius-md);">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-check-circle-fill"></i>
            <span>{{ session('success') }}</span>
        </div>
        <button type="button" class="btn-close theme-aware-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="glass-card p-4">
            <h5 class="mb-4" style="font-weight: 700;"><i class="bi bi-clock-history me-2 text-primary"></i>Interaction Timeline Log</h5>

            @if(count($followups) > 0)
                <div class="modern-timeline">
                    @foreach($followups as $followup)
                        @php
                            $contactIcon = 'bi-chat-dots-fill';
                            $iconColor = 'var(--accent-color)';
                            switch(strtolower($followup->type_of_contact)) {
                                case 'phone': $contactIcon = 'bi-telephone-fill'; $iconColor = 'var(--info-color)'; break;
                                case 'email': $contactIcon = 'bi-envelope-fill'; $iconColor = 'var(--danger-color)'; break;
                                case 'whatsapp': $contactIcon = 'bi-whatsapp'; $iconColor = 'var(--success-color)'; break;
                            }
                        @endphp
                        <div class="position-relative">
                            <!-- Dot indicators -->
                            <div class="timeline-dot" style="background-color: {{ $iconColor }};"></div>
                            
                            <div class="timeline-card">
                                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-1 mb-2">
                                    <h6 class="mb-0 fw-bold" style="color: {{ $iconColor }}">
                                        <i class="bi {{ $contactIcon }} me-2"></i>
                                        {{ ucfirst($followup->type_of_contact) }}
                                    </h6>
                                    <div class="d-flex flex-column align-items-start align-items-sm-end text-muted" style="font-size: 0.8rem;">
                                        <span><i class="bi bi-calendar-event me-1"></i> Scheduled: {{ \Carbon\Carbon::parse($followup->followup_date)->format('M d, Y h:i A') }}</span>
                                        <span><i class="bi bi-plus-circle me-1"></i> Created: {{ $followup->created_at->format('M d, Y h:i A') }}</span>
                                    </div>
                                </div>
                                <p class="mb-0 text-secondary" style="font-size: 0.92rem;">{{ $followup->remarks ?? 'No remarks provided.' }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-chat-square-dots text-muted display-4 d-block mb-3"></i>
                    <p class="text-muted mb-0">No follow-ups recorded for this client yet.</p>
                    <a href="{{ route('followups.create', $inquiry->id) }}" class="modern-btn btn-primary-modern mt-3">
                        Record First Follow-up
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
