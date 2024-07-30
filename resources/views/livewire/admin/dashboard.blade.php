<div>
    <div class="row mb-5">

        <div class="col-lg-4 col-md-12 col-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <span class="badge bg-label-info me-1">
                                <i class="bx bx-user-pin"></i>
                            </span>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">Total Users</span>
                    <h3 class="card-title mb-2"> {{ $users }} </h3>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-12 col-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <span class="badge bg-label-danger me-1">
                                <i class="bx bx-category"></i>
                            </span>
                        </div>
                    </div>
                    <span>Total Categories</span>
                    <h3 class="card-title text-nowrap mb-1">{{ $categories }}</h3>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-12 col-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <span class="badge bg-label-success me-1">
                                <i class="bx bx-shape-square" aria-hidden="true"></i>
                            </span>
                        </div>
                    </div>
                    <span>Total Platforms</span>
                    <h3 class="card-title text-nowrap mb-1">{{ $platforms }}</h3>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-12 col-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <span class="badge bg-label-warning me-1">
                                <i class="bx bx-credit-card-alt" aria-hidden="true"></i>
                            </span>
                        </div>
                    </div>
                    <span>Total Cards</span>
                    <h3 class="card-title text-nowrap mb-1">{{ $cards }}</h3>
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-12 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <select class="form-select form-select-sm" wire:model="days">
                                <option selected>Select Days</option>
                                <option value="7">Last 7 Days</option>
                                <option value="14"> Last 14 Days </option>
                                <option value="30">Last 30 Days</option>
                                <option value="90">Last 3 Months</option>
                            </select>
                        </div>
                    </div>
                    <canvas id="registrations" style="width:100%;max-width:600;"></canvas>
                </div>
            </div>
        </div>

    </div>

    @section('script')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
        </script>
        <script>
            $(document).ready(function() {
                var data = JSON.parse(@json($registrations));
                chartData(data, '{{ $days }}');
            });

            document.addEventListener('showData', event => {
                var data = JSON.parse(event.detail.registrations)
                chartData(data, event.detail.days);
            });

            function chartData(data, days = 7) {
                // registrations graph
                let registrations = data;

                let dates = [];
                let users = [];
                for (let i = 0; i < registrations.length; i++) {
                    dates.push(registrations[i].created_date);
                    users.push(registrations[i].user_count);
                }
                var xValues = dates;
                var yValues_a = users;
                var barColors = ["green"];
                new Chart("registrations", {
                    type: "bar",
                    data: {
                        labels: xValues,
                        datasets: [{
                            label: 'Total Registrations',
                            backgroundColor: barColors[0],
                            data: yValues_a
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    stepSize: 1,
                                    min: 0,
                                    callback: function(value, index, values) {

                                        return value;
                                    }
                                }
                            }]
                        },
                        legend: {
                            display: true
                        },
                        events: [],
                        title: {
                            display: true,
                            text: "Last " + days + " days registrations"
                        }
                    }
                });
            }
        </script>
    @endsection

</div>
