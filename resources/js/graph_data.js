var formatCandlesData = function(data) {
    return $.map( data, function( n ) {
        const [time, ...prices] = n;
        return {
          x: new Date(time * 1000),
          y: prices
        }
    });
}

var formatBbData = function(data) {
    var bbData = {
        'sma' : [],
        'upper' : [],
        'lower' : []
    }

    $.each(data, function(i, n) {
        const [time, sma, sd, upper, lower] = n;
        bbData['sma'].push({
            x: new Date(time * 1000),
            y: sma
        });
        bbData['upper'].push({
            x: new Date(time * 1000),
            y: upper
        });
        bbData['lower'].push({
            x: new Date(time * 1000),
            y: lower
        });
    });
    return bbData;
}

var graphData = {
    candles: [],
    bb_data: []
};
var futureData = {
    candles: [],
    bb_data: []
};

var currentData = {};
var realTimeDatas = [];
var shiftCount = 0;

export function loadGraphData() {
    return new Promise((resolve) => {
        $.getJSON('/graph/data/' + $('#start').val(), function(response) {
            graphData = {
                m1_candles: formatCandlesData(response.candles),
                m1_bb_data: formatBbData(response.bb_data),
                m5_candles: formatCandlesData(response.m5_candles),
                m5_bb_data: formatBbData(response.m5_bb_data),
                m15_candles: formatCandlesData(response.m15_candles),
                m15_bb_data: formatBbData(response.m15_bb_data),
                m60_candles: formatCandlesData(response.m60_candles),
                m60_bb_data: formatBbData(response.m60_bb_data),
            }
            resolve(graphData);
        });
  });
}

export function loadFutureData() {
    return new Promise((resolve) => {
        $.getJSON('/graph/future_data/' + $('#start').val(), function(response) {
            futureData = {
                m1_candles: formatCandlesData(response.candles),
                m1_bb_data: formatBbData(response.bb_data),
                m5_candles: formatCandlesData(response.m5_candles),
                m5_bb_data: formatBbData(response.m5_bb_data),
                m15_candles: formatCandlesData(response.m15_candles),
                m15_bb_data: formatBbData(response.m15_bb_data),
                m60_candles: formatCandlesData(response.m60_candles),
                m60_bb_data: formatBbData(response.m60_bb_data),
            }
            resolve(futureData);
        });
  });
}


export function getGraphData(data) {
    return graphData;
}


