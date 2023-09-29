import axios from 'axios';
import {
    getCurrentCsrfToken,
    getCurrentUrl,
    getDataFormInputs,
    mappingDataToFormInputs,
    resetFormInputs,
    parseJsonToDataAttr,
    decodeFromJsonDataAttr,
    datatableDynamicNumberColumn,
} from './../utils/func';

// VARS
const tableViolation = $('#tableViolation');
const tableAchievement = $('#tableAchievement');
const modalTitle = 'Siswa';

$(document).ready(function(){
    // console.log(student);
    //init: datatable
    // violation table
    tableViolation.DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: getCurrentUrl() + '?table=violations',
        columns: [
            { name: 'id', data: 'id', visible: false, targets: 0 }, // id for default sorts
            datatableDynamicNumberColumn, // custom func - made for dynamic number
            { name: 'violation.name', data: 'violation.name' },
            { name: 'violation.point', data: 'violation.point' },
            { name: 'teacher.name', data: 'teacher.name' },
            { name: 'date', data: 'date', render: (data, type, row) => moment(data).format('DD MMMM YYYY') }
        ],
        // detech page change
        drawCallback: function () {
        }
    });

    // achievement table
    tableAchievement.DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: getCurrentUrl() + '?table=achievements',
        columns: [
            { name: 'id', data: 'id', visible: false, targets: 0 }, // id for default sorts
            datatableDynamicNumberColumn, // custom func - made for dynamic number
            { name: 'achievement.name', data: 'achievement.name' },
            { name: 'achievement.point', data: 'achievement.point' },
            { name: 'date', data: 'date', render: (data, type, row) => moment(data).format('DD MMMM YYYY') }
        ],
        // detech page change
        drawCallback: function () {
        }
    });
});
