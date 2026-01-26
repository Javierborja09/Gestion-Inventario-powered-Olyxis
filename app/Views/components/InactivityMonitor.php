<div id="inactivity-modal" class="modal fade" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-body text-center p-4">
                <div class="display-4 text-warning mb-3">
                    <i class="bi bi-clock-history"></i>
                </div>
                <h5>¿Sigues ahí?</h5>
                <p class="text-muted">Tu sesión está a punto de expirar por inactividad.</p>
                <button type="button" class="btn btn-primary w-100 fw-bold" onclick="resetInactivity(true)">
                    SÍ, CONTINUAR TRABAJANDO
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    let inactivityTime = 0;
    const timeoutLimit = 5 * 60 * 1000;
    const warningTime = 4 * 60 * 1000;

    const modalElement = document.getElementById('inactivity-modal');
    const modal = new bootstrap.Modal(modalElement);

    function resetInactivity(isFromButton = false) {
        if (modalElement.classList.contains('show')) {
            if (isFromButton) {
                inactivityTime = 0;
                modal.hide();
            }
            return;
        }
        inactivityTime = 0;
    }

    window.onload = () => {
        document.onkeypress = () => resetInactivity(false);
        document.onclick = () => resetInactivity(false);
        document.onscroll = () => resetInactivity(false);
    };

    setInterval(() => {
        inactivityTime += 1000;

        if (inactivityTime >= warningTime && inactivityTime < timeoutLimit) {
            if (!modalElement.classList.contains('show')) {
                modal.show();
            }
        } else if (inactivityTime >= timeoutLimit) {
            window.location.href = "/logout";
        }
    }, 1000);
</script>