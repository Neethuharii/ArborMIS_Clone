document.addEventListener('DOMContentLoaded', () => {

    const slideOver = document.getElementById('registerSlideOver');
    const closeButton = document.getElementById('closeSlideOver');

    document.querySelectorAll('.register-link').forEach(link => {

        link.addEventListener('click', function (e) {
            e.preventDefault();

            document.getElementById('slideClassName').innerText = this.dataset.classname;
            document.getElementById('slideDate').innerText = this.dataset.date;
            document.getElementById('slideSession').innerText = this.dataset.session;
            document.getElementById('slideStaff').innerText = this.dataset.staff;
            document.getElementById('slideStatus').innerText = this.dataset.status;

            const openBtn = document.getElementById('openRegisterBtn');
            openBtn.href = `/register/${this.dataset.classroomId}/${this.dataset.date}/${this.dataset.session}`;
            openBtn.innerText = this.dataset.status === 'Attendance register not opened yet'
                ? 'Open Register'
                : 'Edit Register';

            slideOver.classList.add('open');
        });

    });

    closeButton.addEventListener('click', () => {
        slideOver.classList.remove('open');
    });

});