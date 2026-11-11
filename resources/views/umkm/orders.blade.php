@extends('layouts.app')

@section('title', 'Pesanan Masuk')

@section('content')
<div class="container py-4">
    <h3 class="mb-3">Pesanan Masuk</h3>

    {{-- Pesan berhasil --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Pesan error --}}
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    {{-- Validasi error --}}
    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Pelanggan</th>
                            <th>Total (Produk Saya)</th>
                            <th>Status Pesanan</th>
                            <th>Pembayaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($orders as $order)

                            @php
                                $sellerItem = $order->items
                                    ->where('umkm_id', $umkm->id)
                                    ->first();

                                $sellerTotal = $order->items
                                    ->where('umkm_id', $umkm->id)
                                    ->sum('subtotal');
                            @endphp

                            @if($sellerItem)
                                <tr>
                                    {{-- Nomor pesanan --}}
                                    <td>
                                        {{ $order->order_number }}
                                    </td>

                                    {{-- Nama pelanggan --}}
                                    <td>
                                        {{ $order->user->name }}
                                    </td>

                                    {{-- Total produk seller --}}
                                    <td>
                                        Rp {{ number_format($sellerTotal, 0, ',', '.') }}
                                    </td>

                                    {{-- Status pesanan --}}
                                    <td>
                                        @php
                                            $statusColor = [
                                                'pending' => 'warning',
                                                'processing' => 'info',
                                                'completed' => 'success',
                                                'cancelled' => 'danger',
                                            ];

                                            $color = $statusColor[$sellerItem->status] ?? 'secondary';
                                        @endphp

                                        <span class="badge bg-{{ $color }}">
                                            {{ ucfirst($sellerItem->status) }}
                                        </span>
                                    </td>

                                    {{-- Informasi pembayaran --}}
                                    <td>
                                        <div>
                                            <strong>
                                                {{ strtoupper($order->payment_method) }}
                                            </strong>
                                        </div>

                                        @if($order->payment_status === 'paid')
                                            <span class="badge bg-success">
                                                Lunas
                                            </span>
                                        @elseif($order->payment_status === 'waiting_verification')
                                            <span class="badge bg-warning text-dark">
                                                Menunggu Verifikasi
                                            </span>
                                        @elseif($order->payment_status === 'failed')
                                            <span class="badge bg-danger">
                                                Pembayaran Ditolak
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                Belum Dibayar
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Aksi seller --}}
                                    <td>
                                        <form
                                            method="POST"
                                            action="{{ route('umkm.order-items.update', $sellerItem->id) }}"
                                        >
                                            @csrf
                                            @method('PUT')

                                            <select
                                                name="status"
                                                class="form-select form-select-sm"
                                                onchange="this.form.submit()"
                                            >
                                                <option
                                                    value="pending"
                                                    {{ $sellerItem->status === 'pending' ? 'selected' : '' }}
                                                >
                                                    Pending
                                                </option>

                                                <option
                                                    value="processing"
                                                    {{ $sellerItem->status === 'processing' ? 'selected' : '' }}
                                                >
                                                    Proses
                                                </option>

                                                <option
                                                    value="completed"
                                                    {{ $sellerItem->status === 'completed' ? 'selected' : '' }}
                                                >
                                                    Selesai
                                                </option>

                                                <option
                                                    value="cancelled"
                                                    {{ $sellerItem->status === 'cancelled' ? 'selected' : '' }}
                                                >
                                                    Batal
                                                </option>
                                            </select>
                                        </form>
                                    </td>
                                </tr>
                            @endif

                        @empty
                            <tr>
                                <td colspan="6" class="text-center">
                                    Belum ada pesanan masuk.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection
