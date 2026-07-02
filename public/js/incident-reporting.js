document.addEventListener("DOMContentLoaded", function () {

    const drawer = document.getElementById("drawer");
    const overlay = document.getElementById("overlay");
    const form = document.getElementById("incidentForm");

    const openBtn = document.getElementById("openDrawer");
    const cancelBtn = document.getElementById("cancelDrawer");

    const addInterventionBtn = document.getElementById("addInterventionRow");
    const interventionBody = document.getElementById("interventionBody");

    function showLoader() {
        document.getElementById("page-loader").style.display = "flex";
    }

    function hideLoader() {
        document.getElementById("page-loader").style.display = "none";
    }

    function closeDrawer() {
        drawer.classList.remove("open");
        overlay.classList.remove("show");
    }

    openBtn.addEventListener("click", () => {
        drawer.classList.add("open");
        overlay.classList.add("show");
    });

    cancelBtn.addEventListener("click", closeDrawer);
    overlay.addEventListener("click", closeDrawer);

    addInterventionBtn.addEventListener("click", () => {

        const studentOptions = studentsData.map(student =>
            `<option value="${student.studentId}">
                ${student.firstName} ${student.lastName}
            </option>`
        ).join("");

        const staffOptions = staffsData.map(staff =>
            `<option value="${staff.staffId}">
                ${staff.firstName} ${staff.lastName}
            </option>`
        ).join("");

        const methodOptions = interventionMethodsData.map(method =>
            `<option value="${method.interventionId}">
                ${method.interventionMethod}
            </option>`
        ).join("");

        const row = document.createElement("tr");

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

    form.addEventListener("submit", async function (e) {
        e.preventDefault();

        showLoader();

        const formData = new FormData(form);

        try {
            const response = await fetch(form.action, {
                method: "POST",
                body: formData
            });

            const result = await response.json();

            hideLoader();

            if (result.success) {
                addIncidentToTable(result.incident);
                form.reset();
                closeDrawer();
            }

        } catch (error) {
            hideLoader();
        }
    });

    function addIncidentToTable(incident) {
        const tbody = document.querySelector(".incident-table tbody");

        const row = document.createElement("tr");

        row.innerHTML = `
            <td>${incident.incidentDate} ${incident.incidentTime}</td>
            <td>${incident.severity}</td>
            <td>${incident.behaviour}</td>
            <td>${incident.students.join(" and ")}</td>
        `;

        tbody.prepend(row);
    }
});