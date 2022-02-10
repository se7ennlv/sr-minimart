
//========================= chart ===============================//
function number_format(number, decimals, dec_point, thousands_sep) {
    // *     example: number_format(1234.56, 2, ',', ' ');
    // *     return: '1 234,56'
    number = (number + '').replace(',', '').replace(' ', '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function(n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}



//======================== notification ==============================//
function swalAlert(text, icon) {
    Swal.fire({
        icon: icon,
        title: '',
        text: text
    })
}

function smkAlert(msg, type) {
    $.smkAlert({
        text: msg,
        type: type
    });
}

function blockUI(msg) {
    $.blockUI({
        message: '<h3><i class="fas fa-spinner fa-spin fa-1x"></i> ' + msg + '</h3>',
        baseZ: 2000
    });
}

function unblockUI() {
    $.unblockUI();
}



//============================= DataTable =========================//
function summary(data) {
    var field = this.field;

    var totalSum = data.reduce(function (sum, row) {
        return sum + (+row[field]);
    }, 0);

    return '<strong>' + numeral(totalSum).format('0,0.00') + '</strong>';
}

function totalText(data) {
    return '<strong>Total (฿)</strong>'
}

function runnings(value, row, index) {
    return 1 + index;
}

function badgeVal(data) {
    return '<span class="badge badge-secondary">' + data + '</span>';
}

function dates(data) {
    return (moment(data).isValid() && moment(data).format('YYYY') != '1900') ? moment(data).format('YYYY-MM-DD') : '';
}

function dateTime(data) {
    return (moment(data).isValid() && moment(data).format('YYYY') != '1900') ? moment(data).format('YYYY-MM-DD h:mm:ss') : '';
}

function dateTimeShort(data) {
    return (moment(data).isValid() && moment(data).format('YYYY') != '1900') ? moment(data).format('YYYY-MM-DD h:mm:ss') : '';
}

function times(data) {
    return (moment(data).isValid() && moment(data).format('YYYY') != '1900') ? moment(data).format('h:mm:ss') : '';
}

function numbers(data) {
    return numeral(data).format('0,0');
}

function money(data) {
    return numeral(data).format('0,0.00');
}


function cellPopover(table, td, title, placement) {
    table.on('all.post-body.bs.table', function(e, name, args) {
        $('[data-toggle="popover"]').popover();

        $(this).find('tr').find(td).each(function() {
            $(this).attr('data-original-title', title);
            $(this).attr('data-toggle', 'popover');
            $(this).attr('data-placement', placement);
            $(this).attr('data-trigger', 'hover');
            $(this).attr('data-content', $(this).text());
        });
    });
}

function udOperates(value, row, index) {
    return [
        '<a class="btn btn-warning btn-sm btn-edit" href="javascript:void(0)" data-unique-id="', row.id, '">',
        '<i class="fas fa-edit"></i> Edit</a> ',
        '<a class="btn btn-danger btn-sm btn-del" href="javascript:void(0)" data-unique-id="', row.id, '">',
        '<i class="fas fa-times"></i> Delete</a>'
    ].join('');
}

function pvOperates(value, row, index) {
    return [
        '<a class="btn btn-warning btn-sm btn-print" href="javascript:void(0)" title="Re-print" data-unique-id="', row.id, '">',
        '<i class="fas fa-print"></i> Re-Print',
        '</a>  ',
        '<a class="btn btn-danger btn-sm btn-void" href="javascript:void(0)" title="Void" data-unique-id="', row.id, '">',
        '<i class="fa fa-times"></i> Void',
        '</a>'
    ].join('');
}