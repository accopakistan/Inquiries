{{-- filepath: resources/views/add-followup.blade.php --}}
@extends('layout.master')

@section('content')
<div class="d-flex flex-column gap-1 mb-4">
    <h2 class="display-font mb-0" style="font-weight: 800; letter-spacing: -0.03em;">Add Follow-up Log</h2>
    <p class="text-secondary mb-0">Record a new interaction log for Client: <strong>{{ $inquiry->name }}</strong>.</p>
</div>

<div class="row">
    <div class="col-lg-6 offset-lg-3">
        <div class="glass-card p-4">
            <form action="{{ route('followups.store', $inquiry->id) }}" method="POST">
                @csrf
                
                <h5 class="mb-4 text-primary" style="font-weight: 700;"><i class="bi bi-chat-square-text-fill me-2"></i>Interaction Log Details</h5>

                <!-- Type of Contact -->
                <div class="form-group-custom">
                    <label for="type_of_contact" class="form-label-custom">Type of Contact / Method</label>
                    <select name="type_of_contact" id="type_of_contact" class="modern-select" required>
                        <option value="">Select Method</option>
                        <option value="phone">Phone Call</option>
                        <option value="email">Email</option>
                        <option value="whatsapp">WhatsApp</option>
                        <option value="other">Other / Face-to-Face</option>
                    </select>
                </div>

                <!-- Scheduled Date & Time -->
                <div class="form-group-custom">
                    <label for="followup_date" class="form-label-custom">Interaction Date & Time</label>
                    <input type="datetime-local" name="followup_date" id="followup_date" class="modern-input" value="{{ date('Y-m-d\TH:i') }}" required>
                </div>

                <!-- Remarks / Notes -->
                <div class="form-group-custom">
                    <label for="remarks" class="form-label-custom">Remarks / Discussion Summary</label>
                    <textarea name="remarks" id="remarks" class="modern-textarea" rows="4" placeholder="Enter key points of discussion, client requirements, next scheduled steps..." required></textarea>
                </div>

                <div class="mt-4 pt-2 d-flex gap-2">
                    <button type="submit" class="modern-btn btn-primary-modern flex-grow-1 flex-md-grow-0">
                        <i class="bi bi-check-circle"></i> Save Follow-up
                    </button>
                    <a href="{{ route('followup', $inquiry->id) }}" class="modern-btn btn-secondary-modern">Back to Log</a>
                    <a href="{{ route('inquiry.view', $inquiry->id) }}" class="modern-btn btn-danger-modern text-decoration-none">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
