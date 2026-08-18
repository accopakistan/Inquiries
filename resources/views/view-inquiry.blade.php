{{-- filepath: resources/views/view-inquiry.blade.php --}}
@extends('layout.master')

@section('content')
<div class="page-header-row" style="width: 100% !important; display: flex !important; justify-content: space-between !important; align-items: center !important;">
    <div class="d-flex flex-column gap-1">
        <h2 class="display-font mb-0" style="font-weight: 800; letter-spacing: -0.03em;">Client Profile</h2>
        <p class="text-secondary mb-0">Detailed view of inquiry #{{ str_pad($inquiry->id, 5, '0', STR_PAD_LEFT) }}.</p>
    </div>
    
    <div class="d-flex flex-wrap gap-2 page-header-actions">
        <a href="{{ url('/update-inquiry-data', $inquiry->id) }}" class="modern-btn btn-primary-modern flex-grow-1 flex-md-grow-0" style="padding: 10px 18px !important;">
            <i class="bi bi-pencil-square"></i> Edit Profile
        </a>
        <a href="{{ url('/inquiries/' . $inquiry->id . '/followups') }}" class="modern-btn btn-success-modern flex-grow-1 flex-md-grow-0" style="padding: 10px 18px !important;">
            <i class="bi bi-chat-left-text"></i> Follow-up Log
        </a>
        <form action="{{ route('inquiries.destroy', $inquiry->id) }}" method="POST" class="d-inline flex-grow-1 flex-md-grow-0" onsubmit="return confirm('Are you sure you want to delete this inquiry?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="modern-btn btn-danger-modern w-100" style="padding: 10px 18px !important; border:none;">
                <i class="bi bi-trash"></i> Delete
            </button>
        </form>
    </div>
</div>

