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

                <!-- Chart Rata-Rata Nilai Angket Per Semester -->
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <h3 class="card-title">Rata-Rata Nilai Angket Anda Per Semester</h3>
                                    <div class="ms-auto">
                                        <div class="d-flex align-items-center">
                                            <select id="dariSmt" class="form-select pilih-smt" style="width: 80px" onchange="updateChartAvgNilaiPerSmt(this.value, $('#hinggaSmt').val())">
                                                @foreach ($semuaSmt as $smt)
                                                    <option value="{{ $smt }}" {{ $smt == $dari ? 'selected' : null }}>
                                                        {{ $smt }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            <span class="mx-3">-</span>

                                            <select id="hinggaSmt" class="form-select pilih-smt" style="width: 80px" onchange="updateChartAvgNilaiPerSmt($('#dariSmt').val(), this.value)">
                                                @foreach ($semuaSmt as $smt)
                                                    <option value="{{ $smt }}" {{ $smt == $hingga ? 'selected' : null }}>
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
            // theme: 'bootstrap-5',
        });
    </script>

    <script>
        async function updateChartAvgNilaiPerSmt(dari, hingga) {
            const nik = "{{ auth()->user()->nik }}";

            let url = "{{ route('chart.avg-per-smt', ['nik' => ':nik', 'dari' => ':dari', 'hingga' => ':hingga']) }}";
            url = url.replace(':nik', nik).replace(':dari', dari).replace(':hingga', hingga);

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
                    type: 'bar',
                    height: '300px',
                    toolbar: {
                        show: false,
                    },
                    events: {
                        dataPointSelection: async function(event, chartContext, config) {
                            const dataNilai = config.w.globals.initialSeries[config.seriesIndex].data[config.dataPointIndex];

                            let url = "{{ route('detail.hasil-angket', ['data' => ':data']) }}";
                            url = url.replace(':data', dataNilai.encData);

                            window.location.href = url;
                        },
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

        chartAvgNilaiPerSmt.render();

        document.addEventListener('DOMContentLoaded', function(e) {
            // Set nilai awal chart
            updateChartAvgNilaiPerSmt({{ $dari }}, {{ $hingga }});
        });
    </script>
@endpush
