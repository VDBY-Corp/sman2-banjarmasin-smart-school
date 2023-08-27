import axios from 'axios'

const getCurrentUrl = () => document.querySelector('meta[name="current-url"]').getAttribute('content')
const getCurrentCsrfToken = () => document.querySelector('meta[name="csrf-token"]').getAttribute('content')

const tableEl = $('#table')

async function save(oldNisn) {
    console.log("save function")

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
        Swal.fire({
            icon: 'success',
            title: 'Berhasil mengubah data',
        }).then((result) => {
            if (result.isConfirmed) {
                tableEl.DataTable().ajax.reload(null, false);
            }
        })

        console.log(http)
    } catch (error) {
        // @feat/api-alert
        Swal.fire({
            icon: 'error',
            title: 'Gagal mengubah data',
        }).then((result) => {
            if (result.isConfirmed) {
                tableEl.DataTable().ajax.reload(null, false);
            }
        })
        // console.log(error.response.data);
        console.log(error);
    }
}

async function add() {
    console.log("function add siswa")
    const data = JSON.stringify({
        'nisn' : document.querySelector('#inputNISN').value,
        'name' : document.querySelector('#inputName').value,
        'gender' : document.querySelector('#inputGender').value,
        'grade_id' : document.querySelector('#inputGrade').value,
        'generation_id' : document.querySelector('#inputGeneration').value
    })
    console.log(data)

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
        Swal.fire({
            icon: 'success',
            title: 'Berhasil menambah data',
        }).then((result) => {
            if (result.isConfirmed) {
                tableEl.DataTable().ajax.reload(null, false);
            }
        })

        console.log(http)
    } catch (error) {
        // @feat/api-alert
        Swal.fire({
            icon: 'error',
            title: 'Gagal menambah data',
        }).then((result) => {
            if (result.isConfirmed) {
                tableEl.DataTable().ajax.reload(null, false);
            }
        })
        // console.log(error.response.data);
        console.log(error);
    }
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
            $(".btn-edit").prop("onclick", null).off("click");
            $('.btn-edit').on('click', function () {
                // document.getElementById('modal-edit-btn-save').removeAttribute("onclick");
                console.log("btn-edit")
                const thisbutton = $(this)
                const data = JSON.parse(thisbutton.attr('data-json')?.replaceAll("'", '"'))

                const modalEditEl = document.querySelector('#modal-edit')
                modalEditEl.setAttribute('data-json', thisbutton.attr('data-json'))
                modalEditEl.querySelector('.modal-title').innerHTML = `Edit Siswa "${data.name}"`

                $('#modal-edit').modal({ show: true })

                // $('#modal-edit-btn-save').on('click', function () {
                //     save(data.nisn)
                // })

                $("#modal-edit-btn-save").prop("onclick", null).off("click")
                $('#modal-edit-btn-save').on('click', () => save(data.nisn))

                // document.getElementById('modal-edit-btn-save').removeEventListener('click', function () {
                //     console.log("delete event listener dijalankan")
                //     save(data.nisn)
                // })

                // document.getElementById('modal-edit-btn-save').removeEventListener('click', myFunction)

                // console.log(data);

                // set form value
                document.querySelector('#inputNISN').value = data.nisn
                document.querySelector('#inputName').value = data.name
                document.querySelector('#inputGender').value = data.gender
                document.querySelector('#inputGrade').value = data.grade.id
                document.querySelector('#inputGeneration').value = data.generation.id
            })

            $(".btn-delete").prop("onclick", null).off("click");
            $('.btn-delete').on('click', function () {
                console.log("btn-delete")
                const thisbutton = $(this)
                const data = JSON.parse(thisbutton.attr('data-json')?.replaceAll("'", '"'))

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
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil menghapus data',
                                })
                                tableEl.DataTable().ajax.reload(null, false);
                            })
                            .catch(function (error) {
                                // @feat/api-alert
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal menghapus data',
                                })
                                console.log(error);
                            });
                    }
                })
            })
        }
    });
});


// when web is ready
$(document).ready(function(){
    console.log("document is ready")
    $('#btn-add').on('click', function () {
        console.log("masuk button add")

        // delete value
        document.querySelector('#inputNISN').value = ''
        document.querySelector('#inputName').value = ''
        document.querySelector('#inputGender').value = ''
        document.querySelector('#inputGrade').value = ''
        document.querySelector('#inputGeneration').value = ''

        const modalEditEl = document.querySelector('#modal-edit')
        modalEditEl.querySelector('.modal-title').innerHTML = `Tambah Siswa`
        $('#modal-edit').modal({ show: true })
        $("#modal-edit-btn-save").prop("onclick", null).off("click")
        $('#modal-edit-btn-save').on('click', () => add())
    });
});