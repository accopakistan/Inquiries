{{-- filepath: resources/views/update-inquiry.blade.php --}}
@extends('layout.master')

@section('content')
<div class="d-flex flex-column gap-1 mb-4">
    <h2 class="display-font mb-0" style="font-weight: 800; letter-spacing: -0.03em;">Update Inquiry Details</h2>
    <p class="text-secondary mb-0">Modify information for inquiry #{{ str_pad($data->id, 5, '0', STR_PAD_LEFT) }}.</p>
</div>

<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="glass-card p-4">
            <form method="POST" action="{{ url('/update-inquiry-data') }}" enctype="multipart/form-data">
                @csrf
                
                <h5 class="mb-4 text-primary" style="font-weight: 700;"><i class="bi bi-pencil-square me-2"></i>Inquiry Particulars</h5>

                <div class="row">
                    <!-- Client Name -->
                    <div class="col-md-6">
                        <div class="form-group-custom">
                            <label for="name" class="form-label-custom">Client Name</label>
                            <input type="text" class="modern-input" id="name" name="name" value="{{ $data->name }}" required>
                        </div>
                    </div>

                    <!-- Client Phone -->
                    <div class="col-md-6">
                        <div class="form-group-custom">
                            <label for="phone" class="form-label-custom">Phone Number</label>
                            <input type="tel" class="modern-input" id="phone" name="phone" value="{{ $data->phone }}" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Email Address (Optional, consistent with add-inquiry form) -->
                    <div class="col-md-6">
                        <div class="form-group-custom">
                            <label for="email" class="form-label-custom">Email Address <span class="text-muted">(Optional)</span></label>
                            <input type="email" class="modern-input" id="email" name="email" value="{{ $data->email }}">
                        </div>
                    </div>

                    <!-- Project Type -->
                    <div class="col-md-6">
                        <div class="form-group-custom">
                            <label for="project_type" class="form-label-custom">Project Category</label>
                            <select class="modern-select" id="project_type" name="project_type" required>
                                @foreach ($projectType as $item)
                                    <option value="{{ $item->id }}" {{ $item->id == $data->project_type_id ? 'selected' : '' }}>
                                        {{ $item->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Area Location -->
                    <div class="col-md-6">
                        <div class="form-group-custom">
                            <label for="area_location" class="form-label-custom">Area / Location</label>
                            <input type="text" class="modern-input" id="area_location" name="location" value="{{ $data->location }}" required>
                        </div>
                    </div>

                    <!-- Date of Inquiry -->
                    <div class="col-md-6">
                        <div class="form-group-custom">
                            <label for="inquiry_date" class="form-label-custom">Date of Inquiry</label>
                            @php use Carbon\Carbon; @endphp
                            <input type="date" class="modern-input" id="inquiry_date" name="inquiry_date" value="{{ Carbon::parse($data->date)->format('Y-m-d') }}" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Status (Consolidated to resolve double options issue) -->
                    <div class="col-md-6">
                        <div class="form-group-custom">
                            <label for="status" class="form-label-custom">Project Status</label>
                            <select class="modern-select" id="status" name="status" required>
                                @foreach (\App\Models\Inquiry::STATUSES as $statusOption)
                                    <option value="{{ $statusOption }}" {{ $data->status == $statusOption ? 'selected' : '' }}>{{ $statusOption }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Source -->
                    <div class="col-md-6">
                        <div class="form-group-custom">
                            <label for="source" class="form-label-custom">Source of Inquiry</label>
                            <select class="modern-select" id="source" name="source" required>
                                <option value="">Select Source</option>
                                <option value="Facebook" {{ old('source', $data->source ?? '') == 'Facebook' ? 'selected' : '' }}>Facebook</option>
                                <option value="Email" {{ old('source', $data->source ?? '') == 'Email' ? 'selected' : '' }}>Email</option>
                                <option value="WhatsApp" {{ old('source', $data->source ?? '') == 'WhatsApp' ? 'selected' : '' }}>WhatsApp</option>
                                <option value="Phone Call" {{ old('source', $data->source ?? '') == 'Phone Call' ? 'selected' : '' }}>Phone Call</option>
                                <option value="Website" {{ old('source', $data->source ?? '') == 'Website' ? 'selected' : '' }}>Website</option>
                                <option value="Other" {{ old('source', $data->source ?? '') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Credibility -->
                <div class="form-group-custom">
                    <label for="credibility" class="form-label-custom">Credibility Score (0 - 100%)</label>
                    <input type="number" class="modern-input" id="credibility" name="credibility" min="0" max="100" value="{{ $data->credibility ?? 50 }}" required>
                    <small class="text-secondary" style="font-size:0.8rem;">Indicates the conversion probability rating.</small>
                </div>

                <!-- Description -->
                <div class="form-group-custom">
                    <label for="project_detail" class="form-label-custom">Project Detail / Description</label>
                    <textarea class="modern-textarea" id="project_detail" name="project_detail" rows="4" required>{{ $data->description }}</textarea>
                </div>

                <!-- Response -->
                <div class="form-group-custom">
                    <label for="response" class="form-label-custom">Response Log / Actions Taken</label>
                    <textarea class="modern-textarea" id="response" name="response" rows="3">{{ $data->response }}</textarea>
                </div>

                <hr style="border-color: var(--border-color); margin: 25px 0;">
                <h5 class="mb-4 text-primary" style="font-weight: 700;"><i class="bi bi-file-earmark-arrow-up me-2"></i>Attachment Files <span class="text-muted" style="font-size:0.8rem;">(MIME Type: PDF only)</span></h5>

                <div class="row">
                    <!-- Client Documents -->
                    <div class="col-md-6">
                        <div class="form-group-custom">
                            <label for="client_documents_file" class="form-label-custom">Client Specification Document</label>
                            <input type="file" class="modern-input" id="client_documents_file" name="client_documents" accept="application/pdf">
                            @if($data->document && $data->document !== 'nofile.pdf')
                                <div class="mt-2" style="font-size:0.85rem;">
                                    <a href="@modernAsset('documents/' . $data->document)" target="_blank" class="text-primary fw-semibold"><i class="bi bi-file-earmark-pdf me-1"></i> View Existing Document</a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Quotation -->
                    <div class="col-md-6">
                        <div class="form-group-custom">
                            <label for="quotation_file" class="form-label-custom">Initial Quotation Proposal</label>
                            <input type="file" class="modern-input" id="quotation_file" name="quotation" accept="application/pdf">
                            @if($data->quotation && $data->quotation !== 'nofile.pdf')
                                <div class="mt-2" style="font-size:0.85rem;">
                                    <a href="@modernAsset('quotations/' . $data->quotation)" target="_blank" class="text-primary fw-semibold"><i class="bi bi-file-earmark-pdf me-1"></i> View Existing Quotation</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <input type="hidden" name="id" value="{{ $data->id }}">

                <div class="mt-4 pt-2 d-flex gap-2">
                    <button type="submit" class="modern-btn btn-primary-modern flex-grow-1 flex-md-grow-0">
                        <i class="bi bi-check-circle"></i> Update Inquiry
                    </button>
                    <a href="{{ route('inquiry.view', $data->id) }}" class="modern-btn btn-secondary-modern">Back to Profile</a>
                    <a href="/inquiries" class="modern-btn btn-danger-modern text-decoration-none">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
