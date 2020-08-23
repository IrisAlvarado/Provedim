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
		// alert('Llene los campos vacios');
		Swal.fire({
			icon: 'error',
			title: 'Los campos estan vacios',
			text: 'Inténtalo de nuevo',
		});
		return false;
	} else if (nombre.lenght > 45) {
		Swal.fire({
			icon: 'error',
			title: 'El nombre es muy largo',
			text: 'Inténtalo de nuevo',
		});
		return false;
	} else if (marca.lenght > 15) {
		Swal.fire({
			icon: 'error',
			title: 'El nombre de la marca es muy largo',
			text: 'Inténtalo de nuevo',
		});
		return false;
	} else if (descripcion.lenght > 45) {
		Swal.fire({
			icon: 'error',
			title: 'La descripción del producto es muy larga',
			text: 'Inténtalo de nuevo',
		});
		return false;
	} else if (isNaN(precio)) {
		Swal.fire({
			icon: 'error',
			title: 'El precio ingresado no es un número',
			text: 'Inténtalo de nuevo',
		});;
		return false;
	} else if (isNaN(cantidad)) {
		Swal.fire({
			icon: 'error',
			title: 'La cantidad ingresada no es un número',
			text: 'Inténtalo de nuevo',
		});
		return false;
	} else if (isNaN(codigo)) {
		alert('El cógido ingresado');
		return false;
	} else {
		return true;
	}
}
