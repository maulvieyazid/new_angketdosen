@extends('layouts.app', ['navbar' => 'hasil-angket'])

@section('html_title', 'Detail Hasil Angket')


@section('content')
    <div class="page-wrapper">

        <!-- Page header -->
        <div class="page-header d-print-none">
            <div class="container-xl">

                @include('layouts.alert')

                <div class="row g-2 align-items-center">
                    <div class="col">
                        <a href="{{ route('index.hasil-angket') }}" class="btn btn-secondary mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-narrow-left" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M5 12l14 0"></path>
                                <path d="M5 12l4 4"></path>
                                <path d="M5 12l4 -4"></path>
                            </svg>
                            Kembali
                        </a>

                        <h2 class="page-title">
                            Detail Hasil Angket
                        </h2>

                    </div>
                </div>
            </div>
        </div>

        <!-- Page body -->
        <div class="page-body">
            <div class="container-xl">

                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title">Informasi Dosen</div>
                                <div class="mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z"></path>
                                        <path d="M16 3v4"></path>
                                        <path d="M8 3v4"></path>
                                        <path d="M4 11h16"></path>
                                        <path d="M11 15h1"></path>
                                        <path d="M12 15v3"></path>
                                    </svg>
                                    <span class="ms-2">Semester</span> : <strong>231</strong>
                                </div>
                                <div class="mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-id" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M3 4m0 3a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v10a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3z"></path>
                                        <path d="M9 10m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                        <path d="M15 8l2 0"></path>
                                        <path d="M15 12l2 0"></path>
                                        <path d="M7 16l10 0"></path>
                                    </svg>
                                    <span class="ms-2">NIK</span> : <strong>980249</strong>
                                </div>
                                <div class="mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-id-badge-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M7 12h3v4h-3z"></path>
                                        <path d="M10 6h-6a1 1 0 0 0 -1 1v12a1 1 0 0 0 1 1h16a1 1 0 0 0 1 -1v-12a1 1 0 0 0 -1 -1h-6"></path>
                                        <path d="M10 3m0 1a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v3a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1z"></path>
                                        <path d="M14 16h2"></path>
                                        <path d="M14 12h4"></path>
                                    </svg>
                                    <span class="ms-2">Nama</span> : <strong>Erwin Sutomo, S.Kom., M.Eng., CITSM</strong>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>




                <div class="row mt-3">
                    <div class="col">
                        <div class="card">
                            <div class="accordion" id="accrdn-kelas">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading-1">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-kelas" aria-expanded="true">
                                            Hasil Angket Per Kelas
                                        </button>
                                    </h2>
                                    <div id="collapse-kelas" class="accordion-collapse collapse show" data-bs-parent="#accrdn-kelas">
                                        <div class="accordion-body pt-0">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center bg-primary-subtle" style="width: 5%">
                                                            No.
                                                        </th>
                                                        <th class="text-center bg-primary-subtle">
                                                            Prodi
                                                        </th>
                                                        <th class="text-center bg-primary-subtle">
                                                            Kode MK
                                                        </th>
                                                        <th class="text-center bg-primary-subtle">
                                                            Matakuliah
                                                        </th>
                                                        <th class="text-center bg-primary-subtle">
                                                            Kelas
                                                        </th>
                                                        <th class="text-center bg-primary-subtle">
                                                            Nilai
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-center">1.</td>
                                                        <td>S1-SI (41010)</td>
                                                        <td class="text-center">36583</td>
                                                        <td>Manajemen Layanan Teknologi Informasi</td>
                                                        <td class="text-center">P1</td>
                                                        <td class="text-center">4</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="row mt-3">
                    <div class="col">
                        <div class="card">
                            <div class="accordion" id="accrdn-kls-prtyn">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading-1">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-kls-prtyn" aria-expanded="true">
                                            Hasil Angket Per Kelas Per Pertanyaan
                                        </button>
                                    </h2>
                                    <div id="collapse-kls-prtyn" class="accordion-collapse collapse show" data-bs-parent="#accrdn-kls-prtyn">
                                        <div class="accordion-body pt-0">

                                            <div>
                                                <table class="table mb-0 table-warning">
                                                    <tbody>
                                                        <tr>
                                                            <td style="width: 0">Kode MK</td>
                                                            <td style="width: 0">:</td>
                                                            <td class="fw-bold">36589</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Matakuliah</td>
                                                            <td>:</td>
                                                            <td class="fw-bold">Manajemen Layanan Teknologi Informasi</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Prodi</td>
                                                            <td>:</td>
                                                            <td class="fw-bold">S1-S1 (41010)</td>
                                                        </tr>
                                                    </tbody>
                                                </table>


                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center bg-primary-subtle" style="width: 5%">
                                                                No.
                                                            </th>
                                                            <th class="text-center bg-primary-subtle">
                                                                Pertanyaan
                                                            </th>
                                                            <th class="text-center bg-primary-subtle">
                                                                Nilai
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="text-center">1.</td>
                                                            <td>
                                                                Dosen menyampaikan tujuan pembelajaran setiap awal pembelajaran dengan jelas
                                                            </td>
                                                            <td class="text-center">4</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center">2.</td>
                                                            <td>
                                                                Dosen menyampaikan materi kuliah dengan jelas dan sistematis
                                                            </td>
                                                            <td class="text-center">4</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center">3.</td>
                                                            <td>
                                                                Dosen memberikan contoh-contoh yang membantu pemahaman terhadap materi kuliah
                                                            </td>
                                                            <td class="text-center">4</td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr class="table-secondary">
                                                            <td colspan="2" class="text-end">
                                                                <span class="fw-bold">Nilai Rata-rata</span>
                                                            </td>
                                                            <td class="text-center fw-bold">4</td>
                                                        </tr>
                                                    </tfoot>
                                                </table>

                                                <div class="fw-bold">
                                                    15. Keluhan untuk dosen pembina mata kuliah (*optional)
                                                </div>
                                                <table class="table table-bordered mt-2 border-0">
                                                    <tr>
                                                        <td class="py-2">Bagus pengajarannya</td>
                                                    </tr>
                                                </table>
                                            </div>

                                            <hr class="border-2 opacity-50 my-7">


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </div>

    </div>

@endsection

@push('js')
@endpush
