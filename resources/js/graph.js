
import {getGraphData, setGraphData, get60, getNext, generateRealTimeData} from './graph_data';
import {drawGraph, updateGraph, appendGraph, appendIndicator, changeGraphMode} from './graph_service';

var graphData = {};

var mode = 'm1';

async function staticGraph() {
    graphData = await getGraphData();

    drawGraph(graphData, mode);
}

$(document).ready(function(){
    staticGraph();

    $('#m1').click(function() {
        mode = 'm1';
        changeGraphMode(graphData, mode);
    });
    $('#m5').click(function() {
        mode = 'm5';
        changeGraphMode(graphData, mode);
        console.log(mode);
    });
});
