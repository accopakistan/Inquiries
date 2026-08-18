{{-- filepath: resources/views/most-important.blade.php --}}
@extends('layout.master')

@section('content')
<div class="page-header-row" style="width: 100% !important; display: flex !important; justify-content: space-between !important; align-items: center !important;">
    <div class="d-flex flex-column gap-1">
        <h2 class="display-font mb-0" style="font-weight: 800; letter-spacing: -0.03em;">Most Important Inquiries</h2>
        <p class="text-secondary mb-0">High-credibility inquiries (Score 80-100%) that are not yet marked as completed or in progress.</p>
    </div>
    
    <div class="d-flex flex-wrap gap-2 page-header-actions">
        <a href="{{ url('/add-inquiry') }}" class="modern-btn btn-primary-modern flex-grow-1 flex-md-grow-0">
            <i class="bi bi-plus-circle"></i> Add Inquiry
        </a>
    </div>
</div>

<!-- Desktop Layout: Table View -->
<div class="glass-card p-0 overflow-hidden desktop-table-view">
    <div class="table-wrapper">
        <table class="modern-table">
            <thead>
                <tr>
                    <th class="col-id">ID</th>
                    <th class="col-name">Name</th>
                    <th class="col-contact">Contact Info</th>
                    <th class="col-category">Category</th>
                    <th class="col-location">Location</th>
                    <th class="col-status">Status</th>
                    <th class="col-credibility">Credibility</th>
                    <th class="col-actions">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $item)
                    @php
                        $credibility = $item->credibility ?? 0;
                        $progressColor = 'bg-success'; // since it's 80-100%
                    @endphp
                    <tr class="row-status-{{ Str::slug($item->status) }}">
                        <td>
                            <a href="{{ route('inquiry.view', $item->id) }}" class="fw-bold text-decoration-none text-primary">
                                #{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}
                            </a>
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <span class="fw-bold text-primary">{{ $item->name }}</span>
                                <span class="text-muted" style="font-size:0.8rem;">{{ Str::limit($item->description, 35) }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex flex-column" style="font-size: 0.88rem;">
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $item->phone) }}" target="_blank" class="text-decoration-none text-secondary" title="Chat on WhatsApp">
                                    <i class="bi bi-whatsapp text-success me-1"></i> {{ $item->phone }}
                                </a>
                                @if($item->email)
                                    <span class="text-muted"><i class="bi bi-envelope me-1"></i> {{ $item->email }}</span>
                                @endif
                            </div>
                        </td>
                        <td><span class="fw-semibold text-secondary">{{ $item->projectType->title ?? '-' }}</span></td>
                        <td><span style="font-size: 0.88rem;"><i class="bi bi-geo-alt me-1 text-muted"></i>{{ $item->location }}</span></td>
                        <td><span class="modern-badge {{ $item->status_badge_class }}">{{ $item->status }}</span></td>
                        <td>
                            <div class="d-flex flex-column gap-1">
                                <span class="fw-bold text-success" style="font-size:0.85rem;">{{ $credibility }}% (High)</span>
                                <div class="progress" style="height: 8px; border-radius: 4px; background-color: var(--border-color);">
                                    <div class="progress-bar {{ $progressColor }}" role="progressbar" style="width: {{ $credibility }}%;" aria-valuenow="{{ $credibility }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex justify-content-center gap-1">
                                <a href="{{ route('inquiry.view', $item->id) }}" class="modern-btn btn-secondary-modern p-2" title="Profile View" style="padding: 6px 10px !important;">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ url('/update-inquiry-data', $item->id) }}" class="modern-btn btn-secondary-modern p-2 text-primary" title="Edit" style="padding: 6px 10px !important;">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a href="{{ url('/inquiries/' . $item->id . '/followups') }}" class="modern-btn btn-secondary-modern p-2 text-warning" title="Follow Ups" style="padding: 6px 10px !important;">
                                    <i class="bi bi-chat-dots"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">No high-credibility inquiries found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Mobile Layout: Card-based Interactive View -->
<div class="mobile-card-feed">
    @forelse($data as $item)
        @php
            $cred = $item->credibility ?? 0;
        @endphp
        <div class="mobile-data-card glass-card p-3">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <a href="{{ route('inquiry.view', $item->id) }}" class="text-decoration-none">
                    <h5 class="mobile-card-title text-primary" style="font-size: 1.15rem; font-weight:700;">{{ $item->name }}</h5>
                </a>
                <span class="modern-badge {{ $item->status_badge_class }}" style="font-size: 0.72rem; padding: 4px 10px;">
                    {{ $item->status }}
                </span>
            </div>
            
            <div class="mobile-card-body" style="font-size:0.9rem;">
                <div class="d-flex align-items-center gap-2 mb-1">
                    <i class="bi bi-telephone-fill text-muted"></i>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $item->phone) }}" target="_blank" class="text-decoration-none text-secondary fw-semibold">
                        {{ $item->phone }} <i class="bi bi-whatsapp text-success ms-1"></i>
                    </a>
                </div>
                
                @if($item->email)
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <i class="bi bi-envelope-fill text-muted"></i>
                        <span>{{ $item->email }}</span>
                    </div>
                @endif
                
                <div class="d-flex align-items-center gap-2 mb-1">
                    <i class="bi bi-tag-fill text-muted"></i>
                    <span class="fw-semibold">{{ $item->projectType->title ?? 'Uncategorized' }}</span>
                </div>
                
                <div class="d-flex align-items-center gap-2 mb-1">
                    <i class="bi bi-geo-alt-fill text-muted"></i>
                    <span>{{ $item->location }}</span>
                </div>

                <div class="d-flex align-items-center gap-2 mb-1">
                    <i class="bi bi-star-fill text-success"></i>
                    <span>Credibility Score: <strong class="text-success">{{ $cred }}%</strong></span>
                </div>
            </div>
            
            <div class="mobile-card-footer d-flex justify-content-between align-items-center" style="margin-top: 10px; padding-top: 12px; border-top: 1px solid var(--border-color);">
                <span class="text-muted fw-bold">ID: #{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</span>
                <div class="d-flex gap-2">
                    <a href="{{ route('inquiry.view', $item->id) }}" class="modern-btn btn-secondary-modern py-1 px-3" style="font-size: 0.8rem; padding: 6px 12px !important;">
                        <i class="bi bi-eye"></i> View
                    </a>
                    <a href="{{ url('/update-inquiry-data', $item->id) }}" class="modern-btn btn-primary-modern py-1 px-3" style="font-size: 0.8rem; padding: 6px 12px !important;">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-5 text-muted glass-card p-4">No high credibility inquiries found.</div>
    @endforelse
</div>

<!-- Pagination Footer -->
<div class="d-flex justify-content-center mt-4">
    {{ $data->links('pagination::bootstrap-5') }}
</div>
@endsection
