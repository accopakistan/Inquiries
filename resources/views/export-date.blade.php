{{-- filepath: resources/views/export-date.blade.php --}}
@extends('layout.master')

@section('content')
<div class="d-flex flex-column gap-1 mb-4">
    <h2 class="display-font mb-0" style="font-weight: 800; letter-spacing: -0.03em;">Export Inquiries by Date</h2>
    <p class="text-secondary mb-0">Select a date range to download phone numbers in CSV format.</p>
</div>

<div class="row">
    <div class="col-lg-6 offset-lg-3">
        <div class="glass-card p-4">
            <form method="POST" action="{{ route('inquiries.exportDate') }}">
                @csrf
                
                <h5 class="mb-4 text-primary" style="font-weight: 700;"><i class="bi bi-calendar-range me-2"></i>Date Range Selection</h5>

                <div class="row">
                    <!-- Start Date -->
                    <div class="col-md-6">
                        <div class="form-group-custom">
                            <label for="start_date" class="form-label-custom">Start Date</label>
                            <input type="date" name="start_date" id="start_date" class="modern-input" required>
                        </div>
                    </div>

                    <!-- End Date -->
                    <div class="col-md-6">
                        <div class="form-group-custom">
                            <label for="end_date" class="form-label-custom">End Date</label>
                            <input type="date" name="end_date" id="end_date" class="modern-input" required>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-2 d-flex gap-2">
                    <button type="submit" class="modern-btn btn-primary-modern flex-grow-1 flex-md-grow-0">
                        <i class="bi bi-download"></i> Export CSV
                    </button>
                    <a href="/inquiries" class="modern-btn btn-secondary-modern">Back to Inquiries</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
