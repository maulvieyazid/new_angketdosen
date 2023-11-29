@extends('layouts.app', ['navbar' => 'hasil-angket'])

@section('html_title', 'Hasil Angket')

@push('css')
    <!-- Select2 -->
    <link href="{{ asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" />
    <!-- Select2 Bootstrap 5 Theme -->
    <link href="{{ asset('assets/libs/select2/theme/select2-bootstrap-5-theme.min.css') }}" rel="stylesheet" />
    <!-- Datatables Bootstrap 5 Theme -->
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables/dataTables.bootstrap5.min.css') }}" />
@endpush

@php
    use Illuminate\Support\Facades\Crypt;
@endphp

@section('content')
    <div class="page-wrapper">

        <!-- Page header -->
        <div class="page-header d-print-none">
            <div class="container-xl">

                @include('layouts.alert')

                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">
                            Hasil Angket
                        </h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Page body -->
        <div class="page-body">
            <div class="container-xl">

                <div class="row mb-3">
                    <div class="col-md-5">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">Semester</h3>
                                <p class="card-subtitle">
                                    Silahkan pilih semester untuk melihat hasil angket
                                </p>
                                <div class="d-flex">
                                    <select class="form-select" id="pilihSmt">
                                        @foreach ($semuaSmt as $smt)
                                            <option {{ request('smt') == $smt->smt ? 'selected' : '' }}>
                                                {{ $smt->smt }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="button" class="btn btn-primary ms-2" onclick="goToSemester()">
                                        Tampilkan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @php
                    // Kalo query param "smt" null, maka skip looping dosen
                    if (!request('smt')) {
                        goto SKIP_LOOP_DOSEN;
                    }
                @endphp


                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-3">
                                    <h3 class="card-title">Dosen mengajar di semester 231</h3>
                                    <a href="{{ route('download-excel.hasil-angket', ['smt' => request('smt')]) }}" class="btn btn-success" target="_blank">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-type-xls" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                            <path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" />
                                            <path d="M4 15l4 6" />
                                            <path d="M4 21l4 -6" />
                                            <path d="M17 20.25c0 .414 .336 .75 .75 .75h1.25a1 1 0 0 0 1 -1v-1a1 1 0 0 0 -1 -1h-1a1 1 0 0 1 -1 -1v-1a1 1 0 0 1 1 -1h1.25a.75 .75 0 0 1 .75 .75" />
                                            <path d="M11 15v6h3" />
                                        </svg>
                                        Download Excel Hasil Angket
                                    </a>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-vcenter card-table table-striped table-hover table-group-divider table-bordered" id="tabelDosen">
                                        <thead>
                                            <tr>
                                                <th class="bg-primary-subtle text-center" style="width: 10%">
                                                    No.
                                                </th>
                                                <th class="bg-primary-subtle text-center" style="width: 20%">NIK</th>
                                                <th class="bg-primary-subtle text-center">Nama Dosen</th>
                                                <th class="text-center bg-primary-subtle" style="width: 13%">
                                                    Aksi
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($semuaDosen as $dosen)
                                                <tr>
                                                    <td class="text-center">
                                                        {{ $loop->iteration }}.
                                                    </td>
                                                    <td class="text-center">
                                                        {{ $dosen->nik }}
                                                    </td>
                                                    <td class="">
                                                        {{ $dosen->karyawan->nama ?? null }}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $data = json_encode([
                                                                'smt' => request('smt'),
                                                                'nik' => $dosen->nik,
                                                            ]);

                                                            $data = Crypt::encryptString($data);

                                                            $route = route('detail.hasil-angket', $data);
                                                        @endphp
                                                        <a href="{{ $route }}" class="btn btn-outline-primary w-100 btn-sm">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                                <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                                            </svg>
                                                            Tampilkan
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @php
                    SKIP_LOOP_DOSEN:
                @endphp

            </div>
        </div>

    </div>

@endsection


@push('js')
    <!-- Select2 -->
    <script src="{{ asset('assets/libs/select2/select2.min.js') }}"></script>
    <!-- Datatables -->
    <script src="{{ asset('assets/libs/datatables/jquery.dataTables.min.js') }}"></script>
    <!-- Datatables Bootstrap 5 Theme -->
    <script src="{{ asset('assets/libs/datatables/dataTables.bootstrap5.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#pilihSmt').select2({
                theme: 'bootstrap-5'
            });

            $('#tabelDosen').DataTable();
        });
    </script>

    <script>
        function goToSemester() {
            // Ambil nilai semester
            const selectedSemester = document.getElementById('pilihSmt').value;

            // Membuat objek URL dari URL saat ini
            const currentUrl = new URL(window.location.href);

            // Menambahkan parameter query "smt" dengan nilai semester
            currentUrl.searchParams.set('smt', selectedSemester);

            // Mengarahkan ke URL yang baru dibuat
            window.location.href = currentUrl.href;
        }
    </script>
@endpush
