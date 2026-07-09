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
            else if (type === 'idcard') {
                const issueDate = row.dataset.issueddate;
                const issueTime = row.dataset.issuedtime;
                const dateTimeDisplay = (issueDate && issueTime) ? `${issueDate} ${issueTime}` : 'N/A';
                dynamicContent.innerHTML = `
                    <table class="details-table">
                        <tr>
                            <th>Card Number</th>
                            <td>${row.dataset.idcard || ''}</td>
                        </tr>
                        <tr>
                            <th>Issued date/time</th>
                            <td>${dateTimeDisplay}</td>
                        </tr>
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
            else if (type === 'upn') {
                const upn = (row.dataset.upn || '').trim();
                container.classList.add('is-open');

                if (upn === '') {
                    slideTitle.textContent = "Assign UPN";
                    const tpl = document.getElementById("assignUpnTemplate");
                    if (!tpl) {
                        console.error("assignUpnTemplate not found");
                        return;
                    }
                    dynamicContent.innerHTML = tpl.innerHTML;
                    initialiseSaveForm("assignUpnForm", container);
                    setSlideoverButtons({ showEdit: false, showBack: true });
                    return;
                }

                slideTitle.textContent = "UPN";
                dynamicContent.innerHTML = `
                    <table class="details-table">
                        <tr>
                            <th>UPN</th>
                            <td>${upn}</td>
                        </tr>
                    </table>
                `;
                setSlideoverButtons({ showEdit: true, showBack: true });
                return;
            }
            else if (type === 'email') {
                dynamicContent.innerHTML = `
                    <table class="details-table">
                        <tr>
                            <th>Email</th>
                            <td>${row.dataset.email || ''}</td>
                        </tr>
                    </table>
                `;
            }
            else if (type === 'phoneNumber') {
                dynamicContent.innerHTML = `
                    <table class="details-table">
                        <tr>
                            <th>Staff Home Number</th>
                            <td>${row.dataset.phoneNumber || ''}</td>
                        </tr>
                    </table>
                `;
            }
            else if (type === 'currentRole') {
                dynamicContent.innerHTML = `
                    <table class="details-table">
                        <tr>
                            <th>Current Role</th>
                            <td>${row.dataset.currentRole || ''}</td>
                        </tr>
                        <tr>
                            <th>Start Date</th>
                            <td>${row.dataset.startDate || ''}</td>
                        </tr>
                    </table>
                `;
            }
            else if (type === 'funding') {
                slideTitle.textContent = "Student Funding";
                dynamicContent.innerHTML = `
                    <table class="details-table">
                        <tr>
                            <th>Funding Type</th>
                            <td>${row.cells[0].innerText}</td>
                        </tr>
                        <tr>
                            <th>Funding Period</th>
                            <td>${row.cells[1].innerText}</td>
                        </tr>
                    </table>
                `;

                setSlideoverButtons({
                    showEdit: true,
                    showBack: true
                });
                container.classList.add('is-open');
                return;
            }
            else if (type === 'address') {
                dynamicContent.innerHTML = `
                    <table class="details-table">
                        <tr>
                            <th>Address</th>
                            <td>${row.dataset.address1 || ''} ${row.dataset.address2 || ''} ${row.dataset.address3 || ''}</td>
                        </tr>
                        <tr>
                            <th>City</th>
                            <td>${row.dataset.city || ''}</td>
                        </tr>
                        <tr>
                            <th>County</th>
                            <td>${row.dataset.county || ''}</td>
                        </tr>
                        <tr>
                            <th>Post Code</th>
                            <td>${row.dataset.postCode || ''}</td>
                        </tr>
                    </table>
                `;
            }
            else if (type === 'check') {
                dynamicContent.innerHTML = `
                    <table class="details-table">
                        <tr>
                            <th>Check Type</th>
                            <td>${row.dataset.qualificationName || ''}</td>
                        </tr>
                        <tr>
                            <th>Clearance Level</th>
                            <td>${row.dataset.clearanceLevel || ''}</td>
                        </tr>
                        <tr>
                            <th>Requested Date</th>
                            <td>${row.dataset.requestedDate || ''}</td>
                        </tr>
                        <tr>
                            <th>Returned / Issued Date</th>
                            <td>${row.dataset.returnedDate || ''}</td>
                        </tr>
                        <tr>
                            <th>Authenticated Date</th>
                            <td>${row.dataset.authenticatedDate || ''}</td>
                        </tr>
                        <tr>
                            <th>Authenticated by staff</th>
                            <td>${row.dataset.authenticatedBy || ''}</td>
                        </tr>
                        <tr>
                            <th>Comment</th>
                            <td>${row.dataset.comment || ''}</td>
                        </tr>
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
                slideTitle.textContent = "Add Guardian";
                setSlideoverButtons({ showEdit: false, showBack: false });

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

                case "postalAddress":
                    slideTitle.textContent = "Postal Address";
                    templateId = "postalAddressTemplate";
                    formId = "postalAddressForm";
                    break;
                
                case 'upn':
                    if (!currentRow || (currentRow.dataset.upn || '').trim() === '') {
                        slideTitle.textContent = 'Assign UPN';
                        templateId = 'assignUpnTemplate';
                        formId = 'assignUpnForm';
                    } else {
                        slideTitle.textContent = 'Delete Current UPN';
                        templateId = 'deleteUpnTemplate';
                        formId = 'deleteUpnForm';
                    }
                    break; 

                case "funding":
                    slideTitle.textContent = "Add Student Funding";
                    templateId = "fundingCardTemplate";
                    formId = "fundingCardForm";
                    break; 

                case "role":
                    slideTitle.textContent = 'Assign Business Role';
                    templateId = 'roleAddTemplate';
                    formId = 'businessRole';
                    break;

                case 'qualification':
                    slideTitle.textContent = 'Add Check';
                    templateId = 'qualificationCheckTemplate';
                    formId = 'qualificationCheck';
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

            setSlideoverButtons({ showEdit: false, showBack: true });
            dynamicContent.innerHTML = tpl.innerHTML;

            if (type === 'qualification') {
                const qualificationId = item.dataset.id || '';
                const qualificationName = item.dataset.name || '';
                
                const idInput = dynamicContent.querySelector('#qualificationTypeId');
                const nameLabel = dynamicContent.querySelector('#selectedCheckTypeLabel');
                
                if (idInput) idInput.value = qualificationId;
                if (nameLabel) nameLabel.innerText = qualificationName;
            }

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

            case 'upn':
                templateId = 'upnEditTemplate';
                formId = 'editUpnForm';
                break;

            case 'email':
                slideTitle.textContent = 'Email';
                templateId = 'emailEditTemplate';
                formId = 'editEmailForm';
                break;
            
            case 'funding':
                templateId = 'fundingEditTemplate';
                formId = 'editFundingForm';
                break;

            case 'role':
                slideTitle.textContent = 'Assign Business Role';
                templateId = 'roleAddTemplate';
                formId = 'businessRole';
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
