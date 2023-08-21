import axios from 'axios'

const getCurrentUrl = () => document.querySelector('meta[name="current-url"]').getAttribute('content')
const getCurrentCsrfToken = () => document.querySelector('meta[name="csrf-token"]').getAttribute('content')

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
        // console.log(error.response.data);
        console.log(error);
    }
    

    // refresh table
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
            console.log("drawCallBack")
            $('.btn-edit').on('click', function () {
                // document.getElementById('modal-edit-btn-save').removeAttribute("onclick");
                console.log("btn-edit")
                const thisbutton = $(this)
                const data = JSON.parse(thisbutton.attr('data-json')?.replaceAll("'", '"'))

                document.querySelector('#modal-edit').setAttribute('data-json', thisbutton.attr('data-json'))

                $('#modal-edit').modal({ show: true })

                // $('#modal-edit-btn-save').on('click', function () {
                //     save(data.nisn)
                // })

                const wrapperFunction = () => save(data.nisn)
                const storedWrapperFunction = wrapperFunction

                // document.getElementById('modal-edit-btn-save').removeEventListener('click', wrapperFunction)
                document.getElementById('modal-edit-btn-save').addEventListener('click', wrapperFunction)

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
