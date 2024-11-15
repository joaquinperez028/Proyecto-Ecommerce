
    document.addEventListener("DOMContentLoaded", function() {
        const metodoPagoEfectivo = document.querySelector("input[name='opcionPago'][value='PagoLocal']");
        const envioDAC = document.querySelector("input[name='opcionEnvio'][value='EnvioDac']");
        const retiroLocal = document.querySelector("input[name='opcionEnvio'][value='RetiroEnLocal']");
        
        function verificarMetodoPago() {
            if (metodoPagoEfectivo.checked) {
                envioDAC.disabled = true;
                retiroLocal.checked = true;
            } else {
                envioDAC.disabled = false;
            }
        }
        
        metodoPagoEfectivo.addEventListener("change", verificarMetodoPago);
        document.querySelector("input[name='opcionPago'][value='Transferencia']").addEventListener("change", verificarMetodoPago);
    });