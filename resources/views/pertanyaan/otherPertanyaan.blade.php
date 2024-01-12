@extends('layouts.app', ['navbar' => 'pertanyaan'])

@section('html_title', 'Pertanyaan Semester Sebelumnya')

@push('css')
    <!-- Select2 -->
    <link href="{{ asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" />
    <!-- Select2 Bootstrap 5 Theme -->
    <link href="{{ asset('assets/libs/select2/theme/select2-bootstrap-5-theme.min.css') }}" rel="stylesheet" />
    <!-- Datatables Bootstrap 5 Theme -->
    <link href="{{ asset('assets/libs/datatables/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
@endpush

@php
    use App\Models\AngketMf;
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
                            Pertanyaan Semester Sebelumnya
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
                                    Silahkan pilih semester pertanyaan yang ingin dilihat
                                </p>
                                <div class="d-flex">
                                    <select class="form-select" id="pilihSmt">
                                        @foreach ($semuaSmt as $smt)
                                            <option {{ request('smt') == $smt->smt ? 'selected' : '' }}>
                                                {{ $smt->smt }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button class="btn btn-primary ms-2" type="button" onclick="goToSemester()">
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
                        goto SKIP_LOOP;
                    }
                @endphp


                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-md-flex justify-content-between ">
                                    <h3 class="card-title">Pertanyaan di semester {{ request('smt') }}</h3>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover table-group-divider table-bordered" id="tabelPrtyn">
                                        <thead>
                                            <tr>
                                                <th class="bg-primary-subtle text-center" style="width: 10%">
                                                    No.
                                                </th>
                                                <th class="bg-primary-subtle text-center" {{-- style="width:20%" --}}>
                                                    Uraian
                                                </th>
                                                <th class="bg-primary-subtle text-center" style="width: 15%">
                                                    Jenis
                                                </th>
                                                <th class="text-center bg-primary-subtle" style="width:13%">
                                                    Status
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($semuaPertanyaan as $prtyn)
                                                <tr>
                                                    <td class="text-center">
                                                        {{ $loop->iteration }}.
                                                    </td>
                                                    <td class="">
                                                        {{ $prtyn->pertanyaan->uraian ?? null }}
                                                    </td>
                                                    <td class="text-center">
                                                        @if ($prtyn->pertanyaan->jenis == AngketMf::PIL_GANDA)
                                                            <svg class="icon icon-tabler icon-tabler-list-details" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M13 5h8" />
                                                                <path d="M13 9h5" />
                                                                <path d="M13 15h8" />
                                                                <path d="M13 19h5" />
                                                                <path d="M3 4m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                                                                <path d="M3 14m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                                                            </svg>
                                                            Pilihan Ganda
                                                        @elseif ($prtyn->pertanyaan->jenis == AngketMf::ISIAN_BEBAS)
                                                            <svg class="icon icon-tabler icon-tabler-writing" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M20 17v-12c0 -1.121 -.879 -2 -2 -2s-2 .879 -2 2v12l2 2l2 -2z" />
                                                                <path d="M16 7h4" />
                                                                <path d="M18 19h-13a2 2 0 1 1 0 -4h4a2 2 0 1 0 0 -4h-3" />
                                                            </svg>
                                                            Isian Bebas
                                                        @elseif ($prtyn->pertanyaan->jenis == AngketMf::ISIAN_CAMPUR)
                                                            <svg class="icon icon-tabler icon-tabler-forms" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M12 3a3 3 0 0 0 -3 3v12a3 3 0 0 0 3 3" />
                                                                <path d="M6 3a3 3 0 0 1 3 3v12a3 3 0 0 1 -3 3" />
                                                                <path d="M13 7h7a1 1 0 0 1 1 1v8a1 1 0 0 1 -1 1h-7" />
                                                                <path d="M5 7h-1a1 1 0 0 0 -1 1v8a1 1 0 0 0 1 1h1" />
                                                                <path d="M17 12h.01" />
                                                                <path d="M13 12h.01" />
                                                            </svg>
                                                            Campur
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="">
                                                            @if ($prtyn->pertanyaan->status)
                                                                <span class="badge bg-success me-1"></span> Aktif
                                                            @else
                                                                <span class="badge bg-danger me-1"></span> Non Aktif
                                                            @endif
                                                        </div>
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
                    SKIP_LOOP:
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

            $('#tabelPrtyn').DataTable({
                pageLength: 25,
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
