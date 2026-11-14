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

    {{-- {{ $sec }} --}}
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card card-primary card-outline">
                <form method="POST" enctype="multipart/form-data"
                    action="{{ $item->exists ? route('menu-items.update', $item) : route('menu-items.store') }}">
                    @csrf
                    @if ($item->exists)
                        @method('PUT')
                    @endif

                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" maxlength="200" value="{{ old('name', $item->name) }}"
                                class="form-control @error('name') is-invalid @enderror" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            {{-- <div class="col-md-4 mb-3">
                                <label class="form-label">Section</label>
                                <select id="section" name="section_id"
                                    class="form-select @error('section_id') is-invalid @enderror" required>
                                    <option value="">-- Select --</option>
                                    @foreach ($sections as $s)
                                        <option value="{{ $s->id }}" @selected($selectedSection == $s->id)>{{ $s->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('section_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Category</label>
                                <select id="category" name="category_id"
                                    class="form-select @error('category_id') is-invalid @enderror" required>
                                    <option value="">-- Select section first --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @selected($selectedCategory == $category->id)>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div> --}}
                            <div class="mb-3">
                                <label class="form-label">Subcategory</label>
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

                        <div class="mb-3">
                            <label class="form-label">Description <small class="text-muted">(max 500)</small></label>
                            <textarea name="description" rows="3" maxlength="500"
                                class="form-control @error('description') is-invalid @enderror">{{ old('description', $item->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Price (EGP)</label>
                                <input type="number" step="0.01" min="0" name="price"
                                    value="{{ old('price', $item->price) }}"
                                    class="form-control @error('price') is-invalid @enderror" required>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Preparation Time (min)</label>
                                <input type="number" min="0" name="preparation_time"
                                    value="{{ old('preparation_time', $item->preparation_time) }}"
                                    class="form-control @error('preparation_time') is-invalid @enderror">
                                @error('preparation_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Availability</label>
                                <select name="availability" class="form-select">
                                    <option value="available" @selected(old('availability', $item->availability ?? 'available') === 'available')>Available</option>
                                    <option value="unavailable" @selected(old('availability', $item->availability) === 'unavailable')>Out of stock</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">

                            @foreach ($tags as $tag)
                                <label>
                                    <input type="checkbox" name="tags[]" value="{{ $tag }}"
                                        @checked(in_array($tag, old('tags', $item->tags ?? [])))>

                                    {{ $tag }}
                                </label>
                            @endforeach
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Image <small class="text-muted">(JPG/PNG, max 2MB, recommended
                                    800x600)</small></label>
                            @if ($item->exists)
                                <div class="mb-2"><img src="{{ asset($item->image) }}" alt="" style="height:80px"
                                        class="rounded"></div>
                            @endif
                            <input type="file" name="image" accept="image/png,image/jpeg"
                                class="form-control @error('image') is-invalid @enderror" @required(!$item->exists)>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    <div class="card-footer">
                        <button class="btn btn-primary">Save</button>
                        <a href="{{ route('menu-items.index') }}" class="btn btn-secondary">Cancel</a>
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
