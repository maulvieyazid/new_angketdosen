@extends('layouts.app', ['navbar' => 'kategori'])

@section('html_title', 'Maintenance Kategori')

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
                            Maintenance Kategori Pertanyaan
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
                                    Anda tidak bisa melakukan perubahan pada kategori pertanyaan.
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
                                        <button class="btn btn-primary me-1" data-bs-toggle="modal" data-bs-target="#modalTambahKtgr">
                                            + Kategori
                                        </button>
                                    </div>
                                @endif

                                <div class="table-responsive">
                                    <table class="table table-striped table-hover table-bordered" id="tabelKategori">
                                        <thead>
                                            <tr>
                                                <th class="text-center bg-primary-subtle w-0">No</th>
                                                <th class="text-center bg-primary-subtle">Nama Kategori</th>
                                                <!-- Tampilkan ini kalau bukan di periode angket dosen -->
                                                @if (!$inPeriodeAngket)
                                                    <th class="text-center bg-primary-subtle w-0">Aksi</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($semuaKategori as $ktgr)
                                                @php
                                                    // Bentuk JSON nya masing2 kategori
                                                    $jsonKtgr = $ktgr->toJson();

                                                    // Enkripsi dari JSON
                                                    $encKtgr = Crypt::encryptString($jsonKtgr);
                                                @endphp

                                                <tr>
                                                    <td class="text-center">
                                                        {{ $loop->iteration }}
                                                    </td>

                                                    <td>
                                                        {{ $ktgr->nama_kategori }}
                                                    </td>

                                                    <!-- Tampilkan ini kalau bukan di periode angket dosen -->
                                                    @if (!$inPeriodeAngket)
                                                        <td class="text-center">
                                                            <div class="data-kategori d-flex" data-enc-kategori="{{ $encKtgr }}" data-json-kategori="{{ $jsonKtgr }}">
                                                                <button class="btn btn-sm btn-outline" type="button" onclick="edit(this)">
                                                                    <svg class="icon icon-tabler icon-tabler-edit" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                                        stroke-linecap="round" stroke-linejoin="round">
                                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                                        <path d="M16 5l3 3" />
                                                                    </svg>
                                                                    Ubah
                                                                </button>

                                                                <!-- Tampilkan btn hapus jika tidak terikat pertanyaan -->
                                                                @if (!$ktgr->terikat_pertanyaan)
                                                                    <button class="btn btn-sm btn-danger ms-3 btn-icon border-0" type="button" onclick="hapus(this)">
                                                                        <svg class="icon icon-tabler icon-tabler-trash" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                            <path d="M4 7l16 0" />
                                                                            <path d="M10 11l0 6" />
                                                                            <path d="M14 11l0 6" />
                                                                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                                            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                                        </svg>
                                                                        <form action="{{ route('destroy.kategori') }}" method="POST">
                                                                            @csrf
                                                                            @method('DELETE')

                                                                            <input name="encKtgr" type="hidden" value="{{ $encKtgr }}">
                                                                        </form>
                                                                    </button>
                                                                @endif
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



        <!-- Modal Ubah Kategori -->
        <div class="modal modal-blur fade" id="modalEditKtgr" role="dialog" aria-hidden="true" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Ubah Kategori</h5>
                        <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('update.kategori') }}" method="POST" onsubmit="$('#modalEditKtgr #submitBtn button').prop('disabled', true)">
                        @csrf
                        @method('PUT')

                        <input id="encKtgr" name="encKtgr" type="hidden">

                        <div class="modal-body">
                            <div class="row mb-3 align-items-end">
                                <div class="col">
                                    <label class="form-label">Nama Kategori</label>
                                    <input class="form-control" id="nama_kategori" name="nama_kategori" type="text">
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button class="btn me-auto" data-bs-dismiss="modal" type="button">
                                Tutup
                            </button>
                            <button class="btn btn-primary" id="confirmationBtn" type="button" onclick="$('#modalEditKtgr #submitBtn').removeClass('d-none'); $(this).addClass('d-none')">
                                Ubah Kategori
                            </button>
                            <div class="d-flex flex-column d-none" id="submitBtn">
                                <span>Apakah anda yakin?</span>
                                <div>
                                    <button class="btn btn-success" type="submit">
                                        Yakin
                                    </button>
                                    <button class="btn btn-secondary" type="button" onclick="$('#modalEditKtgr #confirmationBtn').removeClass('d-none'); $('#modalEditKtgr #submitBtn').addClass('d-none')">
                                        Batal
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal Ubah Kategori -->




        <!-- Modal Tambah Kategori -->
        <div class="modal modal-blur fade" id="modalTambahKtgr" role="dialog" aria-hidden="true" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Kategori</h5>
                        <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('store.kategori') }}" method="POST" onsubmit="$('#modalTambahKtgr #submitBtn button').prop('disabled', true)">
                        @csrf

                        <div class="modal-body">
                            <div class="row mb-3 align-items-end">
                                <div class="col">
                                    <label class="form-label">Nama Kategori</label>
                                    <input class="form-control" id="nama_kategori" name="nama_kategori" type="text">
                                </div>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button class="btn me-auto" data-bs-dismiss="modal" type="button">
                                Tutup
                            </button>
                            <button class="btn btn-primary" id="confirmationBtn" type="button" onclick="$('#modalTambahKtgr #submitBtn').removeClass('d-none'); $(this).addClass('d-none')">
                                Simpan Kategori
                            </button>
                            <div class="d-flex flex-column d-none" id="submitBtn">
                                <span>Apakah anda yakin?</span>
                                <div>
                                    <button class="btn btn-success" type="submit">
                                        Yakin
                                    </button>
                                    <button class="btn btn-secondary" type="button" onclick="$('#modalTambahKtgr #confirmationBtn').removeClass('d-none'); $('#modalTambahKtgr #submitBtn').addClass('d-none')">
                                        Batal
                                    </button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <!-- Modal Tambah Kategori -->

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
            $('#tabelKategori').DataTable({
                order: [] // <- Mematikan order saat inisialisasi
            });

        });

        async function hapus(btn) {
            // Ambil data kategori di div yang memiliki class "data-kategori" pada atribut "data-json-kategori"
            const kategori = $(btn).closest('div.data-kategori').data('json-kategori');

            const {
                value
            } = await Swal.fire({
                title: 'Peringatan?',
                text: 'Apkaah anda yakin ingin menghapus kategori ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonText: 'Batal',
                confirmButtonText: 'Ya, Hapus'
            })

            if (!value) return;

            // Submit form yang ada di btn Hapus
            $(btn).find('form').submit();
        }


        function edit(btn) {
            // Ambil data kategori di div yang memiliki class "data-kategori" pada atribut "data-json-kategori"
            const kategori = $(btn).closest('div.data-kategori').data('json-kategori');

            // Set data kategori ke input modal
            $('#nama_kategori').val(kategori.nama_kategori);

            // Ambil data enkripsi kategori
            const encKategori = $(btn).closest('div.data-kategori').data('enc-kategori');
            // Set ke input modal
            $('#encKtgr').val(encKategori);

            // Tutup submitBtn di modal edit
            $('#modalEditKtgr #submitBtn').addClass('d-none');
            // Buka confirmationBtn di modal edit
            $('#modalEditKtgr #confirmationBtn').removeClass('d-none');

            // Buka modal nya
            const modalEditKtgr = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalEditKtgr'));
            modalEditKtgr.show();
        }
    </script>
@endpush
