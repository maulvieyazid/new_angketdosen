@extends('layouts.app', ['navbar' => 'evaluasi'])

@section('html_title', 'Detail Evaluasi Beasiswa')

@php
    use App\Models\Departemen;
    use App\Models\SyaratBeasiswa;
    use App\Models\SyaratPesertaBeasiswa;
    use App\Models\KesimpulanBeasiswa;
@endphp

@section('content')
    <div class="page-wrapper">

        <!-- Page header -->
        <div class="page-header d-print-none">
            <div class="container-xl">

                @include('layouts.alert')

                <div class="row g-2 align-items-center">
                    <div class="col">
                        <a href="{{ route('index-evaluasi-beasiswa') }}" class="btn btn-secondary mb-3">
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
                            Detail Evaluasi Beasiswa
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
                                <div class="card-title">Informasi Mahasiswa</div>
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
                                    <span class="ms-2">NIM</span> : <strong>{{ $penerima->nim }}</strong>
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
                                    <span class="ms-2">Nama</span> : <strong>{{ $penerima->nama }}</strong>
                                </div>
                                <div class="mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-school" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M22 9l-10 -4l-10 4l10 4l10 -4v6"></path>
                                        <path d="M6 10.6v5.4a6 3 0 0 0 12 0v-5.4"></path>
                                    </svg>
                                    <span class="ms-2">Beasiswa</span> : <strong>{{ $penerima->{$jenis_beasiswa_pmb}->nama ?? null }}</strong>
                                </div>
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
                                    <span class="ms-2">Semester</span> : <strong>{{ session('semester') }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row mt-2">
                    <div class="col-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="subheader">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-checkup-list" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2"></path>
                                        <path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z"></path>
                                        <path d="M9 14h.01"></path>
                                        <path d="M9 17h.01"></path>
                                        <path d="M12 16l1 1l3 -3"></path>
                                    </svg>
                                    Status Mahasiswa Saat Ini
                                </div>
                                <div class="h3 m-0">
                                    {{ $hismf->nama_status }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="subheader">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-stars" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path
                                            d="M17.8 19.817l-2.172 1.138a.392 .392 0 0 1 -.568 -.41l.415 -2.411l-1.757 -1.707a.389 .389 0 0 1 .217 -.665l2.428 -.352l1.086 -2.193a.392 .392 0 0 1 .702 0l1.086 2.193l2.428 .352a.39 .39 0 0 1 .217 .665l-1.757 1.707l.414 2.41a.39 .39 0 0 1 -.567 .411l-2.172 -1.138z">
                                        </path>
                                        <path
                                            d="M6.2 19.817l-2.172 1.138a.392 .392 0 0 1 -.568 -.41l.415 -2.411l-1.757 -1.707a.389 .389 0 0 1 .217 -.665l2.428 -.352l1.086 -2.193a.392 .392 0 0 1 .702 0l1.086 2.193l2.428 .352a.39 .39 0 0 1 .217 .665l-1.757 1.707l.414 2.41a.39 .39 0 0 1 -.567 .411l-2.172 -1.138z">
                                        </path>
                                        <path
                                            d="M12 9.817l-2.172 1.138a.392 .392 0 0 1 -.568 -.41l.415 -2.411l-1.757 -1.707a.389 .389 0 0 1 .217 -.665l2.428 -.352l1.086 -2.193a.392 .392 0 0 1 .702 0l1.086 2.193l2.428 .352a.39 .39 0 0 1 .217 .665l-1.757 1.707l.414 2.41a.39 .39 0 0 1 -.567 .411l-2.172 -1.138z">
                                        </path>
                                    </svg>
                                    IPS (Indeks Prestasi Semester)
                                </div>
                                <div class="h3 m-0">
                                    {{ $hismf->ips ?? 0 }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="subheader">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-award" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M12 9m-6 0a6 6 0 1 0 12 0a6 6 0 1 0 -12 0"></path>
                                        <path d="M12 15l3.4 5.89l1.598 -3.233l3.598 .232l-3.4 -5.889"></path>
                                        <path d="M6.802 12l-3.4 5.89l3.598 -.233l1.598 3.232l3.4 -5.889"></path>
                                    </svg>
                                    SSKM (Standar Soft Skill Kegiatan Mahasiswa)
                                </div>
                                <div class="h3 m-0">
                                    {{ $sskm }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Evaluasi Bagian Yang LOGIN -->
                <form action="{{ route('simpan-detil-evaluasi') }}" method="POST" id="formEvaluasi">
                    <input type="hidden" name="status_kesimpulan" id="status_kesimpulan">
                    <input type="hidden" name="nim" id="nim" value="{{ $penerima->nim }}">
                    <input type="hidden" name="kd_jns_bea_pmb" id="kd_jns_bea_pmb" value="{{ $penerima->{$jenis_beasiswa_pmb}->kd_jenis ?? null }}">
                    <input type="hidden" name="smt" id="smt" value="{{ session('semester') }}">

                    @csrf

                    @php
                        // Ambil nama bagian dari user yg login
                        $nama_bagian_user = auth()->user()->departemen->nama ?? null;
                    @endphp

                    <div class="row mt-3">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <div class="">
                                        <label class="form-label">
                                            Evaluasi Bagian {{ ucwords(strtolower($nama_bagian_user)) }}
                                        </label>

                                        <div class="text-muted mb-3">
                                            Silahkan centang ketentuan-ketentuan dibawah ini bila penerima beasiswa memenuhi ketentuan.
                                            <br>
                                            Bila penerima beasiswa tidak memenuhi ketentuan, maka tidak perlu dicentang.
                                        </div>

                                        <div class="form-selectgroup form-selectgroup-boxes d-flex flex-column">
                                            @php
                                                // Ambil syarat beasiswa yang bagian_validasi nya sesuai dengan bagian user yang login
                                                $syaratUser = $semuaSyarat->where('bagian_validasi', auth()->user()->bagian);
                                            @endphp

                                            @foreach ($syaratUser as $syarat)
                                                @php
                                                    $checked = null;

                                                    // Cek apakah jenis_beasiswa ADA di dalam array autocheck
                                                    $jnsbeaExist = array_key_exists($syarat->jenis_beasiswa, SyaratBeasiswa::AUTOCHECK);

                                                    // Kalo ada
                                                    if ($jnsbeaExist) {
                                                        // Maka masuk kedalam array autocheck yang key nya adalah jenis_beasiswa
                                                        // lalu cek apakah kd_syarat nya ADA juga
                                                        $kdsyrtExist = array_key_exists($syarat->kd_syarat, SyaratBeasiswa::AUTOCHECK[$syarat->jenis_beasiswa]);

                                                        // Kalo ada, maka ambil penanda nya
                                                        $penanda = $kdsyrtExist ? SyaratBeasiswa::AUTOCHECK[$syarat->jenis_beasiswa][$syarat->kd_syarat] : null;

                                                        // Kalo penanda nya adalah IPS, maka cek IPS nya mhs
                                                        if ($penanda == SyaratBeasiswa::IPS) {
                                                            $ips = $hismf->ips ?? 0;
                                                            $checked = $ips >= $syarat->nil_min ? 'checked' : null;
                                                        }

                                                        // Kalo penanda nya adalah STSKULIAH, maka cek status kuliah mhs
                                                        if ($penanda == SyaratBeasiswa::STSKULIAH) {
                                                            $status = $hismf->nama_status ?? null;
                                                            $checked = strtoupper($status) == 'AKTIF' ? 'checked' : null;
                                                        }
                                                    }
                                                @endphp

                                                <label class="form-selectgroup-item flex-fill">
                                                    <input type="checkbox" name="syarat_beasiswa[]" value="{{ $syarat->kd_syarat }}" class="form-selectgroup-input" {{ $checked }}>
                                                    <div class="form-selectgroup-label d-flex align-items-center p-3">
                                                        <div class="me-3">
                                                            <span class="form-selectgroup-check"></span>
                                                        </div>
                                                        <div class="form-selectgroup-label-content d-flex align-items-center">
                                                            <div class="font-weight-medium">
                                                                {{ $syarat->nm_syarat }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </label>
                                            @endforeach

                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    @if ($syaratUser->count() > 0)
                                        <button type="button" class="btn btn-success" onclick="simpan()">
                                            Simpan
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- Evaluasi Bagian Yang LOGIN -->



                <!-- Evaluasi Bagian Lainnya -->
                @php
                    // Ambil semua syarat yang bagian_validasi nya bukan bagian nya user yg login
                    $syaratLain = $semuaSyarat->where('bagian_validasi', '!=', auth()->user()->bagian);

                    // Lakukan grouping terhadap bagian_validasinya
                    $syaratLain = $syaratLain->groupBy('bagian_validasi');
                @endphp

                {{-- Looping accordion di bawah ini berdasarkan syarat yang sudah digrouping bagian_validasi nya --}}
                @foreach ($syaratLain as $kd_bagian => $syarat)
                    <div class="row mt-3">
                        <div class="col">
                            <div class="card">
                                <div class="accordion" id="accordion-example">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading-4">
                                            @php
                                                // Ambil nama bagian dari db
                                                $nama_bagian = Departemen::where('kode', $kd_bagian)->first()->nama ?? null;
                                                // Kalo gk null, maka tambahkan string "Bagian", lalu ubah agar kapital di tiap huruf
                                                $nama_bagian = $nama_bagian ? 'Bagian ' . ucfirst(strtolower($nama_bagian)) : 'Lainnya';
                                            @endphp
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-4" aria-expanded="false">
                                                Evaluasi {{ $nama_bagian }}
                                            </button>
                                        </h2>
                                        <div id="collapse-4" class="accordion-collapse collapse" data-bs-parent="#accordion-example">
                                            <div class="accordion-body pt-0">
                                                <div class="">
                                                    <div class="form-selectgroup form-selectgroup-boxes d-flex flex-column">

                                                        @foreach ($syarat as $syt)
                                                            @php
                                                                // Ambil nilai status dari syarat peserta beasiswa jika ada
                                                                // Kalau tidak ada, maka kembalikan null
                                                                $syarat_peserta_beasiswa = $penerima->syarat_peserta->where('kd_syarat', $syt->kd_syarat)->first()->status ?? null;

                                                                // Kalau status nya adalah lolos, maka checkbox nya tercentang
                                                                $checked = $syarat_peserta_beasiswa == SyaratPesertaBeasiswa::LOLOS ? 'checked' : '';
                                                            @endphp

                                                            <label class="form-selectgroup-item flex-fill">

                                                                <input type="checkbox" value="{{ $syt->kd_syarat }}" class="form-selectgroup-input" name="syarat_lain[]" disabled {{ $checked }}>

                                                                <div class="form-selectgroup-label d-flex align-items-center p-3" style="border-color: transparent; cursor: default;">
                                                                    <div class="me-3">
                                                                        <span class="form-selectgroup-check"></span>
                                                                    </div>
                                                                    <div class="form-selectgroup-label-content d-flex align-items-center">
                                                                        <div class="font-weight-medium text-muted">
                                                                            {{ $syt->nm_syarat }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </label>
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
                @endforeach

                <!-- Evaluasi Bagian Lainnya -->


            </div>
        </div>

    </div>

@endsection

@push('js')
    <script>
        function simpan() {
            // Ambil semua checkbox yang beratribut name="syarat_beasiswa[]"
            let checkboxes = document.querySelectorAll('input[name="syarat_beasiswa[]"]');

            // Periksa apakah semua checkbox nya tercentang
            let semuaTercentang = [...checkboxes].every(checkbox => checkbox.checked);

            // Kalo yang login adalah Bagian Keuangan, maka cek juga checkbox yang beratribut name="syarat_lain[]"
            // Bagian Keuangan adalah gerbang terakhir pengecekan seluruh evaluasi
            // Saat Bagian Keuangan menyimpan evaluasi, maka aplikasi akan menyimpan data Syarat Peserta Beasiswa dan Kesimpulan Beasiswa
            // selain Bagian Keuangan, maka aplikasi hanya menyimpan data Syarat Peserta Beasiswa saja
            @if (auth()->user()->bagian == Departemen::KEUANGAN)
                // Ambil semua checkbox yang beratribut name="syarat_lain[]"
                let checkboxes_lain = document.querySelectorAll('input[name="syarat_lain[]"]');

                // Periksa apakah semua checkbox nya tercentang
                let semuaLainTercentang = [...checkboxes_lain].every(checkbox => checkbox.checked);

                if (!semuaLainTercentang) {
                    kesimpulanBuruk();
                    return;
                }
            @endif

            if (!semuaTercentang) {
                kesimpulanBuruk();
                return;
            }

            kesimpulanBaik();

        }

        async function kesimpulanBaik() {
            const text = `Evaluasi yang sudah disimpan akan dianggap <span class="fw-bolder">FINAL</span> dan tidak bisa diubah kembali.`;

            const {
                value
            } = await Swal.fire({
                title: 'Anda yakin?',
                html: text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                // cancelButtonColor: '#d33',
                cancelButtonText: 'Batal',
                confirmButtonText: 'Ya, simpan'
            })

            if (!value) return;

            document.getElementById('status_kesimpulan').value = '{{ KesimpulanBeasiswa::LOLOS }}';
            document.getElementById('formEvaluasi').submit();
        }

        async function kesimpulanBuruk() {
            let judul = `
                Ada evaluasi yang <span class="fw-bolder">BELUM TERCENTANG</span>.
                <br>
                Mahasiswa ybs <span class="fw-bolder">TIDAK AKAN LOLOS</span> dan beasiswanya akan <span class="fw-bolder">DICABUT</span>.
                <br>
                Apakah anda yakin ingin melanjutkan?
            `;

            const {
                value
            } = await Swal.fire({
                title: 'PERHATIAN!',
                html: judul,
                icon: 'warning',
                showCancelButton: true,
                // confirmButtonColor: '#3085d6',
                // cancelButtonColor: '#d33',
                confirmButtonColor: '#d33',
                cancelButtonText: 'Batal',
                confirmButtonText: 'Ya, lanjut'
            })

            if (!value) return

            // Teks yang harus diinputkan oleh user untuk melanjutkan
            const passcode = '{{ $penerima->nim }}/{{ $penerima->nama }}';

            judul = `
                <span>Silahkan masukkan teks dibawah ini untuk lanjut menyimpan evaluasi.</span>
                <br>
                <br>
                <span class='fw-bolder'>${passcode}</span>
            `;

            const {
                value: lanjutkan
            } = await Swal.fire({
                html: judul,
                input: 'text',
                confirmButtonColor: '#d33',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonText: 'Simpan',
                inputValidator: (value) => {
                    // Kalo isian nya kosong
                    if (!value) return 'Isikan teks diatas untuk melanjutkan.'
                    // Kalo isian nya nggak sama
                    if (value != passcode) return 'Teks tidak sesuai. Mohon perhatikan besar dan kecil nya huruf, spasi, atau tanda baca apapun.';
                }
            })

            if (!lanjutkan) return

            document.getElementById('status_kesimpulan').value = '{{ KesimpulanBeasiswa::TIDAK_LOLOS }}';
            document.getElementById('formEvaluasi').submit();
        }
    </script>
@endpush
