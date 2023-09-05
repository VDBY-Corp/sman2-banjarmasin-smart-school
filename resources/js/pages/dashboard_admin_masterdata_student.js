import axios from 'axios'
import { getCurrentCsrfToken, getCurrentUrl } from './../utils/func'

const tableEl = $('#table')

async function save(oldNisn) {
    const nisn = document.querySelector('#inputNISN').value
    const name = document.querySelector('#inputName').value
    const gender = document.querySelector('#inputGender').value
    const gradeId = document.querySelector('#inputGrade').value
    const generationId = document.querySelector('#inputGeneration').value

    const data = JSON.stringify({
        'old_nisn' : oldNisn,
        'new_nisn' : nisn,
        'name' : name,
        'gender' : gender,
        'grade_id' : gradeId,
        'generation_id' : generationId
    })

    // send api request post
    try {
        const http = await axios({
            method: 'PUT',
            url: getCurrentUrl() + '/' + oldNisn,
            headers: {
                'X-CSRF-TOKEN': getCurrentCsrfToken(),
                'Content-Type': 'application/json'
            },
            data: data
        })
        // @feat/api-alert
        Toast.fire({
            icon: 'success',
            title: 'Sukses',
            text: 'Berhasil mengubah data',
        }).then((result) => {
            if (result.isConfirmed) {
                tableEl.DataTable().ajax.reload(null, false);
            }
        })
    } catch (error) {
        // @feat/api-alert
        Toast.fire({
            icon: 'error',
            title: 'Gagal',
            text: 'Gagal mengubah data',
        }).then((result) => {
            if (result.isConfirmed) {
                tableEl.DataTable().ajax.reload(null, false);
            }
        })
        console.log(error);
    }
}

async function add() {
    const data = JSON.stringify({
        'nisn' : document.querySelector('#inputNISN').value,
        'name' : document.querySelector('#inputName').value,
        'gender' : document.querySelector('#inputGender').value,
        'grade_id' : document.querySelector('#inputGrade').value,
        'generation_id' : document.querySelector('#inputGeneration').value
    })

    // send api request post
    try {
        const http = await axios({
            method: 'POST',
            url: getCurrentUrl(),
            headers: {
                'X-CSRF-TOKEN': getCurrentCsrfToken(),
                'Content-Type': 'application/json'
            },
            data: data
        })
        // @feat/api-alert
        Toast.fire({
            icon: 'success',
            title: 'Sukses',
            text: 'Berhasil menambah data',
        }).then((result) => {
            if (result.isConfirmed) {
                tableEl.DataTable().ajax.reload(null, false);
            }
        })
    } catch (error) {
        // @feat/api-alert
        Toast.fire({
            icon: 'error',
            title: 'Gagal',
            text: 'Gagal menambah data',
        }).then((result) => {
            if (result.isConfirmed) {
                tableEl.DataTable().ajax.reload(null, false);
            }
        })
        console.log(error);
    }
}

window.addEventListener('DOMContentLoaded', () => {
    tableEl.DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: document.querySelector('meta[name="current-url"]').getAttribute('content'),
        columns: [
            { name: 'nisn', data: 'nisn' },
            { name: 'name', data: 'name' },
            { name: 'grade', data: 'grade.name', searchable: false, orderable: false },
            {
                orderable: false,
                searchable: false,
                data: function (data) {
                    return `
                        <div class="">
                            <a href="#" class="btn btn-sm btn-warning btn-edit" data-json="${ JSON.stringify(data).toString().replaceAll('"', "'") }">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="#" class="btn btn-sm btn-danger btn-delete" data-json="${ JSON.stringify(data).toString().replaceAll('"', "'") }">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    `
                }
            }
        ],
        // detech page change
        drawCallback: function () {
            // action: edit
            $(".btn-edit").prop("onclick", null).off("click");
            $('.btn-edit').on('click', function () {
                const thisbutton = $(this)
                const data = JSON.parse(thisbutton.attr('data-json')?.replaceAll("'", '"'))

                const modalEditEl = document.querySelector('#modal')
                modalEditEl.setAttribute('data-json', thisbutton.attr('data-json'))
                modalEditEl.querySelector('.modal-title').innerHTML = `Edit Siswa "${data.name}"`

                // show modal
                $('#modal').modal({ show: true })

                // set button save onclick
                $("#modal-btn-save").prop("onclick", null).off("click")
                $('#modal-btn-save').on('click', () => save(data.nisn))

                // set form value
                $('#inputNISN').val(data.nisn);
                $('#inputName').val(data.name);
                $('#inputGender').val(data.gender);
                $('#inputGrade').val(data.grade.id);
                $('#inputGeneration').val(data.generation.id);
            });

            // action: delete
            $(".btn-delete").prop("onclick", null).off("click");
            $('.btn-delete').on('click', function () {
                const thisbutton = $(this);
                const data = JSON.parse(thisbutton.attr('data-json')?.replaceAll("'", '"'));

                // @feat/api-alert
                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: `Anda akan menghapus data siswa ${data.name} (${data.nisn})?`,
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
                            url: getCurrentUrl() + '/' + data.nisn,
                            headers: {
                                'X-CSRF-TOKEN': getCurrentCsrfToken(),
                                'Content-Type': 'application/json'
                            }
                        })
                            .then(function (response) {
                                // @feat/api-alert
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Sukses',
                                    text: 'Berhasil menghapus data',
                                })
                                tableEl.DataTable().ajax.reload(null, false);
                            })
                            .catch(function (error) {
                                // @feat/api-alert
                                Toast.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: 'Gagal menghapus data',
                                })
                            });
                    }
                });
            })
        }
    });
});

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
    $('#btnModalImportExcel').on('click', function () {
        $('#modalImportExcel').modal({ show: true })
    });
});
