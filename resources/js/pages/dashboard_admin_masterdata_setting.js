import axios from 'axios';
import {
    getCurrentCsrfToken,
    getCurrentUrl,
    datatableDynamicNumberColumn,
    getDataFormInputs,
    resetFormInputs,
    mappingDataToFormInputs,
} from '../utils/func';

// VARS
const modalTitle = 'Setting';

// FUNCS
async function save() {
    const idInput = ['#inputname', '#inputaddress', '#inputphone', '#inputemail', '#inputfax'];

    try {
        // send api request post for every data
        for (let i = 1; i <= 5; i++) {
            const data = JSON.stringify(getDataFormInputs([
                ['value', idInput[i - 1]],
            ]));
            console.log(data);
            const http = await axios({
                method: 'PUT',
                url: getCurrentUrl() + '/' + i,
                headers: {
                    'X-CSRF-TOKEN': getCurrentCsrfToken(),
                    'Content-Type': 'application/json'
                },
                data: data
            });
            // console.log(http);
        }
        // @feat/api-alert
        Toast.fire({
            icon: 'success',
            title: 'Sukses',
            text: 'Berhasil mengubah data',
        });
        // refresh page
        location.reload();
    } catch (error) {
        // @feat/api-alert
        Toast.fire({
            icon: 'error',
            title: 'Gagal',
            text: 'Gagal mengubah data',
        })
        console.log(error);
    }
}

// when web is ready
$(document).ready(function(){
    $('#btn-save'). on('click', () => save());
});
