@php
    $item = $item ?? new App\Models\MenuItem();
@endphp

@extends('dashboard.layouts.master')

@section('title', $item->exists ? 'Edit Item' : 'New Item')
@section('page-title', $item->exists ? 'Edit Item' : 'New Item')

@section('content')
    @php
        // $selectedSection = old('section_id', $item->subcategory?->category?->section_id);
        // $selectedCategory = old('category_id', $item->subcategory?->category_id);
        $selectedSub = old('subcategory_id', $item->subcategory_id);
        $selectedTags = old('tags', $item->tags ?? []);
    @endphp

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">

                <div class="card-header bg-body py-3">
                    <h5 class="fw-bold mb-0">
                        {{ $item->exists ? 'Edit Menu Item' : 'Create Menu Item' }}
                    </h5>
                    <small class="text-body-secondary">
                        {{ $item->exists ? 'Update the menu item information' : 'Add a new item to your restaurant menu' }}
                    </small>
                </div>

                <form method="POST" enctype="multipart/form-data"
                    action="{{ $item->exists ? route('menu-items.update', $item) : route('menu-items.store') }}">
                    @csrf
                    @if ($item->exists)
                        @method('PUT')
                    @endif

                    <div class="card-body p-4">

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Name</label>
                            <input type="text" name="name" maxlength="200" value="{{ old('name', $item->name) }}"
                                class="form-control @error('name') is-invalid @enderror" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Subcategory</label>
                                <select id="subcategory" name="subcategory_id"
                                    class="form-select @error('subcategory_id') is-invalid @enderror" required>
                                    <option value="">-- Select category first --</option>
                                    @foreach ($subcategories as $sub)
                                        <option value="{{ $sub->id }}" @selected($selectedSub == $sub->id)>
                                            {{ $sub->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('subcategory_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Description
                                <small class="text-body-secondary fw-normal">(max 500)</small>
                            </label>
                            <textarea name="description" rows="3" maxlength="500"
                                class="form-control @error('description') is-invalid @enderror">{{ old('description', $item->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">Price (EGP)</label>
                                <input type="number" step="0.01" min="0" name="price"
                                    value="{{ old('price', $item->price) }}"
                                    class="form-control @error('price') is-invalid @enderror" required>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">Preparation Time (min)</label>
                                <input type="number" min="0" name="preparation_time"
                                    value="{{ old('preparation_time', $item->preparation_time) }}"
                                    class="form-control @error('preparation_time') is-invalid @enderror">
                                @error('preparation_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">Availability</label>
                                <select name="availability" class="form-select">
                                    <option value="available" @selected(old('availability', $item->availability ?? 'available') === 'available')>Available</option>
                                    <option value="unavailable" @selected(old('availability', $item->availability) === 'unavailable')>Out of stock</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold d-block mb-2">Special Tags</label>

                            <div class="border rounded-3 p-3 bg-body-tertiary">
                                <div class="d-flex flex-wrap gap-3">
                                    @foreach ($tags as $tag)
                                        <label class="form-check d-flex align-items-center gap-2 mb-0">
                                            <input type="checkbox" name="tags[]" value="{{ $tag }}"
                                                class="form-check-input mt-0"
                                                @checked(in_array($tag, old('tags', $item->tags ?? [])))>

                                            <span class="text-body">{{ $tag }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Image
                                <small class="text-body-secondary fw-normal">
                                    (JPG/PNG, max 2MB, recommended 800x600)
                                </small>
                            </label>

                            @if ($item->exists)
                                <div class="mb-3">
                                    <img src="{{ asset($item->image) }}" alt=""
                                        style="height:100px; max-width: 180px; object-fit: cover;"
                                        class="rounded-3 border">
                                </div>
                            @endif

                            <input type="file" name="image" accept="image/png,image/jpeg"
                                class="form-control @error('image') is-invalid @enderror" @required(!$item->exists)>

                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    <div class="card-footer bg-body p-3 d-flex gap-2">
                        <button class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i>
                            Save
                        </button>

                        <a href="{{ route('menu-items.index') }}" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>

        const subSel = document.getElementById('subcategory');

        const preset = {
            sub: @json($selectedSub),
        };


        async function loadOptions(url, select, placeholder, selectedId = null) {
            select.disabled = true;
            select.innerHTML = '<option value="">Loading...</option>';

            try {
                const res = await fetch(url, {
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                if (!res.ok) {
                    throw new Error(`Request failed: ${res.status}`);
                }

                const data = await res.json();

                select.innerHTML = `<option value="">${placeholder}</option>`;

                data.forEach(row => {
                    const option = new Option(
                        row.name,
                        row.id,
                        false,
                        String(row.id) === String(selectedId)
                    );

                    select.add(option);
                });

            } catch (error) {
                console.error(error);
                select.innerHTML = '<option value="">Failed to load data</option>';

            } finally {
                select.disabled = false;
            }
        }


    </script>
@endpush
