<div id="inactivity-modal" class="modal fade" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="modalTitle" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-body text-center p-4">
                <div class="display-4 text-warning mb-3">
                    <i class="bi bi-clock-history"></i>
                </div>
                <h5 id="modalTitle" class="fw-bold">¿Sigues ahí?</h5>
                <p class="text-muted">Tu sesión está a punto de expirar por inactividad.</p>
                <button type="button" class="btn btn-primary w-100 fw-bold" onclick="resetInactivity(true)">
                    SÍ, CONTINUAR TRABAJANDO
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    const modalElement = document.getElementById('inactivity-modal');
    const bModal = new bootstrap.Modal(modalElement);
    
    const SEGUNDOS_PARA_AVISAR = 60;    
    const FRECUENCIA_CHEQUEO = 60000;

  async function sincronizarConMiddleware() {
    try {
        const response = await fetch('/session-status', { 
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            cache: 'no-store' 
        });

        if (response.status === 401) {
            window.location.href = "/logout?reason=timeout";
            return;
        }

        if (response.ok) {
            const data = await response.json();
            if (data.remaining <= 60 && data.remaining > 0) {
                if (!modalElement.classList.contains('show')) bModal.show();
            }
        }
    } catch (e) {
        console.error("Error al consultar el estado de la sesión");
    }
}

    async function resetInactivity(isFromButton = false) {
        if (isFromButton) {
            try {
                const res = await fetch('/session-status?reset=1', { 
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    cache: 'no-store'
                });
                
                if (res.status === 401) {
                    window.location.href = "/";
                    return;
                }
                
                if (res.ok) {
                    const data = await res.json();
                    bModal.hide();
                }
            } catch (e) {
                console.error("Error al intentar renovar la sesión:", e);
            }
        }
    }

    setInterval(sincronizarConMiddleware, FRECUENCIA_CHEQUEO);
    sincronizarConMiddleware();
</script>