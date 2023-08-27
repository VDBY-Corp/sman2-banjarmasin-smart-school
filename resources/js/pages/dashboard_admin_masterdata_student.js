import axios from 'axios'

const getCurrentUrl = () => document.querySelector('meta[name="current-url"]').getAttribute('content')
const getCurrentCsrfToken = () => document.querySelector('meta[name="csrf-token"]').getAttribute('content')

const tableEl = $('#table')

function myFunction() {
    // Your function logic here
    console.log("myFunction")
    alert("Button clicked!");
}

async function save(oldNisn) {
    console.log("save function")
    // const originalData = JSON.parse(document.querySelector('#modal-edit').attr('data-json')?.replaceAll("'", '"'))
    // console.log(originalData)
    const nisn = document.querySelector('#inputNISN').value
    const name = document.querySelector('#inputName').value
    const gender = document.querySelector('#inputGender').value
    const gradeId = document.querySelector('#inputGrade').value
    const generationId = document.querySelector('#inputGeneration').value
    // console.log("nisn lama : " + oldNisn);
    // console.log("nisn baru : " + nisn)
    // console.log("url : " + getCurrentUrl())
    const data = JSON.stringify({
        'old_nisn' : oldNisn,
        'new_nisn' : nisn,
        'name' : name,
        'gender' : gender,
        'grade_id' : gradeId,
        'generation_id' : generationId
    })

    // console.log(data);
    // await console.log(getCurrentCsrfToken());

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


    // refresh table
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

                $("#modal-edit-btn-save").prop("onclick", null).off("click");
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
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil menghapus data',
                                })
                                tableEl.DataTable().ajax.reload(null, false);
                            })
                            .catch(function (error) {
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
    $('#testButton').on('click', contoh)
});

function contoh() {
    // $('#toast-container').
}
