{{-- filepath: resources/views/add-inquiry.blade.php --}}
@extends('layout.master')

@section('content')
<div class="d-flex flex-column gap-1 mb-4">
    <h2 class="display-font mb-0" style="font-weight: 800; letter-spacing: -0.03em;">Add New Inquiry</h2>
    <p class="text-secondary mb-0">Record a new client project inquiry in the database.</p>
</div>

<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="glass-card p-4">
            <form method="POST" action="{{ url('/add-inquiry') }}" enctype="multipart/form-data">
                @csrf
                
                <h5 class="mb-4 text-primary" style="font-weight: 700;"><i class="bi bi-person-fill-add me-2"></i>Inquiry Particulars</h5>

                <div class="row">
                    <!-- Client Name -->
                    <div class="col-md-6">
                        <div class="form-group-custom">
                            <label for="name" class="form-label-custom">Client Name</label>
                            <input type="text" class="modern-input" id="name" name="name" placeholder="John Doe" required>
                        </div>
                    </div>

                    <!-- Client Phone -->
                    <div class="col-md-6">
                        <div class="form-group-custom">
                            <label for="phone" class="form-label-custom">Phone Number</label>
                            <input type="tel" class="modern-input" id="phone" name="phone" placeholder="+923001234567" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Email Address -->
                    <div class="col-md-6">
                        <div class="form-group-custom">
                            <label for="email" class="form-label-custom">Email Address <span class="text-muted">(Optional)</span></label>
                            <input type="email" class="modern-input" id="email" name="email" placeholder="client@email.com">
                        </div>
                    </div>

                    <!-- Project Type -->
                    <div class="col-md-6">
                        <div class="form-group-custom">
                            <label for="project_type" class="form-label-custom">Project Category</label>
                            <select class="modern-select" id="project_type" name="project_type" required>
                                <option value="">Select Category</option>
                                @foreach ($projectType as $item)
                                    <option value="{{ $item->id }}">{{ $item->title }}</option>
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
                            <input type="text" class="modern-input" id="area_location" name="location" placeholder="e.g. Clifton, Karachi" required>
                        </div>
                    </div>

                    <!-- Date of Inquiry -->
                    <div class="col-md-6">
                        <div class="form-group-custom">
                            <label for="inquiry_date" class="form-label-custom">Date of Inquiry</label>
                            <input type="date" class="modern-input" id="inquiry_date" name="inquiry_date" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Status -->
                    <div class="col-md-6">
                        <div class="form-group-custom">
                            <label for="status" class="form-label-custom">Project Status</label>
                            <select class="modern-select" id="status" name="status" required>
                                <option value="">Select Status</option>
                                <option value="Received">Received</option>
                                <option value="Quotation Required">Quotation Required</option>
                                <option value="Quotation Sent">Quotation Sent</option>
                                <option value="Pending">Pending</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Completed">Completed</option>
                                <option value="Cancelled">Cancelled</option>
                            </select>
                        </div>
                    </div>

                    <!-- Source -->
                    <div class="col-md-6">
                        <div class="form-group-custom">
                            <label for="source" class="form-label-custom">Source of Inquiry</label>
                            <select name="source" id="source" class="modern-select">
                                <option value="">Select Source</option>
                                <option value="Facebook">Facebook</option>
                                <option value="Email">Email</option>
                                <option value="WhatsApp">WhatsApp</option>
                                <option value="Phone Call">Phone Call</option>
                                <option value="Website">Website</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Credibility -->
                <div class="form-group-custom">
                    <label for="credibility" class="form-label-custom">Credibility Score (0 - 100%)</label>
                    <input type="number" class="modern-input" id="credibility" name="credibility" min="0" max="100" value="50" required>
                    <small class="text-secondary" style="font-size:0.8rem;">Indicates the client conversion probability rating.</small>
                </div>

                <!-- Description -->
                <div class="form-group-custom">
                    <label for="project_detail" class="form-label-custom">Project Detail / Description</label>
                    <textarea class="modern-textarea" id="project_detail" name="project_detail" rows="4" placeholder="Enter specifications, scope, client demands..." required></textarea>
                </div>

                <!-- Response -->
                <div class="form-group-custom">
                    <label for="response" class="form-label-custom">Initial Response / Actions Taken</label>
                    <textarea class="modern-textarea" id="response" name="response" rows="3" placeholder="Contact summary, next meeting schedules, email draft details..."></textarea>
                </div>

                <hr style="border-color: var(--border-color); margin: 25px 0;">
                <h5 class="mb-4 text-primary" style="font-weight: 700;"><i class="bi bi-file-earmark-arrow-up me-2"></i>Attachment Files <span class="text-muted" style="font-size:0.8rem;">(MIME Type: PDF only)</span></h5>

                <div class="row">
                    <!-- Client Documents -->
                    <div class="col-md-6">
                        <div class="form-group-custom">
                            <label for="client_documents_file" class="form-label-custom">Client Specification Document</label>
                            <input type="file" class="modern-input" id="client_documents_file" name="client_documents" accept="application/pdf">
                        </div>
                    </div>

                    <!-- Quotation -->
                    <div class="col-md-6">
                        <div class="form-group-custom">
                            <label for="quotation_file" class="form-label-custom">Initial Quotation Proposal</label>
                            <input type="file" class="modern-input" id="quotation_file" name="quotation" accept="application/pdf">
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-2 d-flex gap-2">
                    <button type="submit" class="modern-btn btn-primary-modern flex-grow-1 flex-md-grow-0">
                        <i class="bi bi-check-circle"></i> Save Inquiry
                    </button>
                    <button type="reset" class="modern-btn btn-secondary-modern">Reset</button>
                    <a href="/inquiries" class="modern-btn btn-danger-modern text-decoration-none">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
