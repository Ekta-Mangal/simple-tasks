@extends('include.master')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="far fa-chart-bar"></i>
                                    Bar Chart
                                </h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="bar-chart" style="height: 400px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function() {
            // Define weekdays for x-axis labels
            const daysOfWeek = {
                1: 'Sunday',
                2: 'Monday',
                3: 'Tuesday',
                4: 'Wednesday',
                5: 'Thursday',
                6: 'Friday',
                7: 'Saturday'
            };

            // Data from the controller
            let chartData = @json($chartData);
            let startDate = "{{ $startDate->format('Y-m-d') }}";
            let endDate = "{{ $endDate->format('Y-m-d') }}";

            // Convert data for plotting
            let barData = chartData.map(data => [data.day, data.total_hours]);

            // Set up date range filter inputs
            $('#date-range').daterangepicker({
                startDate: startDate,
                endDate: endDate,
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });

            // Plot bar chart with filtered data
            function plotChart(data) {
                $.plot('#bar-chart', [{
                    data: data,
                    bars: {
                        show: true
                    }
                }], {
                    grid: {
                        borderWidth: 1,
                        borderColor: '#f3f3f3',
                        tickColor: '#f3f3f3'
                    },
                    series: {
                        bars: {
                            show: true,
                            barWidth: 0.5,
                            align: 'center'
                        }
                    },
                    colors: ['#3c8dbc'],
                    xaxis: {
                        ticks: Object.entries(daysOfWeek).map(([day, label]) => [day, label])
                    }
                });
            }

            // Initial plot
            plotChart(barData);

            // Filter chart based on date range selection
            $('#date-range').on('apply.daterangepicker', function(ev, picker) {
                let start = picker.startDate.format('YYYY-MM-DD');
                let end = picker.endDate.format('YYYY-MM-DD');

                // Fetch filtered data via AJAX (if necessary)
                $.ajax({
                    url: "{{ route('graph') }}",
                    type: "GET",
                    data: {
                        start_date: start,
                        end_date: end
                    },
                    success: function(response) {
                        let filteredData = response.chartData.map(data => [data.day, data
                            .total_hours
                        ]);
                        plotChart(filteredData);
                    },
                    error: function() {
                        alert("Something went wrong while filtering data.");
                    }
                });
            });
        });
    </script>
@endsection
