$(function() {
    //Highcharts with mySQL and PHP - Ajax101.com

    var date = [];
    var adjustedCount = [];
    var dayCount = [];
    var switch2 = 0;
    $.get('values2.php', function(data) {
        tmp = data.split('=');
        question = tmp[0];
        data = tmp[1].split('/');
        for (var i in data) {
            if (switch2 == 0) {
                date.push(data[i]);
                switch2 = 1;
            } else if (switch2 == 1) {
                dayCount.push(parseInt(data[i]));
                switch2 = 2;
            } else {
                adjustedCount.push(parseInt(data[i]));
                switch2 = 0;
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
                name: 'questionCount--放大10倍',
                data: adjustedCount
            }, {
                name: 'dayCount',
                data: dayCount
            }]
        });
    });
});
