document.addEventListener("DOMContentLoaded", function () {

    const drawer = document.getElementById('drawer');
    const overlay = document.getElementById('overlay');
    const form = document.getElementById('incidentForm');

    const openBtn = document.getElementById('openDrawer');
    const cancelBtn = document.getElementById('cancelDrawer');

    const addInterventionBtn = document.getElementById('addInterventionRow');
    const interventionBody = document.getElementById('interventionBody');

    window.showLoader = function () {
        const loader = document.getElementById('page-loader');
        if (loader) {
            loader.style.display = "flex";
        }
    };

    if (openBtn && drawer && overlay) {
        openBtn.addEventListener('click', () => {
            drawer.classList.add('open');
            overlay.classList.add('show');
        });
    }

    if (cancelBtn && drawer && overlay) {
        cancelBtn.addEventListener('click', () => {
            drawer.classList.remove('open');
            overlay.classList.remove('show');
        });
    }

    if (overlay && drawer) {
        overlay.addEventListener('click', () => {
            drawer.classList.remove('open');
            overlay.classList.remove('show');
        });
    }

    if (form) {
        form.addEventListener('submit', function () {
            window.showLoader();
        });
    }
    if (addInterventionBtn && interventionBody) {
        addInterventionBtn.addEventListener('click', () => {

            const studentOptions = studentsData.map(student =>
                `<option value="${student.studentId}">
                    ${student.firstName} ${student.lastName}
                </option>`
            ).join('');

            const staffOptions = staffsData.map(staff =>
                `<option value="${staff.staffId}">
                    ${staff.firstName} ${staff.lastName}
                </option>`
            ).join('');

            const methodOptions = interventionMethodsData.map(method =>
                `<option value="${method.interventionId}">
                    ${method.interventionMethod}
                </option>`
            ).join('');

            const row = document.createElement('tr');

            row.innerHTML = `
                <td>
                    <select name="intervention_student[]" required>
                        <option value="">Select Student</option>
                        ${studentOptions}
                    </select>
                </td>
                <td>
                    <select name="intervention_staff[]" required>
                        <option value="">Select Staff</option>
                        ${staffOptions}
                    </select>
                </td>
                <td>
                    <select name="intervention_method[]" required>
                        <option value="">Select Method</option>
                        ${methodOptions}
                    </select>
                </td>
            `;

            interventionBody.appendChild(row);
        });
    }

});