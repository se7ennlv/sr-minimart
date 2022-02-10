
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Overview for (<small><?= date('Y-M-d'); ?></small>)</h1>
</div>

<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Amount</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">฿<span id="totalAmt">0.00</span></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Check</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalInv">0</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-copy fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Average/Check</div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">฿<span id="avgPerInv">0.00</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-file-invoice-dollar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Credit Balance</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">฿<span id="creditBalance">0.00</span></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-8 col-lg-7">
        <!-- Group Best Seller -->
        <div class="card shadow mb-4">
            <div class="card-header d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Top (5) Categories Bestseller</h6>
                <i class="fas fa-th-large fa-2x text-gray-400"></i>
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="groupBestSeller"></canvas>
                </div>
            </div>
        </div>
        <!-- end -->
    </div>

    <div class="col-xl-4 col-lg-5">
        <!-- Item Best Seller -->
        <div class="card shadow mb-4">
            <div class="card-header d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Top (10) Items Bestseller</h6>
                <i class="fas fa-th-list fa-2x text-gray-400"></i>
            </div>
            <div class="card-body">
                <div class="chart-pie pt-4 pb-2">
                    <canvas id="itemBestSeller"></canvas>
                </div>
                <div class="mt-4 text-center small" id="textLabel">
                    <!-- dynamic data -->
                </div>
            </div>
            <!-- end -->

        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        GetSummary();
    });

    function GetSummary() {
        $.getJSON("<?= site_url('ReportController/FetchSummaryReport') ?>", function(data) {
            if (!$.isEmptyObject(data)) {
                $('#totalAmt').text(numeral(data.amt.TotalAmount).format('0,0.00'));
                $('#totalInv').text(numeral(data.inv.TotalInvoice).format('0,0'));
                $('#avgPerInv').text(numeral(data.amt.TotalAmount / data.inv.TotalInvoice).format('0,0.00'));
                $('#creditBalance').text(numeral(data.credit.CreditBlance).format('0,0.00'));

                var itemLabels = new Array();
                var itemDatas = new Array();
                var textLabel = '';
                var colorRandom = new Array();

                var grpLabels = new Array();
                var grpDatas = new Array();

                $.each(data.bestItem, function(i, val) {
                    colorRandom.push('#' + Math.floor(Math.random() * 16777215).toString(16));
                    itemLabels.push(val.ItemName);
                    itemDatas.push(val.TotalQty);
                    textLabel += ' <span class="mr-2 text-truncate" style="max-width: 20px">' +
                        '<i class="fas fa-circle" style="color: ' + colorRandom[i] + ';"></i> ' + val.ItemName + '</span>'
                })

                $.each(data.bestGroup, function(i, val) {
                    grpLabels.push(val.ItemGroupName);
                    grpDatas.push(val.TotalPrice);
                })

                GetItemBestSeller(itemLabels, itemDatas, colorRandom);
                $('#textLabel').html(textLabel);

                GetGroupBestSeller(grpLabels, grpDatas);     
            }
        }).fail(function(jqHRX, textStatus, errorThrown) {
            smkAlert('Something went wrong, please contact IT!', 'danger');
        });
    }

    function GetItemBestSeller(itemLabels, itemDatas, bgColor) {
        var ctx = document.getElementById("itemBestSeller");
        var myPieChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: itemLabels,
                datasets: [{
                    data: itemDatas,
                    backgroundColor: bgColor,
                    hoverBackgroundColor: bgColor,
                    hoverBorderColor: "rgba(234, 236, 244, 1)",
                }],
            },
            options: {
                maintainAspectRatio: false,
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    caretPadding: 10,
                },
                legend: {
                    display: false
                },
                cutoutPercentage: 80,
            },
        });
    }

    function GetGroupBestSeller(grpLabels, grpDatas) {
        var ctx = document.getElementById("groupBestSeller");
        var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: grpLabels,
                datasets: [{
                    label: "Earnings",
                    lineTension: 0.3,
                    backgroundColor: "rgba(78, 115, 223, 0.05)",
                    borderColor: "rgba(78, 115, 223, 1)",
                    pointRadius: 3,
                    pointBackgroundColor: "rgba(78, 115, 223, 1)",
                    pointBorderColor: "rgba(78, 115, 223, 1)",
                    pointHoverRadius: 3,
                    pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                    pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    data: grpDatas,
                }],
            },
            options: {
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        left: 10,
                        right: 25,
                        top: 25,
                        bottom: 0
                    }
                },
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'date'
                        },
                        gridLines: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            maxTicksLimit: 7
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            maxTicksLimit: 5,
                            padding: 10,
                            // Include a dollar sign in the ticks
                            callback: function(value, index, values) {
                                return '฿' + number_format(value);
                            }
                        },
                        gridLines: {
                            color: "rgb(234, 236, 244)",
                            zeroLineColor: "rgb(234, 236, 244)",
                            drawBorder: false,
                            borderDash: [2],
                            zeroLineBorderDash: [2]
                        }
                    }],
                },
                legend: {
                    display: false
                },
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    titleMarginBottom: 10,
                    titleFontColor: '#6e707e',
                    titleFontSize: 14,
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    intersect: false,
                    mode: 'index',
                    caretPadding: 10,
                    callbacks: {
                        label: function(tooltipItem, chart) {
                            var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                            return datasetLabel + ': ฿' + number_format(tooltipItem.yLabel);
                        }
                    }
                }
            }
        });
    }
</script>