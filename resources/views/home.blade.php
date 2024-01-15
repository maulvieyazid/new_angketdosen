@extends('layouts.app', ['navbar' => 'home'])

@section('html_title', 'Home')

@push('css')
    <!-- Select2 -->
    <link href="{{ asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" />
    <!-- Select2 Bootstrap 5 Theme -->
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
                            Selamat Datang
                        </h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Page body -->
        <div class="page-body">
            <div class="container-xl">

                <!-- Chart Rata-Rata Nilai Angket Anda Per Semester -->
                <div class="row mb-4">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <h3 class="card-title">Rata-Rata Nilai Angket Anda Per Semester</h3>
                                    <div class="ms-auto">
                                        <div class="d-flex align-items-center">
                                            <!-- Select Dari Semester -->
                                            <select class="form-select form-select-sm pilih-smt" id="dariSmt-c1" style="width: 80px" onchange="updateChartAvgNilaiPerSmt(this.value, $('#hinggaSmt-c1').val())">
                                                @foreach ($chart_UL->semuaSmt as $smt)
                                                    <option value="{{ $smt }}" {{ $smt == $chart_UL->dari ? 'selected' : null }}>
                                                        {{ $smt }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            <span class="mx-2">s/d</span>

                                            <!-- Select Hingga Semester -->
                                            <select class="form-select form-select-sm pilih-smt" id="hinggaSmt-c1" style="width: 80px" onchange="updateChartAvgNilaiPerSmt($('#dariSmt-c1').val(), this.value)">
                                                @foreach ($chart_UL->semuaSmt as $smt)
                                                    <option value="{{ $smt }}" {{ $smt == $chart_UL->hingga ? 'selected' : null }}>
                                                        {{ $smt }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div id="chartAvgNilaiPerSmt"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                @if (auth()->user()->executive_only())
                    <!-- Chart Rata-Rata Nilai Angket Semua Dosen Per Semester -->
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <h3 class="card-title">Rata-Rata Nilai Angket Semua Dosen Per Semester</h3>
                                        <div class="ms-auto">
                                            <div class="d-flex align-items-center">
                                                <!-- Select Fakultas -->
                                                @php
                                                    $exclusive = in_array(1, [auth()->user()->is_p3ai, auth()->user()->is_warek_1]);
                                                @endphp
                                                <!-- Selain role exclusive, maka select ini tidak perlu ditampilkan -->
                                                <select class="form-select {{ $exclusive ? null : 'd-none' }}" id="slctFakultas-c2" style="width: 225px" onchange="updateProdi_c2(this.value)">
                                                    <!-- Menampilkan option ini hanya jika user yg login adalah P3AI, atau Warek 1 -->
                                                    @if ($exclusive)
                                                        <option value="all">Semua Fakultas</option>
                                                    @endif

                                                    @foreach ($chart_SD->semuaFakultas as $fak)
                                                        <option value="{{ $fak->id }}">
                                                            {{ $fak->nama }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                <span class="mx-2"></span>

                                                <!-- Select Prodi -->
                                                <select class="form-select" id="slctProdi-c2" style="width: 135px" onchange="updateChartAvgAllDosenPerSmt()">
                                                    <!-- Menampilkan option ini hanya jika user yg login adalah P3AI, Warek 1, atau Dekan -->
                                                    @if (auth()->user()->is_p3ai || auth()->user()->is_warek_1 || auth()->user()->is_dekan)
                                                        <option value="all">Semua Prodi</option>
                                                    @endif

                                                    @foreach ($chart_SD->semuaProdi as $prodi)
                                                        <option data-fakultas="{{ $prodi->id_fakultas }}" value="{{ $prodi->id }}">
                                                            {{ $prodi->alias }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                <span class="me-5"></span>

                                                <!-- Select Dari Semester -->
                                                <select class="form-select form-select-sm pilih-smt" id="dariSmt-c2" style="width: 80px" onchange="updateChartAvgAllDosenPerSmt()">
                                                    @foreach ($chart_SD->semuaSmt as $smt)
                                                        <option value="{{ $smt }}" {{ $smt == $chart_SD->dari ? 'selected' : null }}>
                                                            {{ $smt }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                <span class="mx-2">s/d</span>

                                                <!-- Select Hingga Semester -->
                                                <select class="form-select form-select-sm pilih-smt" id="hinggaSmt-c2" style="width: 80px" onchange="updateChartAvgAllDosenPerSmt()">
                                                    @foreach ($chart_SD->semuaSmt as $smt)
                                                        <option value="{{ $smt }}" {{ $smt == $chart_SD->hingga ? 'selected' : null }}>
                                                            {{ $smt }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div id="chartAvgNilaiAllDosenPerSmt"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif


            </div>
        </div>

    </div>

@endsection

@push('js')
    <!-- Select2 -->
    <script src="{{ asset('assets/libs/select2/select2.min.js') }}"></script>
    <!-- Apex Chart -->
    <script src="{{ asset('assets/libs/apexcharts/apexcharts.js') }}"></script>

    <script>
        $('.pilih-smt').select2({
            theme: 'bootstrap-5',
        });
    </script>

    <script>
        async function updateChartAvgNilaiPerSmt(dari, hingga) {
            const nik = "{{ auth()->user()->nik }}";

            let url = "{{ route('chart.avg-per-smt', ['nik' => ':nik', 'dari' => ':dari', 'hingga' => ':hingga']) }}";
            url = url.replace(':nik', nik)
                .replace(':dari', dari)
                .replace(':hingga', hingga);

            const response = await axios.get(url, {
                retry: 2
            });
            const data = await response.data;

            // Update data series chart
            chartAvgNilaiPerSmt.updateOptions({
                series: [{
                    data: data,
                }]
            });
        }

        const chartAvgNilaiPerSmt = new ApexCharts(
            document.querySelector('#chartAvgNilaiPerSmt'), {
                chart: {
                    type: 'line',
                    height: '300px',
                    toolbar: {
                        show: false,
                    },
                    events: {
                        click: async function(event, chartContext, config) {
                            // Kalo point yang diklik index nya kurang dari 0 maka return
                            if (config.dataPointIndex < 0) return;

                            const dataNilai = config.globals.initialSeries[config.seriesIndex].data[config.dataPointIndex];

                            let url = "{{ route('detail.hasil-angket', ['data' => ':data']) }}";
                            url = url.replace(':data', dataNilai.encData);

                            window.location.href = url;
                        },
                    },
                },
                stroke: {
                    curve: 'straight',
                },
                markers: {
                    size: 1,
                },
                dataLabels: {
                    enabled: true,
                },
                theme: {
                    palette: 'palette1',
                },
                legend: {
                    show: false,
                },
                grid: {
                    padding: {
                        left: 30,
                    },
                },
                tooltip: {
                    enabled: true,
                    x: {
                        formatter: function(value, opts) {
                            const smt = opts.w.globals.categoryLabels[opts.dataPointIndex];
                            return `Semester ${smt}`;
                        },
                    },
                },
                noData: {
                    // text: 'Sedang Memuat...',
                },
                series: [{
                    name: 'Rata-rata',
                    data: [],
                }]
            }
        );

        chartAvgNilaiPerSmt.render();

        document.addEventListener('DOMContentLoaded', function(e) {
            // Set nilai awal chart
            updateChartAvgNilaiPerSmt({{ $chart_UL->dari }}, {{ $chart_UL->hingga }});
        });
    </script>


    <script>
        function updateProdi_c2(id_fakultas) {
            const slctElm = $('#slctProdi-c2');
            // Sembunyikan semua option prodi
            slctElm.find('option').addClass('d-none');

            // Tampilkan prodi yang data fakultas nya sama dengan parameter id_fakultas
            slctElm.find(`option[data-fakultas=${id_fakultas}]`).removeClass('d-none');

            // Tampilkan option 'semua prodi'
            slctElm.find("option[value='all']").removeClass('d-none');

            // Set option 'semua prodi' sebagai default
            slctElm.val('all').trigger('change');
        }


        async function updateChartAvgAllDosenPerSmt() {
            // Ambil nilai-nilai yang diperlukan
            const id_fakultas = $('#slctFakultas-c2').val();
            const id_prodi = $('#slctProdi-c2').val();
            const dari = $('#dariSmt-c2').val();
            const hingga = $('#hinggaSmt-c2').val();

            // Rangkai URL
            let url = "{{ route('chart.avg-all-dosen-per-smt', ['id_fakultas' => ':id_fakultas', 'id_prodi' => ':id_prodi', 'dari' => ':dari', 'hingga' => ':hingga']) }}";
            url = url.replace(':id_fakultas', id_fakultas)
                .replace(':id_prodi', id_prodi)
                .replace(':dari', dari)
                .replace(':hingga', hingga);

            // Kirim Request
            const response = await axios.get(url, {
                retry: 2
            });
            const data = await response.data;

            // Update data series chart
            chartAvgNilaiAllDosenPerSmt.updateOptions({
                series: [{
                    data: data,
                }]
            });
        }


        const chartAvgNilaiAllDosenPerSmt = new ApexCharts(
            document.querySelector('#chartAvgNilaiAllDosenPerSmt'), {
                chart: {
                    type: 'bar',
                    height: '300px',
                    toolbar: {
                        show: false,
                    },
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                    }
                },
                theme: {
                    palette: 'palette1',
                },
                colors: ['#EA3546'],
                legend: {
                    show: false,
                },
                tooltip: {
                    enabled: true,
                    x: {
                        formatter: function(value, opts) {
                            const smt = opts.w.globals.labels[opts.dataPointIndex];
                            return `Semester ${smt}`;
                        },
                    },
                },
                noData: {
                    // text: 'Sedang Memuat...',
                },
                series: [{
                    name: 'Rata-rata',
                    data: [],
                }]
            }
        );

        chartAvgNilaiAllDosenPerSmt.render();

        document.addEventListener('DOMContentLoaded', function(e) {
            // Set nilai awal chart
            updateChartAvgAllDosenPerSmt();
        });
    </script>
@endpush
