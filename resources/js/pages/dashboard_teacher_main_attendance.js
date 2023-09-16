import axios from 'axios'
import {
    getCurrentCsrfToken,
    getCurrentUrl,
    datatableDynamicNumberColumn,
    getDataFormInputs,
    resetFormInputs,
    parseJsonToDataAttr,
    decodeFromJsonDataAttr,
} from './../utils/func'

// VARS
const tableEl = $('#table')
const modalTitle = 'Presensi'

// FUNCS
async function save(id) {
    // const data = JSON.stringify(getDataFormInputs([
    //     ['name', '#inputName'],
    //     ['point', '#inputPoint']
    // ]))
    const data = JSON.stringify({
        'generation_grade_id' : $('#inputGenerationGrade').val(),
        'date' : $('#inputDate').val()
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
    // const data = JSON.stringify(getDataFormInputs([
    //     ['name', '#inputName'],
    //     ['point', '#inputPoint']
    // ]))
    const data = JSON.stringify({
        'generation_grade_id' : $('#inputGenerationGrade').val(),
        'date' : $('#inputDate').val()
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
        console.log(http)
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

$(document).ready(function(){
    // select2
    $('.select2#inputGenerationGrade').select2({
        ajax: {
            url: getCurrentUrl() + '?list=generationGrades',
            dataType: 'json',
            delay: 250,
            cache: true,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        console.log(data);
                        return {
                            text: `${item.generationName} / ${item.gradeName}`,
                            id: item.id
                        }
                    })
                };
            },
        },
    })

    // date input
    $('#inputDateWrapper').datetimepicker({
        format: 'L'
    });

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
            { name: 'date', data: 'date', render: (data, type, row) => moment(data).format('DD MMMM YYYY') },
            { name: 'generation.name', data: 'generation.name' },
            { name: 'grade.name', data: 'grade.name' },
            { name: 'teacher.name', data: 'teacher.name' },
            {
                orderable: false,
                searchable: false,
                data: function (data) {
                    return `
                        <div class="">
                            <a href="${getCurrentUrl()}/${data.id}/data" class="btn btn-sm btn-primary btn-edit">
                                Detail
                            </a>
                            <a href="#" class="btn btn-sm btn-warning btn-edit" data-json="${ parseJsonToDataAttr(data) }">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="#" class="btn btn-sm btn-danger btn-delete" data-json="${ parseJsonToDataAttr(data) }">
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
                const data = decodeFromJsonDataAttr(thisbutton.attr('data-json'));

                const modalEditEl = document.querySelector('#modal')
                modalEditEl.setAttribute('data-json', thisbutton.attr('data-json'))
                modalEditEl.querySelector('.modal-title').innerHTML = `Edit ${modalTitle}`

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

                const generationGrade = data.generation.name + " / " + data.grade.name;
                console.log(generationGrade);
                $('.select2#inputGenerationGrade').append(new Option(generationGrade, '', true, true)).trigger('change')
                $('#inputDate').val(moment(data.date).format('L'))
            })

            // action: delete
            $(".btn-delete").prop("onclick", null).off("click");
            $('.btn-delete').on('click', function () {
                const thisbutton = $(this)
                const data = decodeFromJsonDataAttr(thisbutton.attr('data-json'));

                // @feat/api-alert
                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: `Anda akan menghapus data ${modalTitle}?`,
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
                })
            })
        }
    })

    // action: add
    $('#btn-add').on('click', function () {
        // reset value
        // resetFormInputs(['#inputDate'])
        $('.select2#inputGenerationGrade').select2('val', 0);
        $('#inputDate').val('');

        const modalEditEl = document.querySelector('#modal')
        modalEditEl.querySelector('.modal-title').innerHTML = `Tambah ${modalTitle}`
        $('#modal').modal({ show: true })
        $("#modal-btn-save").prop("onclick", null).off("click")
        $('#modal-btn-save').on('click', () => add())
    })
})
