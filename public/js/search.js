document.addEventListener("DOMContentLoaded", function () {

    function setupSearch(config) {

        const searchInput = document.getElementById(config.inputId);

        if (!searchInput) {
            return;
        }

        const tableBody = document.querySelector(config.tableBody);

        searchInput.addEventListener("keyup", function () {

            fetch(config.url + "?search=" + encodeURIComponent(this.value))
                .then(response => response.json())
                .then(data => {

                    tableBody.innerHTML = "";

                    if (data.length === 0) {
                        tableBody.innerHTML = `
                            <tr>
                                <td colspan="${config.colspan}" class="empty-row">
                                    No Records Found
                                </td>
                            </tr>
                        `;
                        return;
                    }

                    let html = "";

                    data.forEach(item => {
                        html += config.render(item);
                    });

                    tableBody.innerHTML = html;
                });

        });

    }

    setupSearch({
        inputId: "recent-search",
        tableBody: ".point-table tbody",
        url: "/recent-points/search",
        colspan: 5,
        render: (incident) => `
            <tr>
                <td>${incident.firstName} ${incident.lastName}</td>
                <td>${incident.incidentDate.split("T")[0]}</td>
                <td>${incident.category}</td>
                <td>${incident.points}</td>
                <td>${incident.narrative}</td>
            </tr>
        `
    });

    setupSearch({
        inputId: "statistics-search",
        tableBody: ".point-table tbody",
        url: "/total-points/search",
        colspan: 2,
        render: (student) => `
            <tr>
                <td>${student.firstName} ${student.lastName}</td>
                <td>${student.totalPoints}</td>
            </tr>
        `
    });

    setupSearch({
        inputId: "statistics-search",
        tableBody: ".statistics-table tbody",
        url: "/suspension-statistics/search",
        colspan: 3,
        render: (student) => `
            <tr>
                <td>${student.firstName} ${student.lastName}</td>
                <td>${student.totalSuspensions}</td>
                <td>${student.totalDaysLost}</td>
            </tr>
        `
    });

    setupSearch({
        inputId: "suspension-search",
        tableBody: ".suspension-table tbody",
        url: "/suspensions/search",
        colspan: 6,
        render: (suspension) => `
            <tr>
                <td>${suspension.firstName} ${suspension.lastName}</td>
                <td>${suspension.suspensionReason}</td>
                <td>${suspension.suspendedFrom.split("T")[0]}</td>
                <td>${suspension.suspendedUntil.split("T")[0]}</td>
                <td>${suspension.daysLost}</td>
                <td>${suspension.notes ?? ""}</td>
            </tr>
        `
    });

    setupSearch({
        inputId: "incident-search",
        tableBody: ".incident-table tbody",
        url: "/incidents/search",
        colspan: 4,
        render: (incident) => `
            <tr>
                <td>${incident.incidentDate} ${incident.incidentTime}</td>
                <td>${incident.categoryName}</td>
                <td>${incident.behaviourName}</td>
                <td>${incident.students}</td>
            </tr>
        `
    });
    
});