<div class="row g-4">
    <!-- Profile & Contact Card (Left Column) -->
    <div class="col-lg-4">
        <div class="glass-card p-4 text-center mb-4">
            <div class="mb-3 d-inline-flex align-items-center justify-content-center" style="width: 75px; height: 75px; border-radius: 50%; background-color: rgba(var(--accent-rgb), 0.1); color: var(--accent-color);">
                <i class="bi bi-person-bounding-box" style="font-size: 2.25rem;"></i>
            </div>
            <h4 class="mb-1 text-primary" style="font-weight: 700;">{{ $inquiry->name }}</h4>
            <span class="text-secondary d-block mb-3" style="font-size:0.9rem;">Client ID: #{{ str_pad($inquiry->id, 5, '0', STR_PAD_LEFT) }}</span>
            
            <div class="mb-4">
                <span class="modern-badge {{ $inquiry->status_badge_class }} px-3 py-2" style="font-size: 0.8rem;">
                    {{ $inquiry->status }}
                </span>
            </div>

            <hr style="border-color: var(--border-color); margin: 20px 0;">

            <div class="text-start">
                <div class="mb-3">
                    <span class="text-secondary d-block" style="font-size: 0.8rem; font-weight:600; text-transform:uppercase;">Phone Number</span>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $inquiry->phone) }}" target="_blank" class="text-primary fw-bold text-decoration-none d-flex align-items-center gap-2 mt-1">
                        <i class="bi bi-whatsapp text-success fs-5"></i>
                        <span>{{ $inquiry->phone }}</span>
                    </a>
                </div>
                
                <div class="mb-3">
                    <span class="text-secondary d-block" style="font-size: 0.8rem; font-weight:600; text-transform:uppercase;">Email Address</span>
                    <span class="text-primary fw-semibold mt-1 d-block"><i class="bi bi-envelope me-2 text-muted"></i>{{ $inquiry->email ?? '-' }}</span>
                </div>

                <div class="mb-3">
                    <span class="text-secondary d-block" style="font-size: 0.8rem; font-weight:600; text-transform:uppercase;">Project Category</span>
                    <span class="text-primary fw-semibold mt-1 d-block"><i class="bi bi-tag me-2 text-muted"></i>{{ $inquiry->projectType->title ?? 'Uncategorized' }}</span>
                </div>

                <div class="mb-3">
                    <span class="text-secondary d-block" style="font-size: 0.8rem; font-weight:600; text-transform:uppercase;">Location</span>
                    <span class="text-primary fw-semibold mt-1 d-block"><i class="bi bi-geo-alt me-2 text-muted"></i>{{ $inquiry->location }}</span>
                </div>

                <div class="mb-0">
                    <span class="text-secondary d-block" style="font-size: 0.8rem; font-weight:600; text-transform:uppercase;">Inquiry Date</span>
                    <span class="text-primary fw-semibold mt-1 d-block"><i class="bi bi-calendar me-2 text-muted"></i>{{ \Carbon\Carbon::parse($inquiry->date)->format('d M, Y') }}</span>
                </div>
            </div>
        </div>
        
        <!-- Files & Uploads Preview -->
        <div class="glass-card p-4">
            <h5 class="mb-3" style="font-weight: 700;"><i class="bi bi-paperclip me-2 text-primary"></i>Uploaded Documents</h5>
            
            <div class="d-flex flex-column gap-3">
                <!-- Quotation -->
                <div class="p-3 rounded border" style="background-color: var(--bg-light); border-color: var(--border-color) !important;">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <strong class="text-secondary" style="font-size:0.9rem;">Quotation:</strong>
                        @if($inquiry->quotation && $inquiry->quotation !== 'nofile.pdf')
                            <a href="@modernAsset('quotations/' . $inquiry->quotation)" target="_blank" class="modern-btn btn-secondary-modern py-1 px-3" style="font-size: 0.75rem; padding: 4px 10px !important;">
                                <i class="bi bi-box-arrow-up-right"></i> External Open
                            </a>
                        @else
                            <span class="badge bg-secondary p-1">None</span>
                        @endif
                    </div>
                    @if($inquiry->quotation && $inquiry->quotation !== 'nofile.pdf')
                        <div class="border rounded overflow-hidden mt-2" style="height: 250px; background-color: var(--bg-surface-solid);">
                            <iframe src="@modernAsset('quotations/' . $inquiry->quotation)" width="100%" height="100%" style="border:none;"></iframe>
                        </div>
                    @else
                        <p class="text-muted mb-0" style="font-size:0.85rem;">No quotation file uploaded for this inquiry.</p>
                    @endif
                </div>

                <!-- Client specifications -->
                <div class="p-3 rounded border" style="background-color: var(--bg-light); border-color: var(--border-color) !important;">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <strong class="text-secondary" style="font-size:0.9rem;">Client Document:</strong>
                        @if($inquiry->document && $inquiry->document !== 'nofile.pdf')
                            <a href="@modernAsset('documents/' . $inquiry->document)" target="_blank" class="modern-btn btn-secondary-modern py-1 px-3" style="font-size: 0.75rem; padding: 4px 10px !important;">
                                <i class="bi bi-box-arrow-up-right"></i> External Open
                            </a>
                        @else
                            <span class="badge bg-secondary p-1">None</span>
                        @endif
                    </div>
                    @if($inquiry->document && $inquiry->document !== 'nofile.pdf')
                        <div class="border rounded overflow-hidden mt-2" style="height: 250px; background-color: var(--bg-surface-solid);">
                            <iframe src="@modernAsset('documents/' . $inquiry->document)" width="100%" height="100%" style="border:none;"></iframe>
                        </div>
                    @else
                        <p class="text-muted mb-0" style="font-size:0.85rem;">No specification files uploaded by client.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Inquiry Details & Followup Feeds (Right Column) -->
    <div class="col-lg-8">
        <!-- Details Card -->
        <div class="glass-card p-4 mb-4">
            <h5 class="mb-3" style="font-weight: 700;"><i class="bi bi-info-circle-fill me-2 text-primary"></i>Inquiry Specifications</h5>
            
            <div class="mb-4">
                <span class="text-secondary d-block mb-2" style="font-size: 0.85rem; font-weight:600; text-transform:uppercase;">Project details & description</span>
                <div class="p-3 rounded" style="background-color: var(--bg-light); border: 1px solid var(--border-color); line-height: 1.6; font-size:0.95rem;">
                    {!! nl2br(e($inquiry->description ?? 'No project details provided.')) !!}
                </div>
            </div>

            <div class="mb-4">
                <span class="text-secondary d-block mb-2" style="font-size: 0.85rem; font-weight:600; text-transform:uppercase;">Response Log</span>
                <div class="p-3 rounded" style="background-color: var(--bg-light); border: 1px solid var(--border-color); line-height: 1.6; font-size:0.95rem;">
                    {!! nl2br(e($inquiry->response ?? 'No official response logged.')) !!}
                </div>
            </div>

            <div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-secondary" style="font-size: 0.85rem; font-weight:600; text-transform:uppercase;">Credibility Score</span>
                    <strong class="text-primary fs-5">{{ $inquiry->credibility ?? 0 }}%</strong>
                </div>
                @php
                    $cred = $inquiry->credibility ?? 0;
                    $progressColor = 'bg-warning';
                    if ($cred < 30) $progressColor = 'bg-danger';
                    elseif ($cred >= 80) $progressColor = 'bg-success';
                    elseif ($cred >= 50) $progressColor = 'bg-info';
                @endphp
                <div class="progress" style="height: 12px; border-radius: 6px; background-color: var(--border-color);">
                    <div class="progress-bar progress-bar-striped progress-bar-animated {{ $progressColor }}" role="progressbar" style="width: {{ $cred }}%;" aria-valuenow="{{ $cred }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>

        <!-- Recent Followups -->
        <div class="glass-card p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h5 class="mb-0" style="font-weight: 700;"><i class="bi bi-chat-square-text me-2 text-primary"></i>Recent Follow-up Activity</h5>
                <a href="{{ route('followups.create', $inquiry->id) }}" class="modern-btn btn-primary-modern py-1 px-3" style="font-size:0.8rem; padding: 6px 12px !important;">
                    <i class="bi bi-plus-circle"></i> Add Follow-up
                </a>
            </div>

            @if($inquiry->followups->count() > 0)
                <div class="modern-timeline">
                    @foreach($inquiry->followups as $followup)
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
                                    <small class="text-muted" style="font-size: 0.8rem;">
                                        <i class="bi bi-calendar-event me-1"></i>
                                        {{ \Carbon\Carbon::parse($followup->followup_date)->format('M d, Y h:i A') }}
                                    </small>
                                </div>
                                <p class="mb-0 text-secondary" style="font-size: 0.92rem;">{{ $followup->remarks ?? 'No comments recorded.' }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="text-center mt-4 pt-2">
                    <a href="{{ url('/inquiries/' . $inquiry->id . '/followups') }}" class="modern-btn btn-secondary-modern py-1 px-4" style="font-size: 0.85rem;">
                        View All Activity Log ({{ $inquiry->followups->count() }}) <i class="bi bi-arrow-right-circle ms-1"></i>
                    </a>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-chat-square-dots text-muted display-4 d-block mb-3"></i>
                    <p class="text-muted mb-0">No follow-ups recorded for this client yet.</p>
                    <a href="{{ route('followups.create', $inquiry->id) }}" class="modern-btn btn-primary-modern mt-3" style="font-size:0.85rem;">
                        Record First Follow-up
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection