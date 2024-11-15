document.querySelector('.imagenPrincipal').addEventListener('mousemove', function(e) {
    const imagen = e.currentTarget.querySelector('img');
    const rect = e.currentTarget.getBoundingClientRect();
    
    // Calcular la posición del mouse como porcentaje dentro del contenedor
    const x = ((e.clientX - rect.left) / rect.width) * 100;
    const y = ((e.clientY - rect.top) / rect.height) * 100;
    
    // Ajustar el origen de la transformación para enfocar donde se encuentra el mouse
    imagen.style.transformOrigin = `${x}% ${y}%`;
});

const imagenPrincipal = document.getElementById('imagenPrincipal');
const imagenesSecundarias = document.querySelectorAll('.secundaria');

imagenesSecundarias.forEach(img => {
    img.addEventListener('click', function() {
        const tempSrc = imagenPrincipal.src;
        imagenPrincipal.src = this.src;
        this.src = tempSrc;
    });
});
