$(document).ready(function () {
    let array = [];
    let mois = null;
    let totalMonth = [];
    for (i = 1; i < 13; i++) {
        i >= 10 ? mois = "m" + i : mois = "m0" + i
        array.push(mois);
    }
    array.forEach((e, i) => {
        let col = document.querySelectorAll('.' + e);
        let arrCol = Object.values(col)
        let arrColVal = arrCol.map(e => parseFloat(e.textContent.split('.').join('').split(',').join('.')))
        let sum = arrColVal.reduce((prev, curr) => prev + curr, 0)
        i += 1
        i >= 10 ? mois = "m" + i : mois = "m0" + i
        let sumMonth = new Intl.NumberFormat('de-DE', { style: 'currency', currency: 'EUR' }).format(sum)
        document.querySelector('#' + mois).innerHTML = sumMonth;
        totalMonth.push([i, sum])
        console.log(arrColVal);
    })
    google.charts.load('current', { packages: ['corechart', 'line'] });
    google.charts.setOnLoadCallback(drawBasic);
    function drawBasic() {
        var data = new google.visualization.DataTable();
        data.addColumn('number', 'X');
        data.addColumn('number', 'Euro');

        data.addRows(totalMonth);

        var options = {
            hAxis: {
                title: '2022'
            },
            vAxis: {
                title: 'CA'
            }
        };
        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    }
})