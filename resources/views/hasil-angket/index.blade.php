@extends('layouts.app', ['navbar' => 'hasil-angket'])

@section('html_title', 'Hasil Angket')

@push('css')
    <link href="{{ asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" />

    <link href="{{ asset('assets/libs/select2/theme/select2-bootstrap-5-theme.min.css') }}" rel="stylesheet" />
@endpush

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
                                <h3 class="card-title">Dosen mengajar di semester 231</h3>
                                <div class="table-responsive">
                                    <table class="table table-vcenter card-table table-striped table-hover table-group-divider table-bordered">
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
                                                        <a href="" class="btn btn-outline-primary w-100 btn-sm">
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
    <script src="{{ asset('assets/libs/select2/select2.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#pilihSmt').select2({
                theme: 'bootstrap-5'
            });
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
