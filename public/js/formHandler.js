function initialiseSaveForm(formId, container = null) {

    const form = document.getElementById(formId);

    if (!form) {
        return;
    }

    form.addEventListener('submit', async function (e) {

        e.preventDefault();

        const formData = new FormData(form);

        let url = form.getAttribute('action');

        let entityId = form.querySelector('[name="entityId"]')?.value;
        let entityType = form.querySelector('[name="entityType"]')?.value;

        if (!entityId) {
            const staffId = form.querySelector('[name="staffId"]')?.value;
            if (staffId) {
                entityId = staffId;
                entityType = 'staff';
            }

            const studentId = form.querySelector('[name="studentId"]')?.value;
            if (studentId) {
                entityId = studentId;
                entityType = 'student';
            }
        }

       if (!url || url === '') {
            if (entityType === 'student') {
                url = `/student/${entityId}/update`;
            } else if (entityType === 'staff') {
                url = `/Staff/${entityId}/update`;
            } else {
                alert('Invalid entity type.');
                return;
            }
        }

        try {
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (result.success) {

                if (container) {
                    container.classList.remove('is-open');
                }

                location.reload();

            } else {
                alert(result.message || 'Unable to save.');
            }

        } catch (error) {
            console.error(error);
            alert('Unable to save changes.');
        }

    });

    form.querySelector('.cancel-btn')?.addEventListener('click', () => {

        if (container) {
            container.classList.remove('is-open');
        }

    });

}
