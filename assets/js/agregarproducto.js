document.addEventListener('DOMContentLoaded', function() {
    const tipoStock = document.getElementById('tipoStock');
    const contenedorStockFisico = document.getElementById('contenedorStockFisico');
    const stockTalles = document.getElementById('stockTalles');
    const tallesCheckboxes = document.querySelectorAll('input[name="talles[]"]');

    // Maneja el cambio del tipo de stock
    tipoStock.addEventListener('change', function() {
        if (tipoStock.value === 'fisico') {
            contenedorStockFisico.style.display = 'block';
            actualizarCamposStock(); // Actualiza los campos al cambiar el tipo de stock
        } else {
            contenedorStockFisico.style.display = 'none';
            stockTalles.innerHTML = ''; // Limpiar los campos de stock cuando no es stock físico
        }
    });

    // Actualiza los campos de stock cuando los talles cambian
    tallesCheckboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', actualizarCamposStock);
    });

    function actualizarCamposStock() {
        stockTalles.innerHTML = ''; // Limpia los campos de stock anteriores

        tallesCheckboxes.forEach(function(checkbox) {
            if (checkbox.checked && tipoStock.value === 'fisico') {
                const label = document.createElement('label');
                label.textContent = `Cantidad para talle ${checkbox.value}:`;

                const input = document.createElement('input');
                input.type = 'number';
                input.name = `stock_${checkbox.value}`;
                input.min = 0;
                input.required = true; // Hacer el campo requerido solo si es stock físico

                stockTalles.appendChild(label);
                stockTalles.appendChild(input);
            }
        });
    }

    const Categoria = document.getElementById('categoriaProducto').value;
});

function validarFormulario() {

const Categoria = document.getElementById('categoriaProducto').value;
if(Categoria === ""){
    alert("Por favor, seleccione una categoria para el producto")
    return false;
}

const colores = document.querySelectorAll('input[name="colores[]"]:checked');
if (colores.length === 0) {
    alert("Por favor, seleccione al menos un color.");
    return false;
}

const talles = document.querySelectorAll('input[name="talles[]"]:checked');
if (talles.length === 0) {
    alert("Por favor, seleccione al menos un talle.");
    return false;
}

const tipoStock = document.getElementById('tipoStock').value;
if (tipoStock === "") {
    alert("Por favor, seleccione un tipo de stock.");
    return false;
}


return true;
}

