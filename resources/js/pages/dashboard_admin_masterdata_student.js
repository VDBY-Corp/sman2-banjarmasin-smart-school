import axios from 'axios'

const getCurrentUrl = () => document.querySelector('meta[name="current-url"]').getAttribute('content')
const getCurrentCsrfToken = () => document.querySelector('meta[name="csrf-token"]').getAttribute('content')

async function save() {

    const originalData = JSON.parse(document.querySelector('#modal-edit').attr('data-json')?.replaceAll("'", '"'))
    console.log(originalData)

    // send api request post
    const http = await axios({
        method: 'post',
        url: getCurrentUrl(),
        headers: {
            'X-CSRF-TOKEN': getCurrentCsrfToken(),
            'Content-Type': 'application/json'
        },
        data: data
    })
    console.log(await http.json())

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
                    save()
                })

                // set form value
                document.querySelector('#inputName').value = data.name
            })
        }
    });
});
