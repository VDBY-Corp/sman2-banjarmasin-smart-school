import axios from 'axios';
import {
    getCurrentCsrfToken,
    getCurrentUrl,
    datatableDynamicNumberColumn,
    getDataFormInputs,
    resetFormInputs,
    mappingDataToFormInputs,
    parseJsonToDataAttr,
    decodeFromJsonDataAttr,
} from './../utils/func';

// VARS
const tableEl = $('#table');
const modalTitle = 'Angkatan Kelas Guru';

// FUNCS
async function save(id) {
    const data = JSON.stringify(getDataFormInputs([
        ['generation_id', '#inputGenerationId'],
        ['grade_id', '#inputGradeId'],
        ['teacher_id', '#inputTeacherId'],
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
        })
        // @feat/api-alert
        Toast.fire({
            icon: 'success',
            title: 'Sukses',
            text: 'Berhasil mengubah data',
        })
        tableEl.DataTable().ajax.reload(null, false);
    } catch (error) {
        // @feat/api-alert
        Toast.fire({
            icon: 'error',
            title: 'Gagal',
            text: 'Gagal mengubah data',
        })
        tableEl.DataTable().ajax.reload(null, false);
        console.log(error);
    }
}

async function add() {
    const data = JSON.stringify(getDataFormInputs([
        ['generation_id', '#inputGenerationId'],
        ['grade_id', '#inputGradeId'],
        ['teacher_id', '#inputTeacherId'],
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
        })
        // @feat/api-alert
        Toast.fire({
            icon: 'success',
            title: 'Sukses',
            text: 'Berhasil menambah data',
        })
        tableEl.DataTable().ajax.reload(null, false);
    } catch (error) {
        // @feat/api-alert
        Toast.fire({
            icon: 'error',
            title: 'Gagal',
            text: 'Gagal menambah data',
        })
        tableEl.DataTable().ajax.reload(null, false);
        console.log(error);
    }
}

// when web is ready
$(document).ready(function(){
    // select2
    $('.select2#inputGenerationId').select2({
        ajax: {
            url: getCurrentUrl() + '?list=generations',
            dataType: 'json',
            delay: 250,
            cache: true,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: `${item.name}`,
                            id: item.id
                        }
                    })
                };
            },
        },
    });

    $('.select2#inputGradeId').select2({
        ajax: {
            url: getCurrentUrl() + '?list=grades',
            dataType: 'json',
            delay: 250,
            cache: true,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: `${item.name}`,
                            id: item.id
                        }
                    })
                };
            },
        },
    });

    $('.select2#inputTeacherId').select2({
        ajax: {
            url: getCurrentUrl() + '?list=teachers',
            dataType: 'json',
            delay: 250,
            cache: true,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: `${item.name} (${item.nip})`,
                            id: item.id
                        }
                    })
                };
            },
        },
    });

    // init: datatable
    tableEl.DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        // get current url from html meta set in "layouts/app-dashboard.blade.php"
        ajax: getCurrentUrl(),
        columns: [
            { name: 'generation_id', data: 'generation.name' },
            { name: 'grade_id', data: 'grade.name' },
            { name: 'teacher_id', data: 'teacher.name' },
            {
                orderable: false,
                searchable: false,
                data: function(data) {
                    return `
                        <div class="">
                            <a href="#" class="btn btn-sm btn-warning btn-edit" data-json="${ parseJsonToDataAttr(data) }">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="#" class="btn btn-sm btn-danger btn-delete" data-json="${ parseJsonToDataAttr(data) }">
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
                const data = decodeFromJsonDataAttr(thisbutton.attr('data-json'));

                const modalEditEl = document.querySelector('#modal');
                modalEditEl.setAttribute('data-json', thisbutton.attr('data-json'));
                modalEditEl.querySelector('.modal-title').innerHTML = `Edit ${modalTitle} "${data.name}"`;

                // show modal
                $('#modal').modal({ show: true });

                // set button save onclick
                $('#modal-btn-save').prop("onclick", null).off("click");
                $('#modal-btn-save').on('click', () => save(data.id));

                // set form value
                // select2
                $('.select2#inputGenerationId').append(new Option(data.generation.name, data.generation.id, true, true)).trigger('change')
                $('.select2#inputGradeId').append(new Option(data.grade.name, data.grade.id, true, true)).trigger('change')
                $('.select2#inputTeacherId').append(new Option(data.teacher.name, data.teacher.id, true, true)).trigger('change')
            });

            // acton: delete
            $(".btn-delete").prop("onclick", null).off("click");
            $('.btn-delete').on('click', function () {
                const thisbutton = $(this);
                const data = decodeFromJsonDataAttr(thisbutton.attr('data-json'));

                // @feat/api-alert
                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: `Anda akan menghapus data ${modalTitle} ${data.generation.name}, ${data.grade.name}, ${data.teacher.name} ?`,
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
            });
        }
    });

    // action: add
    $('#btn-add').on('click', function () {
        // reset value
        // resetFormInputs(['#inputGenerationId', '#inputGradeId', '#inputTeacherId']);
        $('.select2#inputGenerationId').select2('val', 0);
        $('.select2#inputGradeId').select2('val', 0);
        $('.select2#inputTeacherId').select2('val', 0);

        const modalEditEl = document.querySelector('#modal')
        modalEditEl.querySelector('.modal-title').innerHTML = `Tambah ${modalTitle}`
        $('#modal').modal({ show: true })
        $("#modal-btn-save").prop("onclick", null).off("click")
        $('#modal-btn-save').on('click', () => add())
    });

    // action: import excel
    $('#btnModalImportExcel').on('click', function () {
        $('#modalImportExcel').modal({
            show: true
        })
    });
});