export function shiftData() {

    if (shiftCount % 10 == 0) {
        currentData.m1_candles = futureData.m1_candles.shift();
        currentData.m1_bb_data = {
            sma: futureData.m1_bb_data.sma.shift(),
            lower: futureData.m1_bb_data.lower.shift(),
            upper: futureData.m1_bb_data.upper.shift()
        };
    }

    if (shiftCount % 50 == 0) {
        currentData.m5_candles = futureData.m5_candles.shift();
        currentData.m5_bb_data = {
            sma: futureData.m5_bb_data.sma.shift(),
            lower: futureData.m5_bb_data.lower.shift(),
            upper: futureData.m5_bb_data.upper.shift()
        };
    }
    if (shiftCount % 150 == 0) {
        currentData.m15_candles = futureData.m15_candles.shift();
        currentData.m15_bb_data = {
            sma: futureData.m15_bb_data.sma.shift(),
            lower: futureData.m15_bb_data.lower.shift(),
            upper: futureData.m15_bb_data.upper.shift()
        };
    }

    if (shiftCount % 600 == 0) {
        currentData.m60_candles = futureData.m60_candles.shift();
        currentData.m60_bb_data = {
            sma: futureData.m60_bb_data.sma.shift(),
            lower: futureData.m60_bb_data.lower.shift(),
            upper: futureData.m60_bb_data.upper.shift()
        };
    }


    if (realTimeDatas.length === 0) {
        var nextCandle = currentData.m1_candles;
        realTimeDatas = generateRealTimeData(nextCandle);
    }

    var realTimeData =  realTimeDatas.shift();
    var currentM5Candle;
    var currentM15Candle;
    var currentM60Candle;

    if (shiftCount % 10 === 0) {
        graphData.m1_candles.push(realTimeData);
        graphData.m1_bb_data.sma.push(currentData.m1_bb_data.sma);
        graphData.m1_bb_data.upper.push(currentData.m1_bb_data.upper);
        graphData.m1_bb_data.lower.push(currentData.m1_bb_data.lower);

    } else {
        graphData.m1_candles[graphData.m1_candles.length - 1] = realTimeData;
    }

    if (shiftCount % 50 === 0) {
        currentM5Candle = {
            x: realTimeData.x,
            y: $.extend([], realTimeData.y)
        }

        graphData.m5_candles.push(currentM5Candle);
        graphData.m5_bb_data.sma.push(currentData.m5_bb_data.sma);
        graphData.m5_bb_data.upper.push(currentData.m5_bb_data.upper);
        graphData.m5_bb_data.lower.push(currentData.m5_bb_data.lower);

    } else {
        currentM5Candle = graphData.m5_candles[graphData.m5_candles.length - 1];

        currentM5Candle.y[3] = realTimeData.y[3];

        if (currentM5Candle.y[1] < realTimeData.y[1]) {
            currentM5Candle.y[1] = realTimeData.y[1];
        }
        if (currentM5Candle.y[2] > realTimeData.y[2]) {
            currentM5Candle.y[2] = realTimeData.y[2];
        }

        graphData.m5_candles[graphData.m5_candles.length - 1] = currentM5Candle;
    }

    if (shiftCount % 150 === 0) {
        currentM15Candle = {
            x: realTimeData.x,
            y: $.extend([], realTimeData.y)
        }

        graphData.m15_candles.push(currentM15Candle);
        graphData.m15_bb_data.sma.push(currentData.m15_bb_data.sma);
        graphData.m15_bb_data.upper.push(currentData.m15_bb_data.upper);
        graphData.m15_bb_data.lower.push(currentData.m15_bb_data.lower);

    } else {
        currentM15Candle = graphData.m15_candles[graphData.m15_candles.length - 1];

        currentM15Candle.y[3] = realTimeData.y[3];

        if (currentM15Candle.y[1] < realTimeData.y[1]) {
            currentM15Candle.y[1] = realTimeData.y[1];
        }
        if (currentM15Candle.y[2] > realTimeData.y[2]) {
            currentM15Candle.y[2] = realTimeData.y[2];
        }

        graphData.m15_candles[graphData.m15_candles.length - 1] = currentM15Candle;
    }

    if (shiftCount % 600 === 0) {
        currentM60Candle = {
            x: realTimeData.x,
            y: $.extend([], realTimeData.y)
        }

        graphData.m60_candles.push(currentM60Candle);
        graphData.m60_bb_data.sma.push(currentData.m60_bb_data.sma);
        graphData.m60_bb_data.upper.push(currentData.m60_bb_data.upper);
        graphData.m60_bb_data.lower.push(currentData.m60_bb_data.lower);

    } else {
        currentM60Candle = graphData.m60_candles[graphData.m60_candles.length - 1];

        currentM60Candle.y[3] = realTimeData.y[3];

        if (currentM60Candle.y[1] < realTimeData.y[1]) {
            currentM60Candle.y[1] = realTimeData.y[1];
        }
        if (currentM60Candle.y[2] > realTimeData.y[2]) {
            currentM60Candle.y[2] = realTimeData.y[2];
        }

        graphData.m60_candles[graphData.m60_candles.length - 1] = currentM60Candle;
    }

    shiftCount++;

    return [shiftCount - 1, realTimeData, currentData.m1_bb_data, currentM5Candle, currentData.m5_bb_data, currentM15Candle, currentData.m15_bb_data, currentM60Candle, currentData.m60_bb_data];
}


export function generateRealTimeData(candle) {
    var candles = [];
    var openIndex = 0, highIndex = 3, lowIndex = 6, closeIndex = 9;
    var open, high, low, close;

    for (var i = 0; i <= 3; i++) {
        candle.y[i] = parseFloat(candle.y[i]);
    }

    for (var i = 0; i <= 9; i++) {
        if (i == openIndex) {
            open = high = low = close = candle.y[0];
        } else if (i < highIndex) {
            close = candle.y[0] + (candle.y[1] - candle.y[0]) * i / 3;
            high = close;
        } else if (i == highIndex) {
            close = candle.y[1];
            high = close;
        } else if (i < lowIndex) {
            close = candle.y[1] - (candle.y[1] - candle.y[2]) * (i-3) / 3;
            if (close < low) {
                low = close;
            }
        } else if (i == lowIndex) {
            close = candle.y[2];
            low = close;
        } else if (i < closeIndex) {
            close = candle.y[2] + (candle.y[3] - candle.y[2]) * (i-6) / 3;
        } else if (i == closeIndex) {
            close = candle.y[3];
        }
        candles[i] = {
            x: candle.x,
            y: [open.toFixed(2), high.toFixed(2), low.toFixed(2), close.toFixed(2)]
        }
    }
    return candles;
}
