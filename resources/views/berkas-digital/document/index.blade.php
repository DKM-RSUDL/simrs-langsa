@extends('layouts.administrator.master')

@push('css')
    <style>
        .tab-minimal {
            border-bottom: 1px solid #e5e7eb;
        }

        .tab-minimal .tab-link {
            background: none;
            border: 1px solid transparent;
            padding: 6px 12px;
            font-size: 14px;
            color: #9ca3af;
            font-weight: 500;
            position: relative;
            cursor: pointer;

            /* rounded di atas saja */
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }

        .tab-minimal .tab-link.active {
            color: #111827;
            font-weight: 600;
            background-color: #ffffff;
            border-color: #e5e7eb;
            border-bottom-color: transparent;
            /* nyatu ke konten */
        }

        .tab-minimal .tab-link.active::after {
            content: "";
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: #3b82f6;
        }
    </style>
@endpush

@section('content')
    @php
        $tab = $_GET['pel'] ?? 'ri';
    @endphp

    <x-content-card>

        {{-- Tab --}}
        <div class="row">
            <div class="col">
                <ul class="nav tab-minimal">
                    <li class="nav-item py-2">
                        <a href="?pel=ri" class="tab-link text-decoration-none {{ $tab == 'ri' ? 'active' : '' }}">Rawat
                            Inap</a>
                    </li>

                    <li class="nav-item py-2">
                        <a href="?pel=rj" class="tab-link text-decoration-none {{ $tab == 'rj' ? 'active' : '' }}">Rawat
                            Jalan</a>
                    </li>
                </ul>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="row">
            <div class="col">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label" for="unit_filter">{{ $tab == 'rj' ? 'Poli' : 'Ruang' }}</label>
                            <select class="form-select select2" id="unit_filter">
                                <option value="">--Pilih Kamar--</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="customer_filter" class="form-label">Jenis Bayar</label>
                            <select id="customer_filter" class="form-select select2">
                                <option value="">--Pilih Jenis Bayar--</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <label for="periode_filter" class="form-label">Periode</label>
                        <div class="input-group input-daterange">
                            <input type="text" class="form-control" id="startdate_filter" readonly
                                value="{{ date('Y-m-d') }}">
                            <div class="input-group-addon">to</div>
                            <input type="text" class="form-control" id="enddate_filter" readonly
                                value="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable">
                        <thead>
                            <tr>
                                <th style="width:5%">Aksi</th>
                                <th>Pasien</th>
                                <th>No RM / Tgl Masuk</th>
                                <th>DPJP</th>
                                <th>Alamat</th>
                                <th>Jaminan</th>
                                <th>Status Pelayanan</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </x-content-card>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();

            $('.input-daterange input').each(function() {
                $(this).datepicker({
                    format: 'yyyy-mm-dd',
                });
            });
        });
    </script>
@endpush
