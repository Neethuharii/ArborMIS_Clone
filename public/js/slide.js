document.addEventListener('DOMContentLoaded', () => {

    const container = document.getElementById('slideoverContainer');
    if (!container) return;

    const slideTitle = document.getElementById('slideTitle');
    const dynamicContent = document.getElementById('slideDynamicContent');
    const editBtn = document.getElementById('nextBtn');

    let currentRow = null;

    function setSlideoverButtons({ showEdit = true, showBack = true }) {
        const editBtn = document.getElementById('nextBtn');
        const backBtn = document.getElementById('backBtn');

        if (editBtn) editBtn.style.display = showEdit ? 'block' : 'none';
        if (backBtn) backBtn.style.display = showBack ? 'block' : 'none';
    }

    document.querySelectorAll('.clickable-row').forEach(row => {
        row.addEventListener('click', () => {

            currentRow = row;
            const type = row.dataset.type;

            slideTitle.textContent = row.dataset.title;
            setSlideoverButtons({ showEdit: true, showBack: true });

            if (type === 'identity') {
                dynamicContent.innerHTML = `
                    <table class="details-table">
                        <tr><th>Legal First Name</th><td>${row.dataset.firstName || ''}</td></tr>
                        <tr><th>Legal Middle Name</th><td>${row.dataset.middleName || ''}</td></tr>
                        <tr><th>Legal Last Name</th><td>${row.dataset.lastName || ''}</td></tr>
                    </table>
                `;
            }
            else if (type === 'sex') {
                dynamicContent.innerHTML = `
                    <table class="details-table">
                        <tr><th>Gender</th><td>${row.dataset.genderType || ''}</td></tr>
                    </table>
                `;
            }
            else if (type === 'dob') {
                dynamicContent.innerHTML = `
                    <table class="details-table">
                        <tr><th>Date Of Birth</th><td>${row.dataset.dob || ''}</td></tr>
                    </table>
                `;
            }
            else if (type === 'country') {
                dynamicContent.innerHTML = `
                    <table class="details-table">
                        <tr><th>Country</th><td>${row.dataset.countryName || ''}</td></tr>
                    </table>
                `;
            }
            else if (type === 'ethnicity') {
                dynamicContent.innerHTML = `
                    <table class="details-table">
                        <tr><th>Ethnicity</th><td>${row.dataset.ethnicityName || ''}</td></tr>
                    </table>
                `;
            }
            else if (type === 'nationality') {
                dynamicContent.innerHTML = `
                    <table class="details-table">
                        <tr><th>Nationality</th><td>${row.dataset.nationalityStatus || ''}</td></tr>
                    </table>
                `;
            }
            else if (type === 'religion') {
                dynamicContent.innerHTML = `
                    <table class="details-table">
                        <tr><th>Religion</th><td>${row.dataset.religionName || ''}</td></tr>
                    </table>
                `;
            }
            else if (type === 'document') {
                slideTitle.textContent = 'Document';
                dynamicContent.innerHTML = `
                    <table class="details-table">
                        <tr><th>Document Type</th><td>${row.dataset.documentType || ''}</td></tr>
                    </table>
                `;
            }
            else if (type === 'abbreviation') {
                dynamicContent.innerHTML = `
                    <table class="details-table">
                        <tr><th>Abbreviation</th><td>${row.dataset.abbreviation || ''}</td></tr>
                    </table>
                `;
            }
            else {
                dynamicContent.innerHTML = `<p>No information available.</p>`;
            }

            container.classList.add('is-open');
        });
    });

    document.querySelectorAll(".open-slideover").forEach(item => {
        item.addEventListener("click", () => {

            const type = item.dataset.type;

            let templateId = "";
            let formId = "";
            if (type === "guardian") {

                slideTitle.textContent = "Add Guardian / Contact";

                setSlideoverButtons({
                    showEdit: false,
                    showBack: false
                });

                const tpl = document.getElementById("studentGuardianTemplate");

                if (!tpl) {
                    console.error("studentGuardianTemplate not found");
                    return;
                }

                const clone = tpl.content.cloneNode(true);

                dynamicContent.innerHTML = "";
                dynamicContent.appendChild(clone);

                container.classList.add("is-open");

                initialiseSaveForm("guardianForm", container);

                return; 
            }

            switch (type) {

                case "identification":
                    slideTitle.textContent = "Identification Document";
                    templateId = "identificationTemplate";
                    formId = "identificationForm";
                    break;

                case "schoolIdCard":
                    slideTitle.textContent = "School ID Card";
                    templateId = "studentCardTemplate";
                    formId = "schoolCardForm";
                    break;

                default:
                    console.warn("Unknown type:", type);
                    return;
            }

            const tpl = document.getElementById(templateId);

            if (!tpl) {
                console.error("Template not found:", templateId);
                return;
            }

            setSlideoverButtons({
                showEdit: true,
                showBack: true
            });

            dynamicContent.innerHTML = tpl.innerHTML;

            initialiseSaveForm(formId, container);

            container.classList.add("is-open");
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
                templateId = 'countryEditTemplate';
                formId = 'editCountryForm';
                break;

            case 'ethnicity':
                templateId = 'ethnicityEditTemplate';
                formId = 'editEthnicityForm';
                break;

            case 'nationality':
                templateId = 'nationalityEditTemplate';
                formId = 'editNationalityForm';
                break;

            case 'religion':
                templateId = 'religionEditTemplate';
                formId = 'editReligionForm';
                break;

            case 'abbreviation':
                templateId = 'abbreviationEditTemplate';
                formId = 'editAbbreviationForm';
                break;

            default:
                return;
        }

        const tpl = document.getElementById(templateId);

        if (!tpl) {
            console.error("Edit template not found:", templateId);
            return;
        }

        dynamicContent.innerHTML = tpl.innerHTML;

        initialiseSaveForm(formId, container);
    });

    document.getElementById('closeBtn')?.addEventListener('click', () => {
        container.classList.remove('is-open');
    });

    document.getElementById('slideoverOverlay')?.addEventListener('click', () => {
        container.classList.remove('is-open');
    });
});
