var orders = [];
var spread = 0.13;

export function openOrder(direction, price) {

    price = parseFloat(price);
    var sl = parseFloat($('#sl').val());
    var tp = parseFloat($('#tp').val());

    var order_sl, order_tp;

    if (direction === 'buy') {
        price += spread;
        order_sl = price - sl;
        order_tp = price + tp;
    } else {
        order_sl = price + sl;
        order_tp = price - tp;
    }

    orders.push({
        direction: direction,
        price: price.toFixed(2),
        sl: order_sl.toFixed(2),
        tp: order_tp.toFixed(2),
        status: 'open',
        close_price: 0,
        profit: 0
    })
}

export function checkOrder(lastCandle) {
    $.each(orders, function(key, order) {
        if (order.status === 'closed') {
            return;
        }
        var high = parseFloat(lastCandle.y[1]);
        var low = parseFloat(lastCandle.y[1]);
        var price = parseFloat(lastCandle.y[1]);
        if (order.direction === 'buy') {
            if (order.sl >= low) {
                order.status = 'closed';
                order.close_price = order.sl;
                order.profit = order.close_price - order.price;
            } else if (order.tp <= high) {
                order.status = 'closed';
                order.close_price = order.tp;
                order.profit = order.close_price - order.price;
            } else {
                order.profit = (price - order.price).toFixed(2);
            }
        } else {
            var buy_price = price + spread;
            if (order.sl <= high + spread) {
                order.status = 'closed';
                order.close_price = order.sl;
                order.profit = order.price - order.close_price;
            } else if (order.tp >= low + spread) {
                order.status = 'closed';
                order.close_price = order.tp;
                order.profit = order.price - order.close_price;
            } else {
                order.profit = (order.price - price - spread).toFixed(2);
            }
        }
    });
}

export function showOrder() {
    var html = "";
    $.each(orders, function(key, order) {
        html += "<tr>" +
                "<td>" + order.direction + "</td>" +
                "<td>" + order.price + "</td>" +
                "<td>" + order.sl + "</td>" +
                "<td>" + order.tp + "</td>" +
                "<td>" + order.status + "</td>" +
                "<td>" + order.close_price + "</td>" +
                "<td>" + order.profit + "</td>" +
                "</tr>";

    });
    $('#orders table tbody').html(html);
}
