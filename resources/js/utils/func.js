export const getCurrentUrl = () => document.querySelector('meta[name="current-url"]').getAttribute('content')
export const getCurrentCsrfToken = () => document.querySelector('meta[name="csrf-token"]').getAttribute('content')
