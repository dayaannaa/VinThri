$(document).ready(function () {
    var ctx = $("#chartCanvas")[0].getContext('2d');
    var myChart;

    function loadChart(url, type, label, bgColor, borderColor) {
        $.ajax({
            type: "GET",
            url: url,
            dataType: "json",
            success: function (data) {
                if (myChart) {
                    myChart.destroy();
                }
                myChart = new Chart(ctx, {
                    type: type,
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: label,
                            data: data.data,
                            backgroundColor: bgColor,
                            borderColor: borderColor,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(tooltipItem) {
                                        return tooltipItem.label + ': ' + tooltipItem.raw.toLocaleString();
                                    }
                                }
                            }
                        }
                    }
                });
            },
            error: function (error) {
                console.log(error);
            }
        });
    }

    // Initial load
    loadChart("/charts/sales-chart", 'bar', 'Monthly Sales', 'rgba(75, 192, 192, 0.2)', 'rgba(75, 192, 192, 1)');
    $("#chartSelector").change(function () {
        var selectedChart = $(this).val();
        if (selectedChart === "salesChart") {
            loadChart("/charts/sales-chart", 'bar', 'Monthly Sales', [
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 205, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(201, 203, 207, 0.2)'
            ], [
                'rgb(255, 99, 132)',
                'rgb(255, 159, 64)',
                'rgb(255, 205, 86)',
                'rgb(75, 192, 192)',
                'rgb(54, 162, 235)',
                'rgb(153, 102, 255)',
                'rgb(201, 203, 207)'
            ]);
        } else if (selectedChart === "itemChart") {
            loadChart("/charts/item-chart", 'pie', 'Top 10 Products Sold', [
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 205, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(201, 203, 207, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 205, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)'
            ], [
                'rgb(255, 99, 132)',
                'rgb(255, 159, 64)',
                'rgb(255, 205, 86)',
                'rgb(75, 192, 192)',
                'rgb(54, 162, 235)',
                'rgb(153, 102, 255)',
                'rgb(201, 203, 207)',
                'rgb(255, 159, 64)',
                'rgb(255, 205, 86)',
                'rgb(75, 192, 192)'
            ]);
        } else if (selectedChart === "customerChart") {
            loadChart("/charts/customer-chart", 'line', 'Number of Customers', 'rgba(75, 192, 192, 0.2)', 'rgba(75, 192, 192, 1)');
        }
    });
});
