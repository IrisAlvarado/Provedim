<?php

	class Productos{

		private $nombre;
		private $marca;
		private $descripcion;
        private $categoria;
		private $precio;
		private $cantidad;
		private $codigo;
		private $urlImagen;
        
		public function __construct($nombre,
					$marca,
					$descripcion,
                    $categoria,
                    $precio,
                    $cantidad,
					$codigo,
					$urlImagen
                    ){
			$this->nombre = $nombre;
			$this->marca = $marca;
			$this->descripcion = $descripcion;
            $this->categoria = $categoria;
			$this->precio = $precio;
			$this->cantidad = $cantidad;
			$this->codigo = $codigo;
			$this->urlImagen = $urlImagen;
		}
		public function getNombre(){
			return $this->nombre;
		}
		public function setNombre($nombre){
			$this->nombre = $nombre;
		}
		public function getMarca(){
			return $this->marca;
		}
		public function setMarca($marca){
			$this->marca = $marca;
		}
		public function getDescripcion(){
			return $this->descripcion;
		}
		public function setDescripcion($descripcion){
			$this->descripcion = $descripcion;
		}
		public function getCategoria(){
			return $this->categoria;
		}
		public function setCategoria($categoria){
			$this->categoria = $categoria;
        }
        public function getPrecio(){
			return $this->precio;
		}
		public function setPrecio($precio){
			$this->precio = $precio;
        }
        public function getCantidad(){
			return $this->cantidad;
		}
		public function setCantidad($cantidad){
			$this->cantidad = $cantidad;
        }
        public function getCodigo(){
			return $this->codigo;
		}
		public function setCodigo($codigo){
			$this->codigo = $codigo;
		}
		public function getUrlImagen(){
			return $this->urlImagen;
		}
		public function setUrlImagen($urlImagen){
			$this->urlImagen = $urlImagen;
		}

		public function guardarRegistroBase($conexion){
			$sql = sprintf("INSERT INTO productos(nombre, marca, descripcion, categoria, precio, cantidad, codigo, urlImagen) VALUES ('%s','%s','%s','%s','%s','%s','%s','%s');",
				$conexion->antiInyeccion($this->nombre),
				$conexion->antiInyeccion($this->marca),
				$conexion->antiInyeccion($this->descripcion),
                $conexion->antiInyeccion($this->categoria),
				$conexion->antiInyeccion($this->precio),
				$conexion->antiInyeccion($this->cantidad),
				$conexion->antiInyeccion($this->codigo),
				$conexion->antiInyeccion($this->urlImagen)
			);
			$resultado = $conexion->ejecutarConsulta($sql);			
		}
	}
?>