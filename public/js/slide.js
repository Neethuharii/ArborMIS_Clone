document.addEventListener('DOMContentLoaded', () => {

    const container = document.getElementById('slideoverContainer');
    const slideTitle = document.getElementById('slideTitle');
    const dynamicContent = document.getElementById('slideDynamicContent');
    const editBtn = document.getElementById('nextBtn');

    let currentRow = null;

    document.querySelectorAll('.clickable-row').forEach(row => {
        row.addEventListener('click', () => {
            currentRow = row;
            const type = row.dataset.type;
            slideTitle.textContent = row.dataset.title;
            editBtn.style.display = 'block';
            if (type === 'identity') {
                dynamicContent.innerHTML = `
                    <table class="details-table">
                        <tr>
                            <th>Legal First Name</th>
                            <td>${row.dataset.firstName || ''}</td>
                        </tr>

                        <tr>
                            <th>Legal Middle Name</th>
                            <td>${row.dataset.middleName || ''}</td>
                        </tr>

                        <tr>
                            <th>Legal Last Name</th>
                            <td>${row.dataset.lastName || ''}</td>
                        </tr>
                    </table>
                `;
            }

            else if (type === 'sex') {

                dynamicContent.innerHTML = `
                    <table class="details-table">
                        <tr>
                            <th>Gender</th>
                            <td>${row.dataset.genderType || ''}</td>
                        </tr>
                    </table>
                `;
            }

            else if (type === 'dob') {
                dynamicContent.innerHTML = `
                    <table class="details-table">
                        <tr>
                            <th>Date Of Birth</th>
                            <td>${row.dataset.dob || ''}</td>
                        </tr>
                    </table>
                `;
            }
            

            else {

                dynamicContent.innerHTML = `
                    <p>No information available.</p>
                `;
            }

            container.classList.add('is-open');
        });

    });

    editBtn.addEventListener('click', () => {

        if (!currentRow) {
            return;
        }

        const type = currentRow.dataset.type;

       if (type === 'identity') {

    slideTitle.textContent = 'Name';

    dynamicContent.innerHTML =
        document.getElementById('nameEditTemplate').innerHTML;

    initialiseSaveForm('editIdentityForm');
}

else if (type === 'sex') {

    slideTitle.textContent = 'Gender';

    dynamicContent.innerHTML =
        document.getElementById('genderEditTemplate').innerHTML;

    initialiseSaveForm('editGenderForm');
}

else if (type === 'dob') {

    slideTitle.textContent = 'dob';

    dynamicContent.innerHTML =
        document.getElementById('dobEditTemplate').innerHTML;

    initialiseSaveForm('editDobForm');
}
    });

    function initialiseSaveForm(formId) {

    const form = document.getElementById(formId);
    if (!form) return;

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const studentId = form.querySelector('[name="studentId"]').value;

        const formData = new FormData(form);

        try {
            const response = await fetch(`/student/${studentId}/update`, {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (result.success) {
                location.reload();
            }

        } catch (error) {
            console.error(error);
            alert('Unable to save changes');
        }
    });

    document.getElementById('cancelEdit')?.addEventListener('click', () => {
        container.classList.remove('is-open');
    });
}

    document.getElementById('closeBtn').addEventListener('click', () => {

        container.classList.remove('is-open');
    });

    document.getElementById('slideoverOverlay').addEventListener('click', () => {

        container.classList.remove('is-open');
    });

});
