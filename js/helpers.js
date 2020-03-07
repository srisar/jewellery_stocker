function errorMessage(message) {
    return `<span class="text-danger">${message}</span>`;
}

function successMessage(message) {
    return `<span class="text-success">${message}</span>`;
}

function infoMessage(message) {
    return `<span class="text-dark">${message}</span>`;
}

function reloadPage() {
    window.location.reload();
}



function getSiteUrl() {
    return `${window.location.protocol}//${window.location.hostname}`;

}


