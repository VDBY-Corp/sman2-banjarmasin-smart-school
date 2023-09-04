export const getCurrentUrl = () => document.querySelector('meta[name="current-url"]').getAttribute('content')
export const getCurrentCsrfToken = () => document.querySelector('meta[name="csrf-token"]').getAttribute('content')
export const datatableDynamicNumberColumn = {
    orderable: false,
    searchable: false,
    data: null,
    render: (data, type, row, meta) => meta.row + meta.settings._iDisplayStart + 1
}
export const getDataFormInputs = (formSelectors = []) => {
    const data = {}
    formSelectors.forEach(el => {
        const selector = el[1]
        const name = el[0]
        data[name] = document.querySelector(selector).value
    })
    return data
}
export const getValueFromObjWithNotation = (obj, notation) => {
    const notations = notation.split('.')
    let value = obj
    notations.forEach(el => {
        value = value[el]
    })
    return value
}
export const mappingDataToFormInputs = (data = {}, formSelectors = []) => {
    formSelectors.forEach(el => {
        const selector = el[0]
        const dataObjNotations = el[1]
        const value = getValueFromObjWithNotation(data, dataObjNotations)
        document.querySelector(selector).value = value
    })
}
export const resetFormInputs = (formSelectors = []) => {
    formSelectors.forEach(el => {
        const inputEl = document.querySelector(el)
        inputEl.value = ''
        console.log(el, inputEl);
    })
}
