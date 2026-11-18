@extends('dashboard.layouts.master')

@section('title', 'Table QR Code')
@section('page-title', 'Table QR Code')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
            <div>
                <a href="{{ route('restaurant-tables.show', $restaurantTable) }}" class="text-decoration-none">
                    <i class="bi bi-arrow-left"></i> Back to Table
                </a>
                <h4 class="mt-2 mb-0">QR Code - {{ $restaurantTable->table_number }}</h4>
            </div>
            <div class="d-flex gap-2">
                <button type="button" onclick="window.print()" class="btn btn-outline-secondary">
                    <i class="bi bi-printer me-1"></i> Print
                </button>
                <form action="{{ route('restaurant-tables.qr.regenerate', $restaurantTable) }}" method="POST"
                    onsubmit="return confirm('Regenerate this table QR token? The old QR link will stop working.')">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-outline-danger">
                        <i class="bi bi-arrow-repeat me-1"></i> Regenerate
                    </button>
                </form>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-5">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <h3 class="mb-1">{{ $restaurantTable->table_number }}</h3>
                        <p class="text-muted">{{ ucfirst($restaurantTable->type) }} Table</p>

                        {{-- Controller should provide $qrCodeImage as a data URI or image URL. --}}
                        @if (!empty($qr))
                            {{-- <div id="qr-container">
                                {!! $qr !!}
                            </div> --}}
                            <br>
                            <br>
                            <br>
                            <img src="data:image/png;base64,{{ base64_encode($qr) }}"
                                alt="QR Code for {{ $restaurantTable->table_number }}"
                                class="img-fluid mx-auto d-block mb-3" style="width: 280px; max-width: 100%;">
                        @else
                            <div class="border rounded p-5 mb-3 text-muted">
                                QR code image will appear here after QR generation is connected.
                            </div>
                        @endif

                        <div class="small text-muted text-break mb-3">{{ $menuUrl ?? '' }}</div>
                        @if (!empty($qr))
                            <a href="{{ route('restaurant-tables.qr.download', [$restaurantTable, 'svg']) }}"
                                class="btn btn-primary">
                                <i class="bi bi-download me-1"></i> Download SVG
                            </a>
                            <a href="{{ route('restaurant-tables.qr.download', [$restaurantTable, 'png']) }}"
                                {{-- download="table-{{ $restaurantTable->table_number }}-qr.png" --}} class="btn btn-primary">
                                <i class="bi bi-download me-1"></i> Download PNG
                            </a>
                            <br>
                            <br>
                            <br>
                            {{-- <button type="button" onclick="downloadPng()" class="btn btn-primary">
                                <i class="bi bi-download me-1"></i> Download PNG
                            </button> --}}
                            {{-- <a href="#" download="table-{{ $restaurantTable->table_number }}-qr.png"
                            class="btn btn-primary">
                            <i class="bi bi-download me-1"></i> Download PNG
                            </a> --}}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            .card,
            .card * {
                visibility: visible;
            }

            .card {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                box-shadow: none !important;
            }

            button,
            a,
            form {
                display: none !important;
            }
        }
    </style>
    <script>
        function downloadPng() {
            const svg = document.querySelector('#qr-container svg');

            if (!svg) {
                alert('QR Code not found');
                return;
            }

            const svgData = new XMLSerializer().serializeToString(svg);

            const svgBlob = new Blob([svgData], {
                type: 'image/svg+xml;charset=utf-8'
            });

            const url = URL.createObjectURL(svgBlob);
            const image = new Image();

            image.onload = function() {
                const canvas = document.createElement('canvas');
                canvas.width = 600;
                canvas.height = 600;

                const context = canvas.getContext('2d');
                context.fillStyle = '#ffffff';
                context.fillRect(0, 0, 600, 600);
                context.drawImage(image, 0, 0, 600, 600);

                const link = document.createElement('a');
                link.href = canvas.toDataURL('image/png');
                link.download = 'table-{{ $restaurantTable->table_number }}-qr.png';
                link.click();

                URL.revokeObjectURL(url);
            };

            image.onerror = function() {
                alert('Could not convert QR Code to PNG');
                URL.revokeObjectURL(url);
            };

            image.src = url;
        }
    </script>
@endsection
