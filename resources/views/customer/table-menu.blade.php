<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Menu - Table {{ $restaurantTable->table_number }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f7f7f8;
        }

        .menu-item-image {
            width: 100%;
            height: 170px;
            object-fit: cover;
        }

        .section-heading {
            border-bottom: 2px solid #e9ecef;
            padding-bottom: .6rem;
        }
    </style>
</head>

<body>
    <header class="bg-dark text-white py-4">
        <div class="container text-center">
            <h1 class="h3 mb-1">{{ config('app.name', 'Our Restaurant') }}</h1>
            <p class="mb-2">Welcome! Browse our menu.</p>
            <span class="badge bg-light text-dark">
                Table {{ $restaurantTable->table_number }} · {{ ucfirst($restaurantTable->type) }}
            </span>
        </div>
    </header>

    <main class="container py-4">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (!empty($restaurantInfo))
            <div class="text-center mb-4">
                @if (!empty($restaurantInfo['description']))
                    <p class="text-muted">{{ $restaurantInfo['description'] }}</p>
                @endif
                @if (!empty($restaurantInfo['phone']))
                    <p class="mb-1">Contact: {{ $restaurantInfo['phone'] }}</p>
                @endif
            </div>
        @endif

        @forelse ($sections as $section)
            <section class="mb-5">
                <h2 class="h4 section-heading mb-3">{{ $section->name }}</h2>

                @foreach ($section->categories as $category)
                    <div class="mb-4">
                        <h3 class="h5 mb-3">{{ $category->name }}</h3>

                        @foreach ($category->subcategories as $subcategory)
                            <div class="mb-4">
                                <h4 class="h6 text-muted mb-3">{{ $subcategory->name }}</h4>
                                <div class="row g-3">
                                    @foreach ($subcategory->items->where('availability', 'available') as $item)
                                        <div class="col-12 col-sm-6 col-lg-4">
                                            <div class="card h-100 border-0 shadow-sm">
                                                @if ($item->image)
                                                    {{-- {{ $item->image }} --}}
                                                    <img class="menu-item-image" src="{{ asset($item->image) }}"
                                                        alt="{{ $item->name }}">
                                                @endif
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between gap-2">
                                                        <h5 class="card-title h6">{{ $item->name }}</h5>
                                                        <strong
                                                            class="text-nowrap">{{ number_format($item->price, 2) }}</strong>
                                                    </div>
                                                    @if ($item->description)
                                                        <p class="card-text text-muted small mb-0">
                                                            {{ $item->description }}</p>
                                                    @endif
                                                    @if (!empty($item->preparation_time))
                                                        <div class="small text-muted mt-2">
                                                            Preparation: {{ $item->preparation_time }} min
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </section>
        @empty
            <div class="alert alert-secondary text-center">The menu is not available right now.</div>
        @endforelse

        <div class="text-center mt-5">
            {{-- Optional: connect this form to a call-waiter endpoint if that feature is enabled. --}}
            @if (Route::has('customer.call-waiter'))
                {{-- <form action="{{ route('customer.call-waiter', $restaurantTable) }}" method="POST"> --}}
                @csrf
                <button type="submit" class="btn btn-outline-dark">
                    Call Waiter
                </button>
                </form>
            @endif
            <p class="small text-muted mt-3 mb-0">This menu is for browsing only. Orders are handled by restaurant
                staff.</p>
        </div>
    </main>
</body>

</html>
