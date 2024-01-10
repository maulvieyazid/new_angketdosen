@extends('layouts.app', ['navbar' => 'hasil-angket'])

@section('html_title', 'Detail Hasil Angket')

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
                        <a href="{{ route('index.hasil-angket', ['smt' => $smt]) }}" class="btn btn-secondary mb-3">
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
                                    <span class="ms-2">Semester</span> : <strong>{{ $smt }}</strong>
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
                                    <span class="ms-2">NIK</span> : <strong>{{ $dosen->nik }}</strong>
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
                                    <span class="ms-2">Nama</span> : <strong>{{ $dosen->nama_lengkap }}</strong>
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
                                                    @foreach ($hasilPerKelas as $hasil)
                                                        <tr>
                                                            <td class="text-center">
                                                                {{ $loop->iteration }}.
                                                            </td>
                                                            <td>
                                                                {{ $hasil->prodiAngket->alias ?? null }} ({{ $hasil->prodi }})
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $hasil->kode_mk }}
                                                            </td>
                                                            <td>
                                                                {{ $hasil->nama_mk }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $hasil->kelas }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $hasil->nilai }}
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

                                            @foreach ($hasilPerKelas as $hpk)
                                                <div>
                                                    <table class="table mb-0 table-warning">
                                                        <tbody>
                                                            <tr>
                                                                <td class="w-0">Kode MK</td>
                                                                <td class="w-0">:</td>
                                                                <td class="fw-bold">{{ $hpk->kode_mk }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Matakuliah</td>
                                                                <td>:</td>
                                                                <td class="fw-bold">{{ $hpk->nama_mk }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Prodi</td>
                                                                <td>:</td>
                                                                <td class="fw-bold">
                                                                    {{ $hpk->prodiAngket->alias ?? null }} ({{ $hpk->prodi }})
                                                                </td>
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

                                                        @php
                                                            $no = 1;

                                                            // Lakukan filter pada hasil per kelas per pertanyaan
                                                            // Ambil yang kelas nya sesuai dengan looping kelas saat ini
                                                            $hpkpp = $hasilPerKelasPerPertanyaan
                                                                ->where('kode_mk', $hpk->kode_mk)
                                                                ->where('kelas', $hpk->kelas)
                                                                ->where('prodi', $hpk->prodi);

                                                            // Pisahkan antara yang jenis nya pilihan ganda dan isian bebas
                                                            $pilihanGanda = $hpkpp->where('pertanyaan.jenis', AngketMf::PIL_GANDA)->sortBy('kd_angket');

                                                            $isianBebas = $hpkpp->where('pertanyaan.jenis', AngketMf::ISIAN_BEBAS)->sortBy('kd_angket');

                                                            // Ambil nilai rata-rata dari pilihan ganda lalu bulatkan dengan presisi dua angka dibelakang koma
                                                            $nilRataRata = $hpkpp->sum('nilai') / $hpkpp->whereNotNull('nilai')->count();
                                                            $nilRataRata = round($nilRataRata, 2);
                                                        @endphp

                                                        <tbody>
                                                            @foreach ($pilihanGanda as $pilgan)
                                                                <tr>
                                                                    <td class="text-center">
                                                                        {{ $no++ }}.
                                                                    </td>
                                                                    <td>
                                                                        {{ $pilgan->pertanyaan->uraian ?? null }}
                                                                    </td>
                                                                    <td class="text-center">
                                                                        {{ $pilgan->nilai }}
                                                                    </td>
                                                                </tr>
                                                            @endforeach

                                                            <tr class="table-secondary">
                                                                <td colspan="2" class="text-end">
                                                                    <span class="fw-bold">Nilai Rata-rata</span>
                                                                </td>
                                                                <td class="text-center fw-bold">
                                                                    {{ $nilRataRata }}
                                                                </td>
                                                            </tr>

                                                        </tbody>
                                                    </table>

                                                    @foreach ($isianBebas as $esai)
                                                        <div class="fw-bold">
                                                            {{ $no++ }}. {{ $esai->pertanyaan->uraian ?? null }}
                                                        </div>

                                                        @php
                                                            // Lakukan filter pada semua jawaban esai
                                                            // Ambil yang esai nya sesuai dengan looping esai saat ini
                                                            $fltr_semuaJwbnEsai = $semuaJwbnEsai
                                                                ->where('kode_mk', $esai->kode_mk)
                                                                ->where('kelas', $esai->kelas)
                                                                ->where('prodi', $esai->prodi)
                                                                ->where('kd_angket', $esai->kd_angket);
                                                        @endphp

                                                        <table class="table table-bordered mt-2 border-0">
                                                            @foreach ($fltr_semuaJwbnEsai as $sje)
                                                                <tr>
                                                                    <td class="py-2">
                                                                        {{ $sje->saran }}
                                                                    </td>
                                                                </tr>
                                                            @endforeach

                                                            <!-- Kalo tidak ada jawaban esai nya, maka tampilkan 'Tidak ada jawaban' -->
                                                            {{ !$fltr_semuaJwbnEsai->count() ? 'Tidak ada jawaban' : null }}
                                                        </table>
                                                    @endforeach

                                                    <hr class="border-2 opacity-50 mt-7">

                                                </div>
                                            @endforeach


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
