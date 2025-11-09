import './bootstrap';
import Swal from 'sweetalert2';
window.Swal = Swal;

import DataTable from 'datatables.net-dt';
import 'datatables.net-dt/css/dataTables.dataTables.min.css';
import $ from 'jquery';
window.$ = $;

$.fn.dataTable.ext.errMode = 'none';
$(document).ready(function () {
    $('#table').DataTable({
        
        errorMode: 'none',
        language: {
            paginate: {
                previous: '‹',
                next: '›'
            }
        }
    });

});


window.Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
});