{{-- filepath: resources/views/export-status.blade.php --}}
@extends('layout.master')

@section('content')
<div class="d-flex flex-column gap-1 mb-4">
    <h2 class="display-font mb-0" style="font-weight: 800; letter-spacing: -0.03em;">Export Inquiries by Status</h2>
    <p class="text-secondary mb-0">Select an inquiry status category to download a styled Excel worksheet.</p>
</div>

<div class="row">
    <div class="col-lg-6 offset-lg-3">
        <div class="glass-card p-4">
            <form method="POST" action="{{ route('inquiries.exportStatus') }}">
                @csrf
                
                <h5 class="mb-4 text-primary" style="font-weight: 700;"><i class="bi bi-file-earmark-excel me-2"></i>Filter Status Selection</h5>

                <p class="text-secondary" style="font-size:0.9rem; line-height: 1.5; margin-bottom: 20px;">
                    The resulting file will contain columns formatted for printing: **ID, Client Name, Contact Number, Project Type, Date of Inquiry**, and a blank **Remarks** column for custom physical notation.
                </p>

                <div class="form-group-custom">
                    <label for="status" class="form-label-custom">Select Project Status</label>
                    <select name="status" id="status" class="modern-select" required>
                        <option value="">-- Choose Status --</option>
                        <option value="Received">Received</option>
                        <option value="Quotation Sent">Quotation Sent</option>
                        <option value="Quotation Required">Quotation Required</option>
                        <option value="Pending">Pending</option>
                        <option value="In Progress">In Progress</option>
                        <option value="Completed">Completed</option>
                        <option value="Cancelled">Cancelled</option>
                    </select>
                </div>

                <div class="mt-4 pt-2 d-flex gap-2">
                    <button type="submit" class="modern-btn btn-primary-modern flex-grow-1 flex-md-grow-0">
                        <i class="bi bi-download"></i> Export Excel
                    </button>
                    <a href="/inquiries" class="modern-btn btn-secondary-modern">Back to Inquiries</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
