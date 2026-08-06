@extends('layouts.app')

@section('title', 'Invoice ' . $invoice['invoice_number'] . ' - PUSATKOS')

@push('styles')
<style>
    .pk-inv-header {
        background: linear-gradient(135deg, #007bff, #0056b3);
        color: #fff;
        padding: 30px;
        border-radius: 8px 8px 0 0;
    }
    .pk-inv-header .pk-inv-logo {
        font-size: 1.5rem;
        font-weight: 700;
    }
    .pk-inv-header .pk-inv-logo i {
        margin-right: 8px;
    }
    .pk-inv-body {
        background: #fff;
        padding: 30px;
        border-radius: 0 0 8px 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    }
    .pk-inv-info-row {
        display: flex;
        flex-wrap: wrap;
        gap: 30px;
        margin-bottom: 30px;
    }
    .pk-inv-info-col {
        flex: 1;
        min-width: 220px;
    }
    .pk-inv-info-col h6 {
        font-weight: 700;
        margin-bottom: 12px;
        color: #333;
        text-transform: uppercase;
        font-size: 13px;
        letter-spacing: 0.5px;
    }
    .pk-inv-info-col dl {
        margin-bottom: 0;
    }
    .pk-inv-info-col dt {
        font-weight: 400;
        color: #6c757d;
        font-size: 13px;
    }
    .pk-inv-info-col dd {
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
        font-size: 14px;
    }
    .pk-inv-table {
        width: 100%;
        margin-bottom: 0;
    }
    .pk-inv-table thead th {
        background-color: #f8f9fa;
        font-weight: 600;
        font-size: 13px;
        border-bottom: 2px solid #dee2e6;
        padding: 12px 15px;
    }
    .pk-inv-table tbody td {
        padding: 12px 15px;
        font-size: 14px;
        border-bottom: 1px solid #f0f0f0;
    }
    .pk-inv-table tfoot td {
        padding: 12px 15px;
        font-weight: 700;
        font-size: 15px;
        border-top: 2px solid #dee2e6;
    }
    .pk-inv-status {
        font-size: 13px;
        padding: 6px 16px;
        border-radius: 20px;
        font-weight: 600;
    }
    .pk-inv-status--lunas {
        background-color: #d4edda;
        color: #155724;
    }
    .pk-inv-status--pending {
        background-color: #fff3cd;
        color: #856404;
    }
    .pk-inv-status--expired {
        background-color: #f8d7da;
        color: #721c24;
    }
    .pk-inv-divider {
        border-top: 1px solid #e9ecef;
        margin: 25px 0;
    }
    .pk-inv-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        justify-content: flex-end;
    }
    @media print {
        #ts-header, #breadcrumb, #ts-footer, .pk-inv-actions, .pk-no-print {
            display: none !important;
        }
        .pk-inv-body {
            box-shadow: none;
        }
    }
    @media (max-width: 576px) {
        .pk-inv-header {
            padding: 20px;
        }
        .pk-inv-body {
            padding: 20px;
        }
        .pk-inv-actions {
            justify-content: center;
        }
    }
</style>
@endpush

