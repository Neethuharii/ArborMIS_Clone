document.addEventListener('DOMContentLoaded', () => {

    function setupModal(openId, modalId, closeClass) {

        const openBtn = document.getElementById(openId);
        const modal = document.getElementById(modalId);
        const closeBtn = modal?.querySelector(`.${closeClass}`);

        if (!openBtn || !modal) {
            return;
        }

        openBtn.addEventListener('click', () => {

            modal.style.display = 'block';

        });

        closeBtn?.addEventListener('click', () => {

            modal.style.display = 'none';

        });

        window.addEventListener('click', (event) => {

            if (event.target === modal) {
                modal.style.display = 'none';
            }

        });

    }

    setupModal(
        'identityAdd',
        'identityModal',
        'close'
    );

    setupModal(
        'contactAdd',
        'contactModal',
        'contactClose'
    );

    setupModal(
        'contactAddGuardian',
        'guardianContactModal',
        'guardianContactClose'
    );

    setupModal(
        'qualificationAdd',
        'qualificationModal',
        'qualificationClose'
    );

});
