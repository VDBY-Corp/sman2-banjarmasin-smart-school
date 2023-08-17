import axios from 'axios'

const getCurrentUrl = () => document.querySelector('meta[name="current-url"]').getAttribute('content')
const getCurrentCsrfToken = () => document.querySelector('meta[name="csrf-token"]').getAttribute('content')

async function save(oldNisn) {

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
            method: 'put',
            url: getCurrentUrl(),
            headers: {
                'X-CSRF-TOKEN': getCurrentCsrfToken(),
                'Content-Type': 'application/json'
            },
            data: data
        })

        console.log(http)
    } catch (error) {
        console.log(error.response.data);
    }
    

    // refresn tab;e
}

// on dom content loaded
window.addEventListener('DOMContentLoaded', () => {
    $('#table').DataTable({
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
                            <a href="#" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    `
                }
            }
        ],
        // detech page change
        drawCallback: function () {
            $('.btn-edit').on('click', function () {
                const thisbutton = $(this)
                const data = JSON.parse(thisbutton.attr('data-json')?.replaceAll("'", '"'))

                document.querySelector('#modal-edit').setAttribute('data-json', thisbutton.attr('data-json'))

                $('#modal-edit').modal({ show: true })

                $('#modal-edit-btn-save').on('click', function () {
                    save(data.nisn)
                })

                // set form value
                document.querySelector('#inputNISN').value = data.nisn
                document.querySelector('#inputName').value = data.name
                document.querySelector('#inputGender').value = data.gender
                document.querySelector('#inputGrade').value = data.grade.id
                document.querySelector('#inputGeneration').value = data.generation.id
            })
        }
    });
});
