$(function() {
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
            data: function() {
            return `
                <div class="">
                    <a href="#" class="btn btn-sm btn-warning">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="#" class="btn btn-sm btn-danger">
                        <i class="fas fa-trash"></i>
                    </a>
                </div>
            `
            }
        }
        ]
    });
});
