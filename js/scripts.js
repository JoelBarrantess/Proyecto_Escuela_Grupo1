// Validación del nombre
function validarNombre() {

    var nombreApellidos = document.getElementById("nombre").value;
    var errorNombre = document.getElementById("error_nombre");

    if (nombreApellidos.length === 0) {
        errorNombre.textContent = "El nombre no puede estar vacio.";
    } else if (!isNaN(nombreApellidos)) {
        errorNombre.textContent = "El nombre no pueden ser numerico.";
    } else if (nombreApellidos.length < 3) {
        errorNombre.textContent = "El nombre tiene que tener al menos 3 caracteres.";
    } else {
        errorNombre.textContent = ""; 
    }
}  

// Validación del campo de DNI
function validarDNI() {
    var dni = document.getElementById('dni');
    var dniValor = dni.value.trim();
    var errorDNI = document.getElementById('error_dni');

    var dniFormato = /^\d{8}[a-zA-Z]$/;
    var letras = 'TRWAGMYFPDXBNJZSQVHLCKET';
    var letraDNI = dniValor.charAt(8).toUpperCase();

    if (dniValor.length === 0) {
        errorDNI.innerHTML = "El campo no puede estar vacio.";
        return false;
    }

    if (!dniFormato.test(dniValor)) {
        errorDNI.innerHTML = "El campo debe tener un formato de DNI valido.";
        return false;
    }

    if (letras.charAt(parseInt(dniValor, 10) % 23) !== letraDNI) {
        errorDNI.innerHTML = "La letra del DNI no es valida.";
        return false;
    }

    errorDNI.innerHTML = "";
    return true;
}