const drawer = document.getElementById('drawer');
const overlay = document.getElementById('overlay');
const form = document.getElementById('suspensionForm');

function showLoader() {
    document.getElementById('page-loader').style.display = "flex";
}

document.getElementById('openDrawer').addEventListener('click', () => {
    drawer.classList.add('open');
    overlay.classList.add('show');
});

document.getElementById('cancelDrawer').addEventListener('click', () => {
    drawer.classList.remove('open');
    overlay.classList.remove('show');
});

overlay.addEventListener('click', () => {
    drawer.classList.remove('open');
    overlay.classList.remove('show');
});

form.addEventListener('submit', function () {
    showLoader();
});