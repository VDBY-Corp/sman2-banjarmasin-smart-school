import axios from 'axios';
import { getCurrentCsrfToken, getCurrentUrl } from './../utils/func';

const tableEl = $('#table');

async function save(oldId) {
    
}

async function add() {

}

// on dom content loaded
window.addEventListener('DOMContentLoaded', () => {
    tableEl.DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        // get current url from html meta set in "layouts/app-dashboard.blade.php"
        ajax: document.querySelector('meta[name="current-url"]').getAttribute('content'),
        columns: [
            { name: 'id', data: 'id' },
            { name: 'name', data: 'name' },
            { name: 'email', data: 'email' },
            {
                orderable: false,
                searchable: false,
                data: function(data) {
                return `
                    <div class="">
                        <a href="#" class="btn btn-sm btn-warning btn-edit" data-json="${ JSON.stringify(data).toString().replaceAll('"', "'") }">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="#" class="btn btn-sm btn-danger btn-delete" data-json="${ JSON.stringify(data).toString().replaceAll('"', "'") }">
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>
                `;
                }
            }
        ],
        // detech page change
        drawCallback: function () {
            // action: edit
            $(".btn-edit").prop("onclick", null).off("click");
            $('.btn-edit').on('click', function () {
                const thisbutton = $(this);
                const data = JSON.parse(thisbutton.attr('data-json')?.replaceAll("'", '"'));
                const modalEditEl = document.querySelector('#modal');

                modalEditEl.setAttribute('data-json', thisbutton.attr('data-json'));
                modalEditEl.querySelector('.modal-title').innerHTML = `Edit Guru "${data.name}"`;
                
                // show modal
                $('#modal').modal({ show: true });

                // set button save onclick
                $('#modal-btn-save').prop("onclick", null).off("click");
                $('#modal-btn-save').on('click', () => save(data.id));

                // set form value
                $('#inputId').val(data.id);
                $('#inputName').val(data.name);
                $('#inputGender').val(data.gender);
                $('#inputEmail').val(data.email);
            });

            // acton: delete
            $(".btn-delete").prop("onclick", null).off("click");
            $('.btn-delete').on('click', function () {
                const thisbutton = $(this);
                const data = JSON.parse(thisbutton.attr('data-json')?.replaceAll("'", '"'));

                // @feat/api-alert
                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: `Anda akan menghapus data siswa ${data.name} (${data.id})?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Tidak, batalkan'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // send api request post
                        axios({
                            method: 'DELETE',
                            url: getCurrentUrl() + '/' + data.id,
                            headers: {
                                'X-CSRF-TOKEN': getCurrentCsrfToken(),
                                'Content-Type': 'application/json'
                            }
                        })
                    }
                });
            });
        }
    });
});


// when web is ready
$(document).ready(function(){
    $('#btn-add').on('click', function () {
        // delete value
        document.querySelector('#inputNISN').value = ''
        document.querySelector('#inputName').value = ''
        document.querySelector('#inputGender').value = ''
        document.querySelector('#inputGrade').value = ''
        document.querySelector('#inputGeneration').value = ''

        const modalEditEl = document.querySelector('#modal')
        modalEditEl.querySelector('.modal-title').innerHTML = `Tambah Siswa`
        $('#modal').modal({ show: true })
        $("#modal-btn-save").prop("onclick", null).off("click")
        $('#modal-btn-save').on('click', () => add())
    });
});