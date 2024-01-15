
import {loadGraphData, loadFutureData, getGraphData, shiftData} from './graph_data';
import {drawGraph, updateGraph, appendGraph, appendIndicator, changeGraphMode} from './graph_service';
import {openOrder, showOrder, checkOrder} from './orders';

var mode = 'm1';
var delay = 5000;
var skipCount = 0;
var currentPrice = 0;

var next = function() {

    var [shiftCount, lastCandle, lastBb, lastM5Candle, lastM5Bb, lastM15Candle, lastM15Bb] = shiftData();

    currentPrice = parseFloat(lastCandle.y[3]);
    $('#price').val(currentPrice);
    checkOrder(lastCandle);
    showOrder();

    if (skipCount > 0) {
        skipCount--;
        if (skipCount == 0) {
            var graphData = getGraphData();
            changeGraphMode(graphData, mode);
        }
        setTimeout(function() {
            next();
        }, 1);
        return;
    }


    if (mode === 'm1') {
        if (shiftCount % 10 === 0) {
            appendGraph(lastCandle);
            appendIndicator(lastBb);
        } else {
            updateGraph(lastCandle);
        }
    } else if (mode === 'm5') {
        if (shiftCount % 50 === 0) {
            appendGraph(lastM5Candle);
            appendIndicator(lastM5Bb);
        } else {
            updateGraph(lastM5Candle);
        }
    }
    else if (mode === 'm15') {
        if (shiftCount % 150 === 0) {
            appendGraph(lastM15Candle);
            appendIndicator(lastM15Bb);
        } else {
            updateGraph(lastM15Candle);
        }
    }

    setTimeout(function() {
        next();
    }, delay)

}

async function dynamicGraph() {
    var graphData = await loadGraphData();

    drawGraph(graphData, mode);

    var futureData = await loadFutureData();

    next();
}

$(document).ready(function(){

    dynamicGraph();

    $('#m1').click(function() {
        mode = 'm1';
        var graphData = getGraphData();
        changeGraphMode(graphData, mode);
    });
    $('#m5').click(function() {
        mode = 'm5';
        var graphData = getGraphData();
        changeGraphMode(graphData, mode);
    });
    $('#m15').click(function() {
        mode = 'm15';
        var graphData = getGraphData();
        changeGraphMode(graphData, mode);
    });
    $('#x1').click(function() {
        delay = 5000;
    });
    $('#x10').click(function() {
        delay = 100;
    });

    $('#skip10').click(function() {
        skipCount = 100;
    });

    $('#buy').click(function() {
        openOrder('buy', currentPrice);
        showOrder();
    });

    $('#sell').click(function() {
        openOrder('sell', currentPrice);
        showOrder();
    })


});
