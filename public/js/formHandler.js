function initialiseSaveForm(formId, container = null) {

    const form = document.getElementById(formId);

    if (!form) {
        return;
    }

    form.addEventListener('submit', async function (e) {

        e.preventDefault();

        const formData = new FormData(form);

        const studentField = form.querySelector('[name="studentId"]');
        const staffField = form.querySelector('[name="staffId"]');

        let url = '';

        if (studentField) {
            url = `/student/${studentField.value}/update`;
        } else if (staffField) {
            url = `/staff/${staffField.value}/update`;
        } else {
            alert('No ID found.');
            return;
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
