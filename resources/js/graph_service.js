import ApexCharts from 'apexcharts';

var getGraphOptions = function() {
    return {
        series: [
            {
                name: 'Candles',
                type: 'candlestick',
                data: []
            },
            {
                name: 'Sma',
                type: 'line',
                data: []
            },
            {
                name: 'Upper',
                type: 'line',
                data: []
            },
            {
                name: 'Lower',
                type: 'line',
                data: []
            },
        ],
        chart: {
             type: 'candlestick',
             height: 550
        },
        title: {
             text: 'CandleStick Chart',
             align: 'left'
        },
        stroke: {
            curve: 'straight',
            colors: ['#FF0000', '#CCCCCC', '#CCCCCC', '#CCCCCC'],
        },
        xaxis: {
             type: 'datetime',
             labels: {
                 datetimeUTC: false,
             },
             tooltip: {
                 enable: false
             }
        },
        tooltip: {
            x: {
                format: 'HH:mm'
            },
        },
        yaxis: {
             tooltip: {
                enabled: true
             }
        }
    };
}

var chart = {};

export function drawGraph(data, mode) {
    var candles = data[mode + '_candles'];
    var bbData = data[mode + '_bb_data'];
    var options = getGraphOptions();

    options.series[0].data = candles;
    options.series[1].data = bbData.sma;
    options.series[2].data = bbData.upper;
    options.series[3].data = bbData.lower;

    if (typeof data.orders === 'object') {
        $.each(data.orders, function(key, order) {
            options.series.push({
                  name: 'Order ',
                  type: 'line',
                  data: [
                        {
                            x: new Date(order.open_time * 1000),
                            y: order.open_price
                        },
                        {
                            x: new Date(order.close_time * 1000),
                            y: order.close_price
                        }
                  ]
            });
            options.stroke.colors.push(order.profit > 0 ? '#00FF00' : '#FF0000');
        });
    }

    chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
}

export function changeGraphMode(data, mode) {
    var candles = data[mode + '_candles'];
    var bbData = data[mode + '_bb_data'];
    chart.updateSeries([
        {
            data: candles
        },
        {
            data: bbData.sma
        },
        {
            data: bbData.upper
        },
        {
            data: bbData.lower
        }
    ])
}

export function updateGraph(lastCandle) {
    chart.replaceData([{data:[lastCandle]}]);
}
export function appendGraph(lastCandle) {
    chart.appendData([{data:[lastCandle]}]);
}
export function appendIndicator(bbData) {
    chart.appendData([
        {data:[]},
        {data:[bbData.sma]},
        {data:[bbData.upper]},
        {data:[bbData.lower]},
    ]);
}
