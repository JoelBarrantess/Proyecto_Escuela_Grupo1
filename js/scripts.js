function campoClase() {
    var Usuario = document.getElementById('tipo_usuario').value;
    var claseField = document.getElementById('clase_field');
    if (Usuario === 'alumno') {
        claseField.style.display = 'block';
    } else {
        claseField.style.display = 'none';
    }
}

// Validación del nombre
function validarNombre() {
    var nombre = document.getElementById("nombre").value;
    var errorNombre = document.getElementById("error_nombre");

    var regex = /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/;

    if (nombre.length === 0) {
        errorNombre.textContent = "El nombre no puede estar vacío.";
        return false;
    } else if (nombre.length < 3) {
        errorNombre.textContent = "El nombre tiene que tener al menos 3 caracteres.";
        return false;
    } else if (!regex.test(nombre)) {
        errorNombre.textContent = "El nombre no puede contener números ni caracteres especiales.";
        return false;
    } else {
        errorNombre.textContent = ""; 
        return true;
    }
}

// Validación del primer apellido
function validarApellido1() {
    var apellido1 = document.getElementById("apellido1").value;
    var errorApellido1 = document.getElementById("error_apellido1");

    var regex = /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/;

    if (apellido1.length === 0) {
        errorApellido1.textContent = "El apellido no puede estar vacío.";
        return false;
    } else if (apellido1.length < 3) {
        errorApellido1.textContent = "El apellido tiene que tener al menos 3 caracteres.";
        return false;
    } else if (!regex.test(apellido1)) {
        errorApellido1.textContent = "El apellido no puede contener números ni caracteres especiales.";
        return false;
    } else {
        errorApellido1.textContent = ""; 
        return true;
    }
}

// Validación del segundo apellido
function validarApellido2() {
    var apellido2 = document.getElementById("apellido2").value;
    var errorApellido2 = document.getElementById("error_apellido2");

    var regex = /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/;

    if (apellido2.length === 0) {
        errorApellido2.textContent = "El apellido no puede estar vacío.";
        return false;
    } else if (apellido2.length < 3) {
        errorApellido2.textContent = "El apellido tiene que tener al menos 3 caracteres.";
        return false;
    } else if (!regex.test(apellido2)) {
        errorApellido2.textContent = "El apellido no puede contener números ni caracteres especiales.";
        return false;
    } else {
        errorApellido2.textContent = ""; 
        return true;
    }
}

// Validación del DNI
function validarDNI() {
    var dni = document.getElementById('dni').value.trim();
    var errorDNI = document.getElementById('error_dni');

    var dniFormato = /^\d{8}[a-zA-Z]$/;
    var letras = 'TRWAGMYFPDXBNJZSQVHLCKET';
    var letraDNI = dni.charAt(8).toUpperCase();

    if (dni.length === 0) {
        errorDNI.innerHTML = "El campo no puede estar vacío.";
        return false;
    }

    if (!dniFormato.test(dni)) {
        errorDNI.innerHTML = "El campo debe tener un formato de DNI válido.";
        return false;
    }

    if (letras.charAt(parseInt(dni, 10) % 23) !== letraDNI) {
        errorDNI.innerHTML = "La letra del DNI no es válida.";
        return false;
    }

    errorDNI.innerHTML = "";
    return true;
}

// Validación del correo electrónico
function validarEmail() {
    var email = document.getElementById("email").value;
    var errorEmail = document.getElementById("error_email");

    if (email.trim().length === 0) {
        errorEmail.textContent = "El correo electrónico no puede estar vacío.";
        return false;
    } else if (!/\S+@\S+\.\S+/.test(email)) {
        errorEmail.textContent = "Introduce un correo electrónico válido.";
        return false;
    } else {
        errorEmail.textContent = "";
        return true;
    }
}

// Validación del tipo de usuario
function validarSeleccion() {
    var Usuario = document.getElementById("tipo_usuario").value;
    var errorUsuario = document.getElementById("error_usuario");

    if (Usuario === "") {
        errorUsuario.textContent = "Por favor, seleccione una opción para este campo.";
        return false;
    } else {
        errorUsuario.textContent = ""; 
        return true;
    }
}

function validarNumero() {
    var telefono = document.getElementById("telefono").value;
    var errorTelefono = document.getElementById("error_telefono");

    if (telefono.length === 0) {
        errorTelefono.textContent = "El teléfono no puede estar vacío.";
        return false;
    } else if (!/^\d{9}$/.test(telefono)) {
        errorTelefono.textContent = "El teléfono debe tener exactamente 9 dígitos.";
        return false;
    } else {
        errorTelefono.textContent = "";
        return true;
    }
}

// Función general de validación del formulario
function validarFormulario() {
    var nombreValido = validarNombre();
    var apellido1Valido = validarApellido1();
    var apellido2Valido = validarApellido2();
    var dniValido = validarDNI();
    var seleccionValida = validarSeleccion();
    var emailValido = validarEmail();
    var telefonoValido = validarNumero();

    return nombreValido && apellido1Valido && apellido2Valido && dniValido && seleccionValida && emailValido && telefonoValido;
}

// Añadir evento submit al formulario
document.getElementById("formulario_crear").addEventListener("submit", function(event) {
    if (!validarFormulario()) {
        event.preventDefault(); // Evita el envío del formulario si la validación falla
    }
});

//Funcion confirmar antes de eliminar

    function confirmarEliminar(id, tabla) {
        if (confirm("¿Estás seguro de que deseas eliminar este registro?")) {
            window.location.href = "../acciones/eliminar.php?" + tabla + "=" + id;
        }
    }