@section('content')
<div class="ts-page-wrapper ts-has-bokeh-bg" id="page-top">

    @include('partials.navbar')

    @include('partials.alert')

    <main id="ts-main">

        <!--BREADCRUMB
        =========================================================================================================-->
        <section id="breadcrumb">
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('member.invoice.index') }}">Invoice Saya</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $invoice['invoice_number'] }}</li>
                    </ol>
                </nav>
            </div>
        </section>

        <!--PAGE TITLE
        =========================================================================================================-->
        <section id="page-title">
            <div class="container">
                <div class="d-block d-sm-flex justify-content-between align-items-center">
                    <div class="ts-title mb-0">
                        <h1>Detail Invoice</h1>
                        <h5 class="ts-opacity__90">
                            <i class="fa fa-file-invoice text-primary mr-2"></i>
                            {{ $invoice['invoice_number'] }}
                        </h5>
                    </div>
                    <div>
                        @if($invoice['status'] === 'Lunas')
                            <span class="pk-inv-status pk-inv-status--lunas">
                                <i class="fa fa-check-circle mr-1"></i>{{ $invoice['status'] }}
                            </span>
                        @elseif($invoice['status'] === 'Belum Dibayar')
                            <span class="pk-inv-status pk-inv-status--pending">
                                <i class="fa fa-clock mr-1"></i>{{ $invoice['status'] }}
                            </span>
                        @else
                            <span class="pk-inv-status pk-inv-status--expired">
                                <i class="fa fa-times-circle mr-1"></i>{{ $invoice['status'] }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <!--CONTENT
        =========================================================================================================-->
        <section id="content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">

                        <!--Invoice Header-->
                        <div class="pk-inv-header">
                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                <div class="pk-inv-logo">
                                    <i class="fa fa-home"></i>PUSATKOS
                                </div>
                                <div class="text-right">
                                    <div style="font-size: 13px; opacity: 0.9;">Nomor Invoice</div>
                                    <div style="font-size: 18px; font-weight: 700;">{{ $invoice['invoice_number'] }}</div>
                                </div>
                            </div>
                        </div>

                        <!--Invoice Body-->
                        <div class="pk-inv-body">

                            <!--Info Penyewa & Kos-->
                            <div class="pk-inv-info-row">
                                <div class="pk-inv-info-col">
                                    <h6><i class="fa fa-user mr-2"></i>Informasi Penyewa</h6>
                                    <dl>
                                        <dt>Nama Penyewa</dt>
                                        <dd>{{ $invoice['tenant_name'] }}</dd>
                                        <dt>Email</dt>
                                        <dd>{{ $invoice['tenant_email'] }}</dd>
                                        <dt>No. Telepon</dt>
                                        <dd>{{ $invoice['tenant_phone'] }}</dd>
                                    </dl>
                                </div>
                                <div class="pk-inv-info-col">
                                    <h6><i class="fa fa-home mr-2"></i>Informasi Kos</h6>
                                    <dl>
                                        <dt>Nama Kos</dt>
                                        <dd>
                                            <a href="{{ route('kos.show', $invoice['kos_slug'] ?? 'kos-putri-melati') }}">
                                                {{ $invoice['kos'] }}
                                            </a>
                                        </dd>
                                        <dt>Metode Pembayaran</dt>
                                        <dd>{{ $invoice['payment_method'] }}</dd>
                                        <dt>Status Pembayaran</dt>
                                        <dd>
                                            @if($invoice['status'] === 'Lunas')
                                                <span class="pk-inv-status pk-inv-status--lunas">{{ $invoice['status'] }}</span>
                                            @elseif($invoice['status'] === 'Belum Dibayar')
                                                <span class="pk-inv-status pk-inv-status--pending">{{ $invoice['status'] }}</span>
                                            @else
                                                <span class="pk-inv-status pk-inv-status--expired">{{ $invoice['status'] }}</span>
                                            @endif
                                        </dd>
                                    </dl>
                                </div>
                            </div>

                            <div class="pk-inv-divider"></div>

                            <!--Detail Waktu-->
                            <div class="pk-inv-info-row">
                                <div class="pk-inv-info-col">
                                    <h6><i class="fa fa-calendar-alt mr-2"></i>Detail Waktu</h6>
                                    <dl>
                                        <dt>Tanggal Booking</dt>
                                        <dd>{{ $invoice['booking_date'] }}</dd>
                                        <dt>Check In</dt>
                                        <dd>{{ $invoice['check_in'] }}</dd>
                                    </dl>
                                </div>
                                <div class="pk-inv-info-col">
                                    <h6>&nbsp;</h6>
                                    <dl>
                                        <dt>Check Out</dt>
                                        <dd>{{ $invoice['check_out'] }}</dd>
                                        <dt>Durasi Menginap</dt>
                                        <dd>{{ $invoice['duration'] }}</dd>
                                    </dl>
                                </div>
                            </div>

                            <div class="pk-inv-divider"></div>

                            <!--Rincian Biaya-->
                            <h6 style="font-weight: 700; text-transform: uppercase; font-size: 13px; letter-spacing: 0.5px; margin-bottom: 15px;">
                                <i class="fa fa-receipt mr-2"></i>Rincian Biaya
                            </h6>

                            <div class="table-responsive">
                                <table class="pk-inv-table">
                                    <thead>
                                        <tr>
                                            <th>Keterangan</th>
                                            <th>Durasi</th>
                                            <th class="text-right">Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Biaya Sewa - {{ $invoice['kos'] }}</td>
                                            <td>{{ $invoice['duration'] }}</td>
                                            <td class="text-right">Rp {{ number_format($invoice['amount'], 0, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <td>Biaya Admin</td>
                                            <td>-</td>
                                            <td class="text-right">Rp {{ number_format($invoice['admin_fee'], 0, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <td>Pajak</td>
                                            <td>-</td>
                                            <td class="text-right">Rp {{ number_format($invoice['tax'], 0, ',', '.') }}</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2"><strong>Total Pembayaran</strong></td>
                                            <td class="text-right text-primary" style="font-size: 18px;">
                                                <strong>Rp {{ number_format($invoice['total'], 0, ',', '.') }}</strong>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            @if($invoice['paid_at'])
                            <div class="pk-inv-divider"></div>
                            <div class="alert alert-success mb-0" style="border-radius: 6px;">
                                <i class="fa fa-check-circle mr-2"></i>
                                Pembayaran telah diterima pada <strong>{{ $invoice['paid_at'] }}</strong> via <strong>{{ $invoice['payment_method'] }}</strong>.
                            </div>
                            @elseif($invoice['status'] === 'Belum Dibayar')
                            <div class="pk-inv-divider"></div>
                            <div class="alert alert-warning mb-0" style="border-radius: 6px;">
                                <i class="fa fa-exclamation-triangle mr-2"></i>
                                Invoice ini belum dibayar. Batas pembayaran: <strong>{{ $invoice['due_date'] }}</strong>.
                            </div>
                            @endif

                        </div>
                        <!--end pk-inv-body-->

                        <!--Action Buttons-->
                        <div class="pk-inv-actions mt-4 pk-no-print">
                            <a href="{{ route('member.invoice.index') }}" class="btn btn-outline-dark">
                                <i class="fa fa-arrow-left mr-2"></i>Kembali
                            </a>
                            <button type="button" class="btn btn-primary" onclick="window.print()">
                                <i class="fa fa-print mr-2"></i>Cetak Invoice
                            </button>
                        </div>

                    </div>
                    <!--end col-lg-10-->
                </div>
                <!--end row-->
            </div>
            <!--end container-->
        </section>

    </main>
    <!--end #ts-main-->

    @include('partials.footer')

</div>
<!--end page-->
@endsection
