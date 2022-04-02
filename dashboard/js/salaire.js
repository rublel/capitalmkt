$(document).ready(function () {
    let array = [];
    let mois;
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
        let sumMonth = new Intl.NumberFormat('de-DE', { style: 'currency', currency: 'ILS' }).format(sum)
        document.querySelector('#' + mois).innerHTML = sumMonth;
        let currency = parseFloat(document.getElementById('currency').textContent);
        let obj = new Object;
        obj.mois = i;
        obj.commEuro = Math.round(arrColVal[1] / currency);
        obj.horraires = Math.round(arrColVal[0] / 32);
        obj.fixe = arrColVal[0];
        obj.eurils = currency
        obj.commShekel = arrColVal[1];
        obj.total = parseFloat(sumMonth.split('.').join('').split(',').join('.'))
        totalMonth.push([i, sum])
        console.log(obj);
        console.log(totalMonth);
    })
})
$("#formSalaire").on('submit', function (e) {
    e.preventDefault();
    let val = $('#user')
    let arr = [];
    val.map((i, e) => arr.push(e.value.split(' ')[0].toLowerCase()))
    let user = arr[0]
    console.log(user);
    $.ajax({
        type: 'POST',
        url: './controllers/salaire.php?u=' + user,
        data: { user },
        success: (data) => {
            $('#table').html(data)
        }
    })
});