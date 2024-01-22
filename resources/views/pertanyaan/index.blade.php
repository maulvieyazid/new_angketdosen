@extends('layouts.app', ['navbar' => 'pertanyaan'])

@section('html_title', 'Maintenance Pertanyaan')

@push('css')
    <!-- Datatables Bootstrap 5 Theme -->
    <link href="{{ asset('assets/libs/datatables/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
@endpush

@php
    use App\Models\AngketMf;
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
                            Maintenance Pertanyaan
                        </h2>
                    </div>
                </div>

                @if ($inPeriodeAngket)
                    <div class="alert alert-info mb-0 my-2" role="alert">
                        <div class="d-flex">
                            <div>
                                <svg class="icon alert-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path>
                                    <path d="M12 9h.01"></path>
                                    <path d="M11 12h1v4h1"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="alert-title">Informasi!</h4>
                                <div class="text-secondary">
                                    Hari ini adalah periode pengisian angket dosen.
                                    <br>
                                    Anda tidak bisa melakukan perubahan pada pertanyaan.
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Page body -->
        <div class="page-body">
            <div class="container-xl">

                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                @if (!$inPeriodeAngket)
                                    <div class="mb-3">
                                        <button class="btn btn-primary me-1" data-bs-toggle="modal" data-bs-target="#modalTambahPrtyn">
                                            + Pertanyaan
                                        </button>

                                        <a class="btn btn-outline-lime me-1" href="{{ route('koreksi-urut.pertanyaan') }}">
                                            <svg class="icon icon-tabler icon-tabler-reorder" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M3 15m0 1a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v2a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1z" />
                                                <path d="M10 15m0 1a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v2a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1z" />
                                                <path d="M17 15m0 1a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v2a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1z" />
                                                <path d="M5 11v-3a3 3 0 0 1 3 -3h8a3 3 0 0 1 3 3v3" />
                                                <path d="M16.5 8.5l2.5 2.5l2.5 -2.5" />
                                            </svg>
                                            Koreksi Urutan
                                        </a>

                                        <div class="dropdown d-inline-block">
                                            <button class="btn border-muted" id="dropdownMenu2" data-bs-toggle="dropdown" type="button" aria-expanded="false">
                                                <svg class="icon icon-tabler icon-tabler-dots-vertical m-0" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                    stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                                    <path d="M12 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                                    <path d="M12 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                                </svg>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                <li>
                                                    <a class="dropdown-item" type="button" href="{{ route('list.pertanyaan.lain') }}">
                                                        Lihat Pertanyaan Semester Sebelumnya
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>

                                    </div>
                                @endif

                                <div class="table-responsive">
                                    <table class="table table-striped table-hover table-bordered" id="tabelPertanyaan">
                                        <thead>
                                            <tr>
                                                <th class="text-center bg-primary-subtle w-0">Urut</th>
                                                <th class="text-center bg-primary-subtle">Uraian</th>
                                                <th class="text-center bg-primary-subtle">Kategori</th>
                                                <th class="text-center bg-primary-subtle" style="width: 14.5%">Jenis</th>
                                                <th class="text-center bg-primary-subtle" style="width: 11%">Status</th>
                                                <!-- Tampilkan ini kalau bukan di periode angket dosen -->
                                                @if (!$inPeriodeAngket)
                                                    <th class="text-center bg-primary-subtle w-0">Ganti Status</th>
                                                    <th class="text-center bg-primary-subtle">Ubah</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pertanyaan as $prtyn)
                                                @php
                                                    // Bentuk JSON nya masing2 pertanyaan
                                                    $jsonPrtyn = $prtyn->toJson();

                                                    // Enkripsi dari JSON
                                                    $encPrtyn = Crypt::encryptString($jsonPrtyn);
                                                @endphp

                                                <tr>
                                                    <td class="text-center">
                                                        {{ $prtyn->urut }}
                                                    </td>
                                                    <td>
                                                        {{ $prtyn->uraian }}
                                                    </td>
                                                    <td>
                                                        {{ $prtyn->kategori->nama_kategori ?? null }}
                                                    </td>
                                                    <td class="text-center">
                                                        @if ($prtyn->jenis == AngketMf::PIL_GANDA)
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
                                                        @elseif ($prtyn->jenis == AngketMf::ISIAN_BEBAS)
                                                            <svg class="icon icon-tabler icon-tabler-writing" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M20 17v-12c0 -1.121 -.879 -2 -2 -2s-2 .879 -2 2v12l2 2l2 -2z" />
                                                                <path d="M16 7h4" />
                                                                <path d="M18 19h-13a2 2 0 1 1 0 -4h4a2 2 0 1 0 0 -4h-3" />
                                                            </svg>
                                                            Isian Bebas
                                                        @elseif ($prtyn->jenis == AngketMf::ISIAN_CAMPUR)
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
                                                        <div class="status-prtyn">
                                                            @if ($prtyn->status)
                                                                <span class="badge bg-success me-1"></span> Aktif
                                                            @else
                                                                <span class="badge bg-danger me-1"></span> Non Aktif
                                                            @endif

                                                        </div>
                                                    </td>
                                                    <!-- Tampilkan ini kalau bukan di periode angket dosen -->
                                                    @if (!$inPeriodeAngket)
                                                        <td class="text-center">
                                                            <div class="form-check form-switch d-flex justify-content-center">
                                                                <input class="form-check-input" data-enc-pertanyaan="{{ $encPrtyn }}" type="checkbox" onchange="toggleStatus(this)" {{ $prtyn->status ? 'checked' : '' }}>

                                                                <div class="spinner-border spinner-border-sm text-secondary d-none ms-1" role="status" style="margin-top: 2px"></div>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="data-pertanyaan" data-enc-pertanyaan="{{ $encPrtyn }}" data-json-pertanyaan="{{ $jsonPrtyn }}">
                                                                <button class="btn btn-sm btn-outline" type="button" onclick="edit(this)">
                                                                    <svg class="icon icon-tabler icon-tabler-edit" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                                        <path d="M16 5l3 3" />
                                                                    </svg>
                                                                    Ubah
                                                                </button>
                                                            </div>
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- Modal Ubah Pertanyaan -->
        <div class="modal modal-blur fade" id="modalEditPrtyn" role="dialog" aria-hidden="true" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Ubah Pertanyaan</h5>
                        <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('update.pertanyaan') }}" method="POST" onsubmit="$('#modalEditPrtyn #submitBtn button').prop('disabled', true)">
                        @csrf
                        @method('PUT')

                        <input id="encPrtyn" name="encPrtyn" type="hidden">

                        <div class="modal-body">
                            <div class="row mb-3 align-items-end">
                                <div class="col">
                                    <label class="form-label">Urut</label>
                                    <input class="form-control" id="urut" name="urut" type="number" min="1" required oninput="$(this).val(Math.max(1, $(this).val()))">
                                </div>
                            </div>

                            <div class="row mb-3 align-items-end">
                                <div class="col">
                                    <label class="form-label">Uraian</label>
                                    <textarea class="form-control" id="uraian" name="uraian" required></textarea>
                                </div>
                            </div>

                            <div class="row mb-3 align-items-end">
                                <div class="col">
                                    <label class="form-label">Jenis</label>
                                    <div class="form-selectgroup">
                                        <label class="form-selectgroup-item">
                                            <input class="form-selectgroup-input" id="jenis_pg" name="jenis" type="radio" value="{{ AngketMf::PIL_GANDA }}" required>
                                            <span class="form-selectgroup-label">
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
                                            </span>
                                        </label>
                                        <label class="form-selectgroup-item">
                                            <input class="form-selectgroup-input" id="jenis_esai" name="jenis" type="radio" value="{{ AngketMf::ISIAN_BEBAS }}" required>
                                            <span class="form-selectgroup-label">
                                                <svg class="icon icon-tabler icon-tabler-writing" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                    stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M20 17v-12c0 -1.121 -.879 -2 -2 -2s-2 .879 -2 2v12l2 2l2 -2z" />
                                                    <path d="M16 7h4" />
                                                    <path d="M18 19h-13a2 2 0 1 1 0 -4h4a2 2 0 1 0 0 -4h-3" />
                                                </svg>
                                                Isian Bebas
                                            </span>
                                        </label>

                                        {{-- <label class="form-selectgroup-item">
                                            <input type="radio" name="jenis" value="{{ AngketMf::ISIAN_CAMPUR }}" id="jenis_campur" class="form-selectgroup-input" required>
                                            <span class="form-selectgroup-label">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-forms" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
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
                                            </span>
                                        </label> --}}

                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3 align-items-end">
                                <div class="col">
                                    <label class="form-label">Status</label>
                                    <div class="d-flex align-items-center">
                                        <div class="form-check form-switch mb-0 me-2">
                                            <input class="form-check-input" id="status" name="status" type="checkbox" onchange="$('#modalEditPrtyn #statusBadge').html(this.checked ? badge_aktif : badge_non_aktif)">
                                        </div>
                                        <div id="statusBadge">
                                            <span class="badge bg-danger me-1"></span> Non Aktif
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button class="btn me-auto" data-bs-dismiss="modal" type="button">
                                Tutup
                            </button>
                            <button class="btn btn-primary" id="confirmationBtn" type="button" onclick="$('#modalEditPrtyn #submitBtn').removeClass('d-none'); $(this).addClass('d-none')">
                                Ubah Pertanyaan
                            </button>
                            <div class="d-flex flex-column d-none" id="submitBtn">
                                <span>Apakah anda yakin?</span>
                                <div>
                                    <button class="btn btn-success" type="submit">
                                        Yakin
                                    </button>
                                    <button class="btn btn-secondary" type="button" onclick="$('#modalEditPrtyn #confirmationBtn').removeClass('d-none'); $('#modalEditPrtyn #submitBtn').addClass('d-none')">
                                        Batal
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal Ubah Pertanyaan -->




        <!-- Modal Tambah Pertanyaan -->
        <div class="modal modal-blur fade" id="modalTambahPrtyn" role="dialog" aria-hidden="true" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Pertanyaan</h5>
                        <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('store.pertanyaan') }}" method="POST" onsubmit="$('#modalTambahPrtyn #submitBtn button').prop('disabled', true)">
                        @csrf

                        <div class="modal-body">
                            <div class="row mb-3 align-items-end">
                                <div class="col">
                                    <label class="form-label">Urut</label>
                                    <input class="form-control" name="urut" type="number" value="{{ $pertanyaan->where('status', AngketMf::AKTIF)->max('urut') + 1 }}" min="1" required oninput="$(this).val(Math.max(1, $(this).val()))">
                                </div>
                            </div>

                            <div class="row mb-3 align-items-end">
                                <div class="col">
                                    <label class="form-label">Uraian</label>
                                    <textarea class="form-control" name="uraian" required></textarea>
                                </div>
                            </div>

                            <div class="row mb-3 align-items-end">
                                <div class="col">
                                    <label class="form-label">Jenis</label>
                                    <div class="form-selectgroup">
                                        <label class="form-selectgroup-item">
                                            <input class="form-selectgroup-input" name="jenis" type="radio" value="{{ AngketMf::PIL_GANDA }}" checked required>
                                            <span class="form-selectgroup-label">
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
                                            </span>
                                        </label>
                                        <label class="form-selectgroup-item">
                                            <input class="form-selectgroup-input" name="jenis" type="radio" value="{{ AngketMf::ISIAN_BEBAS }}" required>
                                            <span class="form-selectgroup-label">
                                                <svg class="icon icon-tabler icon-tabler-writing" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                    stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M20 17v-12c0 -1.121 -.879 -2 -2 -2s-2 .879 -2 2v12l2 2l2 -2z" />
                                                    <path d="M16 7h4" />
                                                    <path d="M18 19h-13a2 2 0 1 1 0 -4h4a2 2 0 1 0 0 -4h-3" />
                                                </svg>
                                                Isian Bebas
                                            </span>
                                        </label>

                                        {{-- <label class="form-selectgroup-item">
                                            <input type="radio" name="jenis" value="{{ AngketMf::ISIAN_CAMPUR }}" class="form-selectgroup-input" required>
                                            <span class="form-selectgroup-label">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-forms" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
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
                                            </span>
                                        </label> --}}

                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3 align-items-end">
                                <div class="col">
                                    <label class="form-label">Status</label>
                                    <div class="d-flex align-items-center">
                                        <div class="form-check form-switch mb-0 me-2">
                                            <input class="form-check-input" name="status" type="checkbox" checked onchange="$('#modalTambahPrtyn #statusBadge').html(this.checked ? badge_aktif : badge_non_aktif)">
                                        </div>
                                        <div id="statusBadge">
                                            <span class="badge bg-success me-1"></span> Aktif
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>


                        <div class="modal-footer">
                            <button class="btn me-auto" data-bs-dismiss="modal" type="button">
                                Tutup
                            </button>
                            <button class="btn btn-primary" id="confirmationBtn" type="button" onclick="$('#modalTambahPrtyn #submitBtn').removeClass('d-none'); $(this).addClass('d-none')">
                                Simpan Pertanyaan
                            </button>
                            <div class="d-flex flex-column d-none" id="submitBtn">
                                <span>Apakah anda yakin?</span>
                                <div>
                                    <button class="btn btn-success" type="submit">
                                        Yakin
                                    </button>
                                    <button class="btn btn-secondary" type="button" onclick="$('#modalTambahPrtyn #confirmationBtn').removeClass('d-none'); $('#modalTambahPrtyn #submitBtn').addClass('d-none')">
                                        Batal
                                    </button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <!-- Modal Tambah Pertanyaan -->

    </div>

@endsection

@push('js')
    <!-- Datatables -->
    <script src="{{ asset('assets/libs/datatables/jquery.dataTables.min.js') }}"></script>
    <!-- Datatables Bootstrap 5 Theme -->
    <script src="{{ asset('assets/libs/datatables/dataTables.bootstrap5.min.js') }}"></script>
    <!-- Notiflix Notify -->
    <script src="{{ asset('assets/libs/notiflix/notiflix-notify-aio-3.2.6.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#tabelPertanyaan').DataTable({
                order: [] // <- Mematikan order saat inisialisasi
            });

        });

        // Template untuk badge status aktif dan non aktif
        const badge_aktif = `<span class="badge bg-success me-1"></span> Aktif`;
        const badge_non_aktif = `<span class="badge bg-danger me-1"></span> Non Aktif`;


        async function toggleStatus(checkbox) {
            // Dari checkbox yang di toggle
            $(checkbox)
                // Ambil TR yang jadi parent
                .closest('tr')
                // Cari div yang punya class 'status-prtyn'
                .find('div.status-prtyn')
                // Ubah isi nya sesuai dengan checkbox nya tercentang atau tidak
                .html(checkbox.checked ? badge_aktif : badge_non_aktif);


            // Tampilkan loading spinner
            const spinner = $(checkbox).siblings('div.spinner-border');
            spinner.removeClass('d-none');

            /* Ubah status di DB */
            let url = "{{ route('change-status.pertanyaan') }}";

            try {
                const response = await axios.put(url, {
                    encPrtyn: $(checkbox).data('enc-pertanyaan'),
                    status: checkbox.checked,
                }, {
                    retry: 2
                });

                const data = await response.data;

                if (data.status == 'success') {
                    // Tampilkan notif
                    Notiflix.Notify.success('Status berhasil diubah', {
                        position: 'right-bottom',
                        timeout: 1000,
                    });
                }

            } catch (error) {
                // Tampilkan notif
                Notiflix.Notify.failure('Maaf, ada kesalahan server', {
                    position: 'right-bottom',
                    timeout: 2000,
                });
            } finally {
                // Sembunyikan loading spinner
                spinner.addClass('d-none');
            }

        }


        function edit(btn) {
            // Ambil data pertanyaan di div yang memiliki class "data-pertanyaan" pada atribut "data-json-pertanyaan"
            const pertanyaan = $(btn).closest('div.data-pertanyaan').data('json-pertanyaan');

            // Set data pertanyaan ke input modal
            $('#urut').val(pertanyaan.urut);
            $('#uraian').val(pertanyaan.uraian);
            $(`input[type="radio"][name="jenis"][value="${pertanyaan.jenis}"]`).prop('checked', true);
            $('#status').prop('checked', parseInt(pertanyaan.status) ? true : false).trigger('change');

            // Ambil data enkripsi pertanyaan
            const encPertanyaan = $(btn).closest('div.data-pertanyaan').data('enc-pertanyaan');
            // Set ke input modal
            $('#encPrtyn').val(encPertanyaan);

            // Tutup submitBtn di modal edit
            $('#modalEditPrtyn #submitBtn').addClass('d-none');
            // Buka confirmationBtn di modal edit
            $('#modalEditPrtyn #confirmationBtn').removeClass('d-none');

            // Buka modal nya
            const modalEditPrtyn = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalEditPrtyn'));
            modalEditPrtyn.show();
        }
    </script>
@endpush
