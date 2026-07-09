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

});