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
const modalTitle = 'Kelas';
const showTrashBtnEl = $('#btn-trash')
const getFilter = () => (showTrashBtnEl?.data('value') || "false") === "true" ? "showDeleted" : "show"

// FUNCS
async function save(id) {
    const data = JSON.stringify(getDataFormInputs([
        ['id', '#inputId'],
        ['name', '#inputName'],
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
        ['id', '#inputId'],
        ['name', '#inputName'],
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
    var table = tableEl.DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        // get current url from html meta set in "layouts/app-dashboard.blade.php"
        ajax: {
            url: getCurrentUrl(),
            data: function (d) {
                d.filter = getFilter()
            }
        },
        columns: [
            { name: 'id', data: 'id' },
            { name: 'name', data: 'name' },
            { name: 'teacher_id', data: 'teacher.name', searchable: false, orderable: false  },
            {
                orderable: false,
                searchable: false,
                data: function(data) {
                    if (getFilter() == 'showDeleted') {
                        return `
                            <div class="">
                                <a href="#" class="btn btn-sm btn-warning btn-restore" data-json="${ parseJsonToDataAttr(data) }">
                                    <i class="fas fa-undo"></i>
                                </a>
                                <a href="#" class="btn btn-sm btn-danger btn-permanent-delete" data-json="${ parseJsonToDataAttr(data) }">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        `;
                    }
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
                $('.select2#inputTeacherId').append(new Option(data.teacher.name, data.teacher.id, true, true)).trigger('change')
                mappingDataToFormInputs(data, [
                    ['#inputId', 'id'],
                    ['#inputName', 'name'],
                ]);
            });

            // acton: delete
            $(".btn-delete").prop("onclick", null).off("click");
            $('.btn-delete').on('click', function () {
                const thisbutton = $(this);
                const data = decodeFromJsonDataAttr(thisbutton.attr('data-json'));

                // @feat/api-alert
                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: `Anda akan menghapus data ${modalTitle} ${data.name} (${data.id})?`,
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

            // action: restore
            $('.btn-restore').prop('onclick', null).off('click');
            $('.btn-restore').on('click', function () {
                const thisbutton = $(this);
                const data = decodeFromJsonDataAttr(thisbutton.attr('data-json'));

                // @feat/api-alert
                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: `Anda akan memulihkan data ${modalTitle} ${data.name} ?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, pulihkan!',
                    cancelButtonText: 'Tidak, batalkan'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // send api request post
                        axios({
                            method: 'PUT',
                            url: getCurrentUrl() + '/restore/' + data.id,
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
                                text: 'Berhasil memulihkan data',
                            })
                            tableEl.DataTable().ajax.reload(null, false);
                        })
                        .catch(function (error) {
                            // @feat/api-alert
                            Toast.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Gagal memulihkan data',
                            })
                        });
                    }
                });
            });

            // action: permanent delete
            $('.btn-permanent-delete').prop('onclick', null).off('click');
            $('.btn-permanent-delete').on('click', function () {
                const thisbutton = $(this);
                const data = decodeFromJsonDataAttr(thisbutton.attr('data-json'));

                // @feat/api-alert
                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: `Anda akan menghapus permanen data ${modalTitle} ${data.name} ?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus permanen!',
                    cancelButtonText: 'Tidak, batalkan'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // send api request post
                        axios({
                            method: 'DELETE',
                            url: getCurrentUrl() + '/permanent-delete/' + data.id,
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
                                text: 'Berhasil menghapus permanen data',
                            })
                            tableEl.DataTable().ajax.reload(null, false);
                        })
                        .catch(function (error) {
                            // @feat/api-alert
                            Toast.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Gagal menghapus permanen data',
                            })
                        });
                    }
                });
            });
        }
    });

    showTrashBtnEl.on('click', function() {
        const $this = $(this)
        if ($this.data('value') === "true") {
            $this.addClass('btn-default')
            $this.removeClass('btn-danger')
        } else {
            $this.addClass('btn-danger')
            $this.removeClass('btn-default')
        }
        $this.data('value', ($this.data('value') === "true") ? "false" : "true")
        table.draw();
    });

    // action: add
    $('#btn-add').on('click', function () {
        // reset value
        resetFormInputs(['#inputId', '#inputName', '#inputTeacherId']);

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
