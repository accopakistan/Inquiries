{{-- filepath: resources/views/update-project-type.blade.php --}}
@extends('layout.master')

@section('content')
<div class="d-flex flex-column gap-1 mb-4">
    <h2 class="display-font mb-0" style="font-weight: 800; letter-spacing: -0.03em;">Update Project Category</h2>
    <p class="text-secondary mb-0">Modify title for project category #{{ $data->id }}.</p>
</div>

<div class="row">
    <div class="col-lg-6 offset-lg-3">
        <div class="glass-card p-4">
            <form method="POST" action="{{ url('/update-projects-type') }}">
                @csrf
                
                <h5 class="mb-4 text-primary" style="font-weight: 700;"><i class="bi bi-pencil-square me-2"></i>Category Particulars</h5>

                <div class="form-group-custom">
                    <label for="name" class="form-label-custom">Title of Project Category</label>
                    <input type="text" class="modern-input" id="name" name="title" value="{{ $data->title }}" required>
                </div>

                <input type="hidden" name="id" value="{{ $data->id }}">

                <div class="mt-4 pt-2 d-flex gap-2">
                    <button type="submit" class="modern-btn btn-primary-modern flex-grow-1 flex-md-grow-0">
                        <i class="bi bi-check-circle"></i> Update Category
                    </button>
                    <a href="/project-type" class="modern-btn btn-danger-modern text-decoration-none">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
