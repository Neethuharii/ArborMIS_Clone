document.addEventListener('DOMContentLoaded', () => {

    const container = document.getElementById('slideoverContainer');

    if (!container) return;

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
            else if (type === 'country') {

                dynamicContent.innerHTML = `
                    <table class="details-table">
                        <tr>
                            <th>Country</th>
                            <td>${row.dataset.countryName || ''}</td>
                        </tr>
                    </table>
                `;
            }
            else if (type === 'ethnicity') {
                dynamicContent.innerHTML = `
                    <table class="details-table">
                        <tr>
                            <th>Ethnicity</th>
                            <td>${row.dataset.ethnicityName || ''}</td>
                        </tr>
                    </table>
                `;
            }
            else if (type === 'nationality') {
                dynamicContent.innerHTML = `
                    <table class="details-table">
                        <tr>
                            <th>Nationality</th>
                            <td>${row.dataset.nationalityStatus || ''}</td>
                        </tr>
                    </table>
                `;
            }
            else if (type === 'religion') {
                dynamicContent.innerHTML = `
                    <table class="details-table">
                        <tr>
                            <th>Religion</th>
                            <td>${row.dataset.religionName || ''}</td>
                        </tr>
                    </table>
                `;
            }
            else if (type === 'abbreviation') {
                dynamicContent.innerHTML = `
                    <table class="details-table">
                        <tr>
                            <th>Abbreviation</th>
                            <td>${row.dataset.abbreviation || ''}</td>
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

        if (!currentRow) return;

        const type = currentRow.dataset.type;

        let templateId = '';
        let formId = '';

        switch (type) {

            case 'identity':
                slideTitle.textContent = 'Name';
                templateId = 'nameEditTemplate';
                formId = 'editIdentityForm';
                break;

            case 'sex':
                slideTitle.textContent = 'Gender';
                templateId = 'genderEditTemplate';
                formId = 'editGenderForm';
                break;

            case 'dob':
                slideTitle.textContent = 'Date of Birth';
                templateId = 'dobEditTemplate';
                formId = 'editDobForm';
                break;

            case 'country':
                slideTitle.textContent = 'Country';
                templateId = 'countryEditTemplate';
                formId = 'editCountryForm';
                break;

            case 'ethnicity':
                slideTitle.textContent = 'Ethnicity';
                templateId = 'ethnicityEditTemplate';
                formId = 'editEthnicityForm';
                break;

            case 'nationality':
                slideTitle.textContent = 'Nationality';
                templateId = 'nationalityEditTemplate';
                formId = 'editNationalityForm';
                break;

            case 'religion':
                slideTitle.textContent = 'Religion';
                templateId = 'religionEditTemplate';
                formId = 'editReligionForm';
                break;
            
            case 'abbreviation':
                slideTitle.textContent = 'Abbreviation';
                templateId = 'abbreviationEditTemplate';
                formId = 'editAbbreviationForm';
                break;
    
            default:
                return;
        }

        dynamicContent.innerHTML =
            document.getElementById(templateId).innerHTML;

        initialiseSaveForm(formId, container);

    });

    document.getElementById('closeBtn')?.addEventListener('click', () => {
        container.classList.remove('is-open');
    });

    document.getElementById('slideoverOverlay')?.addEventListener('click', () => {
        container.classList.remove('is-open');
    });

});
