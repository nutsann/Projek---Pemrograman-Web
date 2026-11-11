@extends('layouts.admin')

@section('title', 'Detail Pesanan')

@section('admin_content')
<div class="page-header-box d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-header-title">Detail Pesanan #{{ $order->order_number }}</h1>
        <p class="text-muted mb-0">
            {{ $order->created_at->format('d M Y H:i') }}
        </p>
    </div>
    <a href="{{ route('admin.orders') }}" class="btn btn-outline-secondary">
        Kembali
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-7">

        {{-- INFORMASI PRODUK --}}
        <div class="admin-table-card p-4 mb-4">
            <h5 class="mb-3">Produk Pesanan</h5>

            @foreach($order->items as $item)
                <div class="d-flex justify-content-between border-bottom py-3">
                    <div>
                        <strong>{{ $item->product_name }}</strong>
                        <div class="small text-muted">
                            {{ $item->quantity }} x
                            Rp {{ number_format($item->price, 0, ',', '.') }}
                        </div>
                        <div class="small text-muted">
                            Status item: {{ \App\Models\Order::statusLabel($item->status) }}
                        </div>
                    </div>

                    <strong>
                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                    </strong>
                </div>
            @endforeach

            <div class="d-flex justify-content-between pt-3">
                <strong>Subtotal</strong>
                <strong>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</strong>
            </div>

            <div class="d-flex justify-content-between">
                <span>Ongkos Kirim</span>
                <span>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
            </div>

            <div class="d-flex justify-content-between border-top mt-2 pt-3">
                <strong>Total Pembayaran</strong>
                <strong class="text-success">
                    Rp {{ number_format($order->total, 0, ',', '.') }}
                </strong>
            </div>
        </div>

        {{-- INFORMASI PEMBELI --}}
        <div class="admin-table-card p-4 mb-4">
            <h5 class="mb-3">Informasi Pembeli</h5>

            <p class="mb-1">
                <strong>Nama:</strong>
                {{ $order->user->name ?? '-' }}
            </p>

            <p class="mb-1">
                <strong>Email:</strong>
                {{ $order->user->email ?? '-' }}
            </p>
        </div>

        {{-- INFORMASI PENGIRIMAN --}}
        <div class="admin-table-card p-4">
            <h5 class="mb-3">Informasi Pengiriman</h5>

            <p class="mb-1">
                <strong>Penerima:</strong> {{ $order->shipping_name }}
            </p>

            <p class="mb-1">
                <strong>Telepon:</strong> {{ $order->shipping_phone }}
            </p>

            <p class="mb-0">
                <strong>Alamat:</strong> {{ $order->shipping_address }}
            </p>
        </div>
    </div>

    <div class="col-lg-5">

        {{-- INFORMASI PESANAN --}}
        <div class="admin-table-card p-4 mb-4">
            <h5 class="mb-3">Informasi Pesanan</h5>

            <p>
                <strong>Status Pesanan:</strong>
                {{ \App\Models\Order::statusLabel($order->status) }}
            </p>

            <p>
                <strong>Metode Pembayaran:</strong>
                {{ \App\Models\Order::paymentMethodLabel($order->payment_method) }}
            </p>

            <p class="mb-0">
                <strong>Status Pembayaran:</strong>
                {{ \App\Models\Order::paymentStatusLabel($order->payment_status) }}
            </p>
        </div>

        {{-- BUKTI PEMBAYARAN --}}
        <div class="admin-table-card p-4 mb-4">
            <h5 class="mb-3">Bukti Pembayaran</h5>

            @if($order->payment_proof)
                <div class="alert alert-success">
                    Pembeli sudah mengunggah bukti pembayaran.
                </div>

                <a href="{{ asset('storage/' . $order->payment_proof) }}"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="btn btn-outline-primary w-100 mb-3">
                    Buka Bukti Pembayaran
                </a>
            @else
                <div class="alert alert-warning">
                    Belum ada bukti pembayaran yang diunggah.
                </div>
            @endif

            {{-- VERIFIKASI TRANSFER BANK / QRIS --}}
            @if(
                in_array($order->payment_method, ['bank_transfer', 'qris'], true) &&
                $order->payment_status === 'waiting_verification' &&
                $order->payment_proof &&
                $order->status !== 'cancelled'
            )
                <hr>

                <h6>Verifikasi Pembayaran</h6>
                <p class="small text-muted">
                    Periksa bukti pembayaran sebelum menentukan hasil verifikasi.
                </p>

                <form action="{{ route('admin.order.payment-status', $order->id) }}"
                      method="POST"
                      class="mb-2">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="payment_status" value="paid">

                    <button type="submit"
                            class="btn btn-success w-100"
                            onclick="return confirm('Apakah bukti pembayaran sudah benar dan pembayaran telah diterima?')">
                        <i class="fas fa-check me-1"></i>
                        Terima Pembayaran
                    </button>
                </form>

                <form action="{{ route('admin.order.payment-status', $order->id) }}"
                      method="POST">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="payment_status" value="failed">

                    <button type="submit"
                            class="btn btn-danger w-100"
                            onclick="return confirm('Apakah kamu yakin ingin menolak pembayaran ini?')">
                        <i class="fas fa-times me-1"></i>
                        Tolak Pembayaran
                    </button>
                </form>
            @endif

            {{-- KONFIRMASI PEMBAYARAN COD --}}
            @if(
                $order->payment_method === 'cod' &&
                $order->status === 'completed' &&
                $order->payment_status === 'unpaid'
            )
                <hr>

                <div class="alert alert-warning">
                    <strong>Pembayaran COD belum lunas.</strong>
                    <p class="mb-0 small">
                        Pastikan uang pembayaran sudah diterima sebelum mengonfirmasi.
                    </p>
                </div>

                <form action="{{ route('admin.order.confirm-cod', $order->id) }}"
                      method="POST">
                    @csrf
                    @method('PUT')

                    <button type="submit"
                            class="btn btn-success w-100"
                            onclick="return confirm('Apakah uang pembayaran COD sudah benar-benar diterima?')">
                        <i class="fas fa-check-circle me-1"></i>
                        Konfirmasi COD Lunas
                    </button>
                </form>
            @endif

            @if($order->payment_status === 'paid')
                <div class="alert alert-success mb-0">
                    <i class="fas fa-check-circle me-1"></i>
                    Pembayaran sudah dikonfirmasi lunas.
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
