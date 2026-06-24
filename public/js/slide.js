document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('slideoverContainer');
    const slideTitle = document.getElementById('slideTitle');
    const dynamicContent = document.getElementById('slideDynamicContent');

    document.querySelectorAll('.clickable-row').forEach(row => {
        row.addEventListener('click', () => {
            slideTitle.textContent = row.dataset.title;

            dynamicContent.innerHTML = '';

            const type = row.dataset.type;

            if (type === 'identity') {
                dynamicContent.innerHTML = `
                    <table>
                        <tr><th>Title</th><td>${row.dataset.titleName || ''}</td></tr>
                        <tr><th>Legal First name</th><td>${row.dataset.firstName || ''}</td></tr>
                        <tr><th>Preferred First name</th><td>${row.dataset.firstName || ''}</td></tr>
                        <tr><th>Legal Middle names</th><td>${row.dataset.middleName || ''}</td></tr>
                        <tr><th>Legal Last name</th><td>${row.dataset.lastName || ''}</td></tr>
                        <tr><th>Preferred Last name</th><td>${row.dataset.lastName || ''}</td></tr>
                    </table>
                `;
            } else if (type === 'sex') {
                dynamicContent.innerHTML = `
                    <table>
                        <tr><th>Gender Type</th><td>${row.dataset.genderType || ''}</td></tr>
                    </table>
                `;
            } else if (type === 'dob') {
                dynamicContent.innerHTML = `
                    <table>
                        <tr><th>Date of Birth</th><td>${row.dataset.dob || ''}</td></tr>
                    </table>
                `;
            }

            container.classList.add('is-open');
        });
    });

    document.getElementById('closeBtn').addEventListener('click', () => {
        container.classList.remove('is-open');
    });

    document.getElementById('slideoverOverlay').addEventListener('click', () => {
        container.classList.remove('is-open');
    });
});
