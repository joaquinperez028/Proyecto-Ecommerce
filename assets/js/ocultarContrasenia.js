function togglePassword() {
    const passwordField = document.getElementById('password');

    const toggleButton = document.getElementById('btnmostrar');


    if (passwordField && toggleButton) {
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            toggleButton.textContent = 'Ocultar';
        } else {
            passwordField.type = 'password';
            toggleButton.textContent = 'Mostrar';
        }
    }


}

function togglePassword2(){
    const passwordField2 = document.getElementById('password2');
    const toggleButton2 = document.getElementById('btnmostrar2');
    if (passwordField2 && toggleButton2) {
        if (passwordField2.type === 'password') {
            passwordField2.type = 'text';
            toggleButton2.textContent = 'Ocultar';
        } else {
            passwordField2.type = 'password';
            toggleButton2.textContent = 'Mostrar';
        }
    }
}
