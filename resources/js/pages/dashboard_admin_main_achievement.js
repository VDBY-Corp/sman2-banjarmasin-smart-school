import axios from 'axios'
import {
    getCurrentCsrfToken,
    getCurrentUrl,
    datatableDynamicNumberColumn,
    getDataFormInputs,
    resetFormInputs,
} from './../utils/func'

// VARS
const tableEl = $('#table')
const modalTitle = 'Pelanggaran'

// FUNCS
async function save(id) {
    // const data = JSON.stringify(getDataFormInputs([
    //     ['name', '#inputName'],
    //     ['point', '#inputPoint']
    // ]))
    const data = JSON.stringify({
        'student_id' : $('#inputStudent').val(),
        'achievement_id' : $('#inputAchievement').val()
    });

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
    // const data = JSON.stringify({
    //     'name' : document.querySelector('#inputName').value,
    //     'description': document.querySelector('#inputDescription').value,
    // })
    
    // const data = JSON.stringify(getDataFormInputs([
    //     ['name', '#inputName'],
    //     ['point', '#inputPoint']
    // ]))
    const data = JSON.stringify({
        'student_id' : $('#inputStudent').val(),
        'achievement_id' : $('#inputAchievement').val()
    });


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
        console.log(http);
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

$(document).ready(function(){
    // select2
    $('.select2#inputStudent').select2({
        ajax: {
            url: getCurrentUrl() + '?list=students',
            dataType: 'json',
            delay: 250,
            cache: true,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: `${item.name} (${item.nisn} / ${item.grade.name})`,
                            id: item.nisn
                        }
                    })
                };
            },
        },
    })
    $('.select2#inputAchievement').select2({
        ajax: {
            url: getCurrentUrl() + '?list=achievements',
            dataType: 'json',
            delay: 250,
            cache: true,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: `${item.name} (${item.category.name})`,
                            id: item.id
                        }
                    })
                };
            },
        },
    })

    // init: datatable
    tableEl.DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: getCurrentUrl(),
        // order: [[ 0, "asc" ]], // custom order column 0 ascending
        columns: [
            { name: 'id', data: 'id', visible: false, targets: 0 }, // id for default sorts
            datatableDynamicNumberColumn, // custom func - made for dynamic number
            { name: 'student.name', data: 'student.name' },
            { name: 'achievement.name', data: 'achievement.name' },
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
                modalEditEl.querySelector('.modal-title').innerHTML = `Edit ${modalTitle} "${data.name}"`

                // show modal
                $('#modal').modal({ show: true })

                // set button save onclick
                $("#modal-btn-save").prop("onclick", null).off("click")
                $('#modal-btn-save').on('click', () => save(data.id))

                // set form value
                // document.querySelector('#inputName').value = data.name
                // mappingDataToFormInputs(data, [
                //     ['#inputName', 'name'], // example if = data.name
                //     ['#inputPoint', 'point']
                //     // ['#inputName', 'user.name'], // example if nested = data.user.name
                // ])
                // select2
                $('.select2#inputStudent').append(new Option(data.student.name, data.student.nisn, true, true)).trigger('change')
                $('.select2#inputAchievement').append(new Option(data.achievement.name, data.achievement.id, true, true)).trigger('change')
                console.log(data.student.nisn);
                console.log(data.achievement.id);
            })

            // action: delete
            $(".btn-delete").prop("onclick", null).off("click");
            $('.btn-delete').on('click', function () {
                const thisbutton = $(this)
                const data = JSON.parse(thisbutton.attr('data-json')?.replaceAll("'", '"'))
                console.log(data.id);
                console.log(data.name)
                // @feat/api-alert
                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: `Anda akan menghapus data ${modalTitle} ${data.name}?`,
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
                                console.log(response);
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
                })
            })
        }
    })

    // action: add
    $('#btn-add').on('click', function () {
        // reset value
        // resetFormInputs(['#inputName', '#inputPoint'])
        // console.log('add');
        $('.select2#inputStudent').select2('val', 1);
        $('.select2#inputAchievement').select2('val', 0);

        const modalEditEl = document.querySelector('#modal')
        modalEditEl.querySelector('.modal-title').innerHTML = `Tambah ${modalTitle}`
        $('#modal').modal({ show: true })
        $("#modal-btn-save").prop("onclick", null).off("click")
        $('#modal-btn-save').on('click', () => add())
    })
})
