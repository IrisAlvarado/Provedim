function validarProducto() {
	var nombre, marca, descripcion, categoria, precio, cantidad, codigo;

	nombre = document.getElementById('txt-producto').value;
	marca = document.getElementById('txt-marca').value;
	descripcion = document.getElementById('txt-descripcion').value;
	categoria = document.getElementById('s-categoria').value;
	precio = document.getElementById('txt-precio').value;
	cantidad = document.getElementById('txt-cantidad').value;
	codigo = document.getElementById('txt-codigo').value;

	if (
		nombre === '' ||
		marca === '' ||
		descripcion === '' ||
		categoria === '' ||
		precio === '' ||
		cantidad === '' ||
		codigo === ''
	) {
		alert('Llene los campos vacios');
		return false;
	} else if (nombre.lenght > 45) {
		alert('El nombre del producto es muy largo');
		return false;
	} else if (marca.lenght > 15) {
		alert('El nombre de la marca es muy largo');
		return false;
	} else if (descripcion.lenght > 45) {
		alert('La descripción del producto es muy grande');
		return false;
	} else if (isNaN(precio)) {
		alert('El precio ingresado no es un número');
		return false;
	} else if (isNaN(cantidad)) {
		alert('La cantidad ingresada no es un número');
		return false;
	} else if (isNaN(codigo)) {
		alert('El cógido ingresado');
		return false;
	} else {
		return true;
	}
}
