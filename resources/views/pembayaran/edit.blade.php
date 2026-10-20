@extends('layout.app')
@section('title', 'Edit Pembayaran | WashFlow')
@section('content')
<div class="container-fluid pt-4 px-4">

    <div class="bg-secondary rounded p-4 mb-4">
        <h4 class="text-white mb-1"><i class="fa fa-edit me-2 text-primary"></i>Edit Pembayaran</h4>
        <small style="color:var(--light);">{{ $payment->no_transaksi }} — {{ $payment->order->no_order ?? '-' }}</small>
    </div>

    <div class="bg-secondary rounded p-4" style="max-width:600px;">
        <form action="{{ route('pembayaran.update', $payment) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Jumlah Dibayar</label>
                <div class="input-group">
                    <span class="input-group-text bg-dark text-white border-0">Rp</span>
                    <input type="number" name="jumlah_dibayar" required min="0"
                           value="{{ old('jumlah_dibayar', $payment->jumlah_dibayar) }}"
                           class="form-control bg-dark text-white border-0">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Metode Pembayaran</label>
                <div class="d-flex gap-3">
                    @foreach(['Cash','Transfer','QRIS'] as $m)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="metode" value="{{ $m }}"
                               id="metode{{ $m }}" {{ $payment->metode == $m ? 'checked' : '' }}>
                        <label class="form-check-label" for="metode{{ $m }}">{{ $m }}</label>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select bg-dark text-white border-0">
                    @foreach(['Lunas','DP','Belum Bayar'] as $st)
                        <option {{ $payment->status == $st ? 'selected' : '' }}>{{ $st }}</option>
                    @endforeach
                </select>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save me-2"></i>Simpan Perubahan</button>
                <a href="{{ route('pembayaran.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>

</div>
@endsection
