
//Cambia el campo de clase segun si es profesor o alumno
function campoClase() {
    var tipoUsuario = document.getElementById('tipo_usuario').value;
    var claseField = document.getElementById('clase_field');
    if (tipoUsuario === 'alumno') {
        claseField.style.display = 'block';
    } else {
        claseField.style.display = 'none';
    }
}

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

// Validación del nombre
function validarApellido1() {

    var nombreApellidos = document.getElementById("apellido1").value;
    var errorNombre = document.getElementById("error_apellido1");

    if (nombreApellidos.length === 0) {
        errorNombre.textContent = "El apellido no puede estar vacio.";
    } else if (!isNaN(nombreApellidos)) {
        errorNombre.textContent = "El apellido no pueden ser numerico.";
    } else if (nombreApellidos.length < 3) {
        errorNombre.textContent = "El apellido tiene que tener al menos 3 caracteres.";
    } else {
        errorNombre.textContent = ""; 
    }
}

// Validación del nombre
function validarApellido2() {

    var nombreApellidos = document.getElementById("apellido2").value;
    var errorNombre = document.getElementById("error_apellido2");

    if (nombreApellidos.length === 0) {
        errorNombre.textContent = "El apellido no puede estar vacio.";
    } else if (!isNaN(nombreApellidos)) {
        errorNombre.textContent = "El apellido no pueden ser numerico.";
    } else if (nombreApellidos.length < 3) {
        errorNombre.textContent = "El apellido tiene que tener al menos 3 caracteres.";
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
// Validación de eliminación de registro
function confirmarEliminar(id) {
    if (confirm("¿Estás seguro de que deseas eliminar este registro?")) {
        // Obtener el tipo de tabla (alumnos o profesores)
        var tabla = "<?php echo $tabla; ?>";
        // Redirigir a la página de eliminación con el ID correspondiente
        window.location.href = "../acciones/eliminar.php?id_" + tabla + "=" + id;
    }
}


