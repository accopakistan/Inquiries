{{-- filepath: resources/views/prepare-quotation.blade.php --}}
{{-- Shown by Prepare Quotation when the inquiry's category has no quotation page of its own (Industrial, Interior, …). --}}
@extends('layout.master')

@section('content')
<div class="d-flex flex-column gap-1 mb-4">
    <h2 class="display-font mb-0" style="font-weight: 800; letter-spacing: -0.03em;">Prepare Quotation</h2>
    <p class="text-secondary mb-0">
        Inquiry #{{ str_pad($inquiry->id, 5, '0', STR_PAD_LEFT) }} — {{ $inquiry->name }} ·
        category <strong>{{ $inquiry->projectType->title ?? 'Uncategorized' }}</strong> has no quotation page of its own. Choose which one to use.
    </p>
</div>

<div class="row g-4">
    @foreach($pages as $key => $p)
        <div class="col-md-4">
            <a href="{{ route('inquiry.quotation', ['id' => $inquiry->id, 'page' => $key]) }}" class="glass-card p-4 d-block text-decoration-none h-100">
                <i class="bi {{ $p['icon'] }} text-primary" style="font-size: 2rem;"></i>
                <h5 class="mt-3 mb-1 text-primary" style="font-weight: 700;">{{ $p['label'] }}</h5>
                <span class="text-secondary" style="font-size: 0.9rem;">Opens the {{ strtolower($p['label']) }} quotation with this inquiry's client, location and plot details filled in.</span>
            </a>
        </div>
    @endforeach
</div>

<div class="mt-4">
    <a href="{{ route('inquiry.view', $inquiry->id) }}" class="modern-btn btn-secondary-modern text-decoration-none"><i class="bi bi-arrow-left"></i> Back to inquiry</a>
</div>
@endsection
