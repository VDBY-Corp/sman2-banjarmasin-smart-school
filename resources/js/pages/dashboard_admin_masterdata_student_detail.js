import axios from 'axios';
import { 
    getCurrentCsrfToken, 
    getCurrentUrl,
    getDataFormInputs,
    mappingDataToFormInputs,
    resetFormInputs,
    parseJsonToDataAttr,
    decodeFromJsonDataAttr,
    datatableDynamicNumberColumn,
} from './../utils/func';

// VARS
const tableEl = $('#table');
const modalTitle = 'Siswa';

// FUNCS
async function save(id) {
    const data = JSON.stringify(getDataFormInputs([
        ['nisn', '#inputNISN'],
        ['name', '#inputName'],
        ['gender', '#inputGender'],
        ['grade_id', '#inputGrade'],
        ['generation_id', '#inputGeneration']
    ]));

    // send api request post
    try {
        const http = await axios({
            method: 'PUT',
            url: getCurrentUrl() + '/' + id,
            headers: {
                'X-CSRF-TOKEN': getCurrentCsrfToken(),
                'Content-Type': 'application/json'
            },
            data: data
        });
        // @feat/api-alert
        Toast.fire({
            icon: 'success',
            title: 'Sukses',
            text: 'Berhasil mengubah data',
        });
        tableEl.DataTable().ajax.reload(null, false);
    } catch (error) {
        // @feat/api-alert
        Toast.fire({
            icon: 'error',
            title: 'Gagal',
            text: 'Gagal mengubah data',
        });
        tableEl.DataTable().ajax.reload(null, false);
        console.log(error);
    }
}

async function add() {
    const data = JSON.stringify(getDataFormInputs([
        ['nisn', '#inputNISN'],
        ['name', '#inputName'],
        ['gender', '#inputGender'],
        ['grade_id', '#inputGrade'],
        ['generation_id', '#inputGeneration']
    ]));

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
        });
        // @feat/api-alert
        Toast.fire({
            icon: 'success',
            title: 'Sukses',
            text: 'Berhasil menambah data',
        });
        tableEl.DataTable().ajax.reload(null, false);
    } catch (error) {
        // @feat/api-alert
        Toast.fire({
            icon: 'error',
            title: 'Gagal',
            text: 'Gagal menambah data',
        });
        tableEl.DataTable().ajax.reload(null, false);
        console.log(error);
    }
}

$(document).ready(function(){
    // console.log(student);
    //init: datatable
    tableEl.DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: getCurrentUrl(),
        columns: [
            { name: 'id', data: 'id', visible: false, targets: 0 }, // id for default sorts
            datatableDynamicNumberColumn, // custom func - made for dynamic number
            { name: 'violation.name', data: 'violation.name' },
            { name: 'teacher.name', data: 'teacher.name' },
            { name: 'date', data: 'date', render: (data, type, row) => moment(data).format('DD MMMM YYYY') }
        ],
        // detech page change
        drawCallback: function () {
            // action: edit
            $(".btn-edit").prop("onclick", null).off("click");
            $('.btn-edit').on('click', function () {
                const thisbutton = $(this);
                const data = decodeFromJsonDataAttr(thisbutton.attr('data-json'));

                const modalEditEl = document.querySelector('#modal');
                modalEditEl.setAttribute('data-json', thisbutton.attr('data-json'));
                modalEditEl.querySelector('.modal-title').innerHTML = `Edit "${modalTitle}" "${data.name}"`;

                // show modal
                $('#modal').modal({ show: true });

                // set button save onclick
                $("#modal-btn-save").prop("onclick", null).off("click");
                $('#modal-btn-save').on('click', () => save(data.id));

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
                const data = decodeFromJsonDataAttr(thisbutton.attr('data-json'));

                // @feat/api-alert
                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: `Anda akan menghapus data ${modalTitle} ${data.name} (${data.nisn})?`,
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

    $('#btn-add').on('click', function () {
        // reset value
        resetFormInputs(['#inputNISN', '#inputName', '#inputGender', '#inputGrade', '#inputGeneration']);

        const modalEditEl = document.querySelector('#modal')
        modalEditEl.querySelector('.modal-title').innerHTML = `Tambah ${modalTitle}`
        $('#modal').modal({ show: true })
        $("#modal-btn-save").prop("onclick", null).off("click")
        $('#modal-btn-save').on('click', () => add())
    });
    $('#btnModalImportExcel').on('click', function () {
        $('#modalImportExcel').modal({ show: true })
    });
});
