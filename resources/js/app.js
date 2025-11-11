import './bootstrap';
import Swal from 'sweetalert2';
window.Swal = Swal;

import DataTable from 'datatables.net-dt';
import $ from 'jquery';
window.$ = $;

$.fn.dataTable.ext.errMode = 'none';

// Cek apakah ada empty row
const hasEmptyRow = $('#table tbody tr.empty-row').length > 0;

$('#table').DataTable({
    autoWidth: false, 
    responsive: true,
    columnDefs: [
        { 
            targets: '_all',
            className: 'text-left align-middle'
        }
    ],
    language: {
        search: "",
        searchPlaceholder: "Cari data siswa...",
        lengthMenu: "_MENU_ entri per halaman",
        zeroRecords: hasEmptyRow ? "" : "Tidak ada data ditemukan",
        info: hasEmptyRow ? "Tidak ada data siswa" : "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
        infoEmpty: "Tidak ada data siswa",
        infoFiltered: "(difilter dari _MAX_ total entri)",
        paginate: { 
            previous: "‹", 
            next: "›",
            first: "«",
            last: "»"
        }
    },
    // Layout yang lebih rapi
    dom:
        "<'flex flex-col md:flex-row justify-between items-center gap-4 mb-6'<'flex items-center'l><'flex items-center'f>>" +
        "<'overflow-x-auto'tr>" +
        "<'flex flex-col md:flex-row justify-between items-center gap-4 mt-6'<'text-sm'i><'flex items-center'p>>",
    drawCallback: function() {
        // Hide pagination dan length menu jika hanya ada empty row
        if (hasEmptyRow && this.api().data().count() === 1) {
            $('.dataTables_length, .dataTables_paginate').hide();
        }
    }
});

window.Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
});