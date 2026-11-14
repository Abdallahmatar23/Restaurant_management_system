@extends('dashboard.layouts.master')

@section('title', 'Menu')
@section('page-title', 'Menu')

@section('content')
    @if ($sections->isEmpty())
        <div class="alert alert-info">No menu available yet.</div>
    @else
        {{-- Sections --}}
        <ul class="nav nav-pills mb-3" role="tablist">
            @foreach ($sections as $section)
                <li class="nav-item">
                    <button class="nav-link @if ($loop->first) active @endif" data-bs-toggle="pill"
                        data-bs-target="#section-{{ $section->id }}" type="button">{{ $section->name }}</button>
                </li>
            @endforeach
        </ul>

        <div class="tab-content">
            @foreach ($sections as $section)
                <div class="tab-pane fade @if ($loop->first) show active @endif"
                    id="section-{{ $section->id }}">

                    {{-- Categories --}}
                    <ul class="nav nav-tabs mb-3">
                        @foreach ($section->categories as $category)
                            <li class="nav-item">
                                <button class="nav-link @if ($loop->first) active @endif"
                                    data-bs-toggle="tab" data-bs-target="#cat-{{ $category->id }}"
                                    type="button">{{ $category->name }}</button>
                            </li>
                        @endforeach
                    </ul>

                    <div class="tab-content">
                        @foreach ($section->categories as $category)
                            <div class="tab-pane fade @if ($loop->first) show active @endif"
                                id="cat-{{ $category->id }}">

                                {{-- Subcategories --}}
                                <ul class="nav nav-underline mb-3">
                                    @foreach ($category->subcategories as $sub)
                                        <li class="nav-item">
                                            <button class="nav-link @if ($loop->first) active @endif"
                                                data-bs-toggle="tab" data-bs-target="#sub-{{ $sub->id }}"
                                                type="button">{{ $sub->name }}</button>
                                        </li>
                                    @endforeach
                                </ul>

                                <div class="tab-content">
                                    @foreach ($category->subcategories as $sub)
                                        <div class="tab-pane fade @if ($loop->first) show active @endif"
                                            id="sub-{{ $sub->id }}">
                                            <div class="row g-3">
                                                @forelse ($sub->items as $item)
                                                    <div class="col-sm-6 col-lg-4 col-xl-3">
                                                        <div
                                                            class="card h-100 {{ $item->availability === 'unavailable' ? 'opacity-50' : '' }}">
                                                            <img src="{{ asset($item->image) }}" class="card-img-top"
                                                                alt="{{ $item->name }}"
                                                                style="height:160px;object-fit:cover">
                                                            <div class="card-body">
                                                                <h5 class="card-title mb-1">{{ $item->name }}</h5>
                                                                <div class="fw-bold text-primary mb-2">
                                                                    {{ number_format($item->price, 2) }} EGP</div>
                                                                <p class="card-text small text-muted">
                                                                    {{ $item->description }}</p>
                                                            </div>
                                                            <div class="card-footer">
                                                                @if ($item->availability === 'unavailable')
                                                                    <span class="badge text-bg-danger">Out of stock</span>
                                                                @else
                                                                    <button class="btn btn-sm btn-primary w-100"
                                                                        disabled>Add to Order</button>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                @empty
                                                    <div class="col-12 text-muted">No items in this subcategory.</div>
                                                @endforelse
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
