{{-- filepath: resources/views/inquiry-by-status.blade.php --}}
@extends('layout.master')

@section('content')
<div class="page-header-row" style="width: 100% !important; display: flex !important; justify-content: space-between !important; align-items: center !important;">
    <div class="d-flex flex-column gap-1">
        <h2 class="display-font mb-0" style="font-weight: 800; letter-spacing: -0.03em;">Inquiries Status: {{ $selectedStatus ?? 'All' }}</h2>
        <p class="text-secondary mb-0">Showing list of inquiries filtered by progress status.</p>
    </div>
    
    <div class="d-flex flex-wrap gap-2 page-header-actions">
        <a href="{{ url('/add-inquiry') }}" class="modern-btn btn-primary-modern flex-grow-1 flex-md-grow-0">
            <i class="bi bi-plus-circle"></i> Add Inquiry
        </a>
        <a href="{{ url('/inquiries') }}" class="modern-btn btn-secondary-modern flex-grow-1 flex-md-grow-0">
            <i class="bi bi-arrow-left-circle"></i> View All
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
                    <th class="col-source">Source</th>
                    <th class="col-date">Date</th>
                    <th class="col-credibility">Credibility</th>
                    <th class="col-files">Files</th>
                    <th class="col-actions">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $item)
                    @php
                        $badgeClass = 'badge-received';
                        switch($item->status) {
                            case 'Quotation Sent': $badgeClass = 'badge-quotation-sent'; break;
                            case 'Quotation Required': $badgeClass = 'badge-quotation-required'; break;
                            case 'Pending': $badgeClass = 'badge-pending'; break;
                            case 'In Progress': $badgeClass = 'badge-in-progress'; break;
                            case 'Completed': $badgeClass = 'badge-completed'; break;
                            case 'Cancelled': $badgeClass = 'badge-cancelled'; break;
                        }

                        $credibility = $item->credibility ?? 0;
                        if ($credibility < 30) {
                            $progressColor = 'bg-danger';
                        } elseif ($credibility >= 80) {
                            $progressColor = 'bg-success';
                        } elseif ($credibility >= 50) {
                            $progressColor = 'bg-info';
                        } else {
                            $progressColor = 'bg-warning';
                        }
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
                        <td><span class="modern-badge {{ $badgeClass }}">{{ $item->status }}</span></td>
                        <td>
                            @switch($item->source)
                                @case('Facebook') <span class="text-primary"><i class="bi bi-facebook fs-5" title="Facebook"></i></span> @break
                                @case('Email') <span class="text-danger"><i class="bi bi-envelope-at-fill fs-5" title="Email"></i></span> @break
                                @case('WhatsApp') <span class="text-success"><i class="bi bi-whatsapp fs-5" title="WhatsApp"></i></span> @break
                                @case('Phone Call') <span class="text-info"><i class="bi bi-telephone-fill fs-5" title="Phone Call"></i></span> @break
                                @case('Website') <span class="text-secondary"><i class="bi bi-globe fs-5" title="Website"></i></span> @break
                                @default <span class="text-muted"><i class="bi bi-question-circle fs-5" title="Other"></i></span>
                            @endswitch
                        </td>
                        <td style="font-size: 0.88rem; white-space: nowrap;">{{ \Carbon\Carbon::parse($item->date)->format('d M, Y') }}</td>
                        <td>
                            <div class="d-flex flex-column gap-1">
                                <span class="fw-bold" style="font-size:0.8rem;">{{ $credibility }}%</span>
                                <div class="progress" style="height: 6px; border-radius: 3px; background-color: var(--border-color);">
                                    <div class="progress-bar {{ $progressColor }}" role="progressbar" style="width: {{ $credibility }}%;" aria-valuenow="{{ $credibility }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                @if ($item->document && $item->document !== 'nofile.pdf')
                                    <a href="@modernAsset('documents/' . $item->document)" target="_blank" class="text-secondary" title="Client Document"><i class="bi bi-file-earmark-text-fill fs-5"></i></a>
                                @endif
                                @if ($item->quotation && $item->quotation !== 'nofile.pdf')
                                    <a href="@modernAsset('quotations/' . $item->quotation)" target="_blank" class="text-primary" title="Quotation"><i class="bi bi-file-earmark-pdf-fill fs-5"></i></a>
                                @endif
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
                                <form action="{{ route('inquiries.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this inquiry?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="modern-btn btn-danger-modern p-2" title="Delete" style="padding: 6px 10px !important; border:none;">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="text-center py-5 text-muted">No inquiries found for this status.</td>
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
            $badgeClass = 'badge-received';
            switch($item->status) {
                case 'Quotation Sent': $badgeClass = 'badge-quotation-sent'; break;
                case 'Quotation Required': $badgeClass = 'badge-quotation-required'; break;
                case 'Pending': $badgeClass = 'badge-pending'; break;
                case 'In Progress': $badgeClass = 'badge-in-progress'; break;
                case 'Completed': $badgeClass = 'badge-completed'; break;
                case 'Cancelled': $badgeClass = 'badge-cancelled'; break;
            }
            $cred = $item->credibility ?? 0;
            $credColor = $cred >= 80 ? 'text-success' : ($cred >= 50 ? 'text-info' : 'text-warning');
        @endphp
        <div class="mobile-data-card glass-card p-3">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <a href="{{ route('inquiry.view', $item->id) }}" class="text-decoration-none">
                    <h5 class="mobile-card-title text-primary" style="font-size: 1.15rem; font-weight:700;">{{ $item->name }}</h5>
                </a>
                <span class="modern-badge {{ $badgeClass }}" style="font-size: 0.72rem; padding: 4px 10px;">
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
                    <i class="bi bi-star-fill text-muted"></i>
                    <span>Credibility: <strong class="{{ $credColor }}">{{ $cred }}%</strong></span>
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
        <div class="text-center py-5 text-muted glass-card p-4">No inquiries found for this status.</div>
    @endforelse
</div>

<!-- Pagination Footer -->
<div class="d-flex justify-content-center mt-4">
    {{ $data->links('pagination::bootstrap-5') }}
</div>
@endsection
