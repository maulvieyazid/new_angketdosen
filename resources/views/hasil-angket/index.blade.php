@extends('layouts.app', ['navbar' => 'hasil-angket'])

@section('html_title', 'Hasil Angket')

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
                                    <select class="form-select me-2">
                                        <option>231</option>
                                        <option>222</option>
                                        <option>221</option>
                                    </select>
                                    <button type="button" class="btn btn-primary">
                                        Tampilkan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


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
                                            <tr>
                                                <td class="text-center">1</td>
                                                <td class="text-center">980249</td>
                                                <td class="">Erwin Sutomo</td>
                                                <td>
                                                    <a href="" class="btn btn-outline-primary w-100 btn-sm">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <path d="M9 11l3 3l8 -8"></path>
                                                            <path d="M20 12v6a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h9"></path>
                                                        </svg>
                                                        Tampilkan
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">2</td>
                                                <td class="text-center">209131</td>
                                                <td class="">Desita Rizky Amelia Kusumaningtyas</td>
                                                <td>
                                                    <a href="" class="btn btn-outline-primary w-100 btn-sm">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <path d="M9 11l3 3l8 -8"></path>
                                                            <path d="M20 12v6a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h9"></path>
                                                        </svg>
                                                        Tampilkan
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">3</td>
                                                <td class="text-center">180880</td>
                                                <td class="">I Gusti Ngurah Alit Widana Putra</td>
                                                <td>
                                                    <a href="" class="btn btn-outline-primary w-100 btn-sm">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <path d="M9 11l3 3l8 -8"></path>
                                                            <path d="M20 12v6a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h9"></path>
                                                        </svg>
                                                        Tampilkan
                                                    </a>
                                                </td>
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

    </div>

@endsection
