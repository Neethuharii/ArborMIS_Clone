let currentStudent = null;

document.addEventListener('DOMContentLoaded', () => {
    console.log("Attendance DOM Loaded");

    document.querySelectorAll('.absent').forEach(button => {
        button.addEventListener('click', () => {
            currentStudent = button.dataset.student;
            document.getElementById('modalStudentName').innerText = button.dataset.name;
            document.getElementById('attendanceType').value = 'absent';
            toggleAttendanceType();
            document.getElementById('attendanceModal').style.display = 'flex';
        });
    });

    document.querySelectorAll('.late').forEach(button => {
        button.addEventListener('click', () => {
            currentStudent = button.dataset.student;
            document.getElementById('modalStudentName').innerText = button.dataset.name;
            document.getElementById('attendanceType').value = 'late';
            toggleAttendanceType();
            document.getElementById('attendanceModal').style.display = 'flex';
        });
    });

    document.getElementById('attendanceType').addEventListener('change', toggleAttendanceType);
    document.getElementById('closeAttendanceModal').addEventListener('click', closeModal);
    document.getElementById('saveAttendanceButton').addEventListener('click', saveAttendance);

    document.querySelectorAll('.present').forEach(button => {
        button.addEventListener('click', () => {
            markPresent(button.dataset.student);
        });
    });

    document.querySelectorAll('.skip-btn').forEach(button => {
        button.addEventListener('click', () => {
            skipStudent(button.dataset.student);
        });
    });
});

function toggleAttendanceType() {
    const type = document.getElementById('attendanceType').value;

    if (type === 'absent') {
        document.getElementById('absenceSection').style.display = 'block';
        document.getElementById('lateSection').style.display = 'none';
    } else {
        document.getElementById('absenceSection').style.display = 'none';
        document.getElementById('lateSection').style.display = 'block';
    }
}

function closeModal() {
    document.getElementById('attendanceModal').style.display = 'none';
    currentStudent = null;
    document.getElementById('attendanceNote').value = '';
}

function markPresent(studentId) {
    fetch(document.getElementById('saveAttendanceUrl').value, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            studentId: studentId,
            attendanceType: 'present'
        })
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            alert(data.message);
            return;
        }

        updateStudentRow(studentId, 'row-present', data);
    })
    .catch(() => {
        alert('Unable to save attendance');
    });
}

function saveAttendance() {
    const type = document.getElementById('attendanceType').value;

    if (type === 'absent') {
        saveAbsent();
    } else {
        saveLate();
    }
}

function saveAbsent() {
    saveAttendanceRequest({
        studentId: currentStudent,
        attendanceType: 'absent',
        attendanceCodeId: document.getElementById('absenceCode').value,
        note: document.getElementById('attendanceNote').value
    });
}

function saveLate() {
    saveAttendanceRequest({
        studentId: currentStudent,
        attendanceType: 'late',
        attendanceCodeId: document.getElementById('lateCode').value,
        lateMinutes: document.getElementById('lateMinutes').value,
        note: document.getElementById('attendanceNote').value
    });
}

function saveAttendanceRequest(data) {
    fetch(document.getElementById('saveAttendanceUrl').value, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        if (!result.success) {
            alert(result.message);
            return;
        }

        updateStudentRow(
            data.studentId,
            data.attendanceType === 'absent'
                ? 'row-absent'
                : 'row-late',
            result
        );

        closeModal();
    })
    .catch(() => {
        alert('Unable to save attendance');
    });
}

function updateStudentRow(studentId, rowClass, data) {
    const row = document.getElementById('row-' + studentId);

    row.classList.remove('row-present', 'row-absent', 'row-late');
    row.classList.add(rowClass);

    document.getElementById('status-' + studentId).innerText =
        data.code && data.description
            ? data.code + ' - ' + data.description
            : 'Present';
}

function skipStudent(studentId) {
    const row = document.getElementById('row-' + studentId);

    row.classList.add('row-skipped');
    document.getElementById('status-' + studentId).innerText = 'Skipped';
}