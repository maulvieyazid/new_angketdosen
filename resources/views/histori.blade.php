@extends('layouts.app', ['navbar' => 'histori'])

@section('html_title', 'Histori Evaluasi Beasiswa')

@php
    use App\Models\KesimpulanBeasiswa;
    use App\Models\Terima;
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
                            Histori Evaluasi Beasiswa
                        </h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Page body -->
        <div class="page-body">
            <div class="container-xl">

                {{-- <div class="row">
                    <div class="col-5">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">Semester</h3>
                                <p class="card-subtitle">
                                    Silahkan pilih semester untuk melihat histori evaluasi
                                </p>
                                <div class="d-flex">
                                    <select class="form-select me-3">
                                        <option value="-" disabled selected>-- Pilih Semester --</option>
                                        <option>222</option>
                                        <option>221</option>
                                    </select>

                                    <button type="button" class="btn btn-primary me-2" onclick="showRowTabel()">
                                        Pilih
                                    </button>

                                    <div class="d-flex align-items-center d-none" id="spinner_pilih">
                                        <div class="spinner-border spinner-border-sm text-muted" role="status"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}


                <div class="row" id="row_tabel">
                    <div class="col">
                        <div class="card">
                            <div class="table-responsive">
                                <table class="table table-vcenter card-table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>NIM</th>
                                            <th {{-- style="width: 20%" --}}>Nama</th>
                                            <th>Semester</th>
                                            <th {{-- style="width: 20%" --}}>Beasiswa</th>
                                            {{-- <th>Ketentuan Terpenuhi</th> --}}
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($semuaPenerima as $penerima)
                                            <tr>
                                                <td>{{ $penerima->nim }}</td>
                                                <td>{{ $penerima->mahasiswa->nama ?? null }}</td>
                                                <td>{{ $penerima->smt }}</td>
                                                @php
                                                    // Mengambil nama relasi jenis beasiswa PMB yang sesuai
                                                    $jenis_beasiswa_pmb = Terima::getNamaRelasiJnsBeaPmb($penerima->pilihan_ke);
                                                @endphp
                                                <td>{{ $penerima->{$jenis_beasiswa_pmb}->nama ?? null }}</td>
                                                <td>
                                                    <span class="badge bg-cover">Menunggu <br> Evaluasi Keuangan</span>
                                                </td>
                                                <td>
                                                    @php
                                                        $routeDetil = route('detil-histori', [
                                                            'nim' => $penerima->nim,
                                                            'jns_beasiswa' => $penerima->{$jenis_beasiswa_pmb}->kd_jenis,
                                                            'smt' => $penerima->smt,
                                                        ]);
                                                    @endphp
                                                    <a href="{{ $routeDetil }}" class="btn btn-outline-primary w-100 btn-sm">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <path d="M9 11l3 3l8 -8"></path>
                                                            <path d="M20 12v6a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h9"></path>
                                                        </svg>
                                                        Detail
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach

                                        @foreach ($semuaKesimpulan as $kesimpulan)
                                            <tr>
                                                <td>{{ $kesimpulan->mhs_nim }}</td>
                                                <td>{{ $kesimpulan->mahasiswa->nama ?? null }}</td>
                                                <td>{{ $kesimpulan->smt }}</td>
                                                <td>{{ $kesimpulan->jenis_beasiswa_pmb->nama ?? null }}</td>
                                                <td>
                                                    @if ($kesimpulan->status == KesimpulanBeasiswa::LOLOS)
                                                        <span class="badge bg-green">Lolos</span>
                                                    @elseif ($kesimpulan->status == KesimpulanBeasiswa::TIDAK_LOLOS)
                                                        <span class="badge bg-danger-lt">Tidak Lolos</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @php
                                                        $routeDetil = route('detil-histori', [
                                                            'nim' => $kesimpulan->mhs_nim,
                                                            'kd_jns_bea_pmb' => $kesimpulan->jenis_beasiswa_pmb->kd_jenis,
                                                            'smt' => $kesimpulan->smt,
                                                        ]);
                                                    @endphp
                                                    <a href="{{ $routeDetil }}" class="btn btn-outline-primary w-100 btn-sm">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <path d="M9 11l3 3l8 -8"></path>
                                                            <path d="M20 12v6a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h9"></path>
                                                        </svg>
                                                        Detail
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
        </div>

    </div>

@endsection


@push('js')
@endpush
