@php
    $restaurantTable = $restaurantTable ?? new \App\Models\RestaurantTable();
    $isEdit = $restaurantTable->exists;
@endphp

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form
            action="{{ $isEdit ? route('restaurant-tables.update', $restaurantTable) : route('restaurant-tables.store') }}"
            method="POST">
            @csrf
            @if ($isEdit)
                @method('PUT')
            @endif

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="table_number" class="form-label">Table Number <span class="text-danger">*</span></label>
                    <input type="text" name="table_number" id="table_number"
                        class="form-control @error('table_number') is-invalid @enderror"
                        value="{{ old('table_number', $restaurantTable->table_number) }}"
                        placeholder="e.g. T01 or VIP-1" required>
                    @error('table_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label d-block">Table Type <span class="text-danger">*</span></label>
                    @foreach (['private' => 'Private', 'public' => 'Public'] as $value => $label)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="type" id="type_{{ $value }}"
                                value="{{ $value }}" @checked(old('type', $restaurantTable->type) === $value) required>
                            <label class="form-check-label" for="type_{{ $value }}">{{ $label }}</label>
                        </div>
                    @endforeach
                    @error('type')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="min_capacity" class="form-label">Minimum Capacity <span
                            class="text-danger">*</span></label>
                    <input type="number" min="1" name="min_capacity" id="min_capacity"
                        class="form-control @error('min_capacity') is-invalid @enderror"
                        value="{{ old('min_capacity', $restaurantTable->min_capacity) }}" required>
                    @error('min_capacity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="max_capacity" class="form-label">Maximum Capacity <span
                            class="text-danger">*</span></label>
                    <input type="number" min="1" name="max_capacity" id="max_capacity"
                        class="form-control @error('max_capacity') is-invalid @enderror"
                        value="{{ old('max_capacity', $restaurantTable->max_capacity) }}" required>
                    @error('max_capacity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="area" class="form-label">Area</label>
                    {{-- <input type="text" name="area" id="area"
                        class="form-control @error('area') is-invalid @enderror"
                        value="{{ old('area', $restaurantTable->area) }}" placeholder="e.g. Ground Floor, Garden"> --}}
                    <select name="area" id="area" class="form-select @error('area') is-invalid @enderror">
                        @foreach ($areas as $area)
                            <option value="{{ $area }}" @selected(old('area', Str::lower($restaurantTable->area) ?? 'ground floor') == $area)>
                                {{ ucfirst($area) }}
                            </option>
                        @endforeach
                    </select>
                    @error('area')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror"
                        required>
                        @foreach (['available' => 'Available', 'occupied' => 'Occupied', 'reserved' => 'Reserved', 'maintenance' => 'Maintenance'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('status', $restaurantTable->status ?? 'available') === $value)>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label for="notes" class="form-label">Notes</label>
                    <textarea name="notes" id="notes" rows="4" class="form-control @error('notes') is-invalid @enderror"
                        placeholder="Optional notes about this table">{{ old('notes', $restaurantTable->notes) }}</textarea>
                    @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('restaurant-tables.index') }}" class="btn btn-light">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i> {{ $isEdit ? 'Update Table' : 'Save Table' }}
                </button>
            </div>
        </form>
    </div>
</div>
