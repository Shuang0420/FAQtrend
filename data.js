$(function() {
    var date = [];
    var adjustedCount = [];
    var dayCount = [];
    var switch1 = true;
    $.get('values.php', function(data) {
        data = data.split('/');
        for (var i in data) {
            if (switch1 == true) {
                date.push(data[i]);
                switch1 = false;
            } else {
                adjustedCount.push(parseFloat(data[i]));
                switch1 = true;
            }

        }
        date.pop();



        $('#chart').highcharts({
            chart: {
                type: 'spline'
            },
            title: {
                text: '常见问题热度趋势--' + question
            },
            subtitle: {
                text: 'Source: 滴滴打车'
            },
            xAxis: {
                title: {
                    text: 'Date'
                },
                categories: date
            },
            yAxis: {
                title: {
                    text: 'Count'
                },
                labels: {
                    formatter: function() {
                        return this.value
                    }
                }
            },
            tooltip: {
                crosshairs: true,
                shared: true,
                valueSuffix: ''
            },
            plotOptions: {
                spline: {
                    marker: {
                        radius: 4,
                        lineColor: '#666666',
                        lineWidth: 1
                    }
                }
            },
            series: [{
                name: 'Count',
                data: adjustedCount
            }]
        });
    });
});
