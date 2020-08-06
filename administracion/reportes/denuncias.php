<?php


$mysqli = new mysqli( 'localhost:3306', 'root', '', 'mydb' );
$dsn = "mysql:host=localhost:3306;dbname=mydb;charset=utf8mb4";

$options = [
  PDO::ATTR_EMULATE_PREPARES   => false, // turn off emulation mode for "real" prepared statements
  PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //make the default fetch be an associative array
];
try {
    $pdo = new PDO($dsn, "root", "", $options);
} catch (Exception $e) {
    error_log($e->getMessage());
    exit('Something weird happened'); //something a user can understand
}

require('../pdf/fpdf.php');


$id = 42;
class pdf extends FPDF
{
	public function header()
	{
		$this->SetFillColor(9, 31,54);
		$this->Rect(0,0, 220, 50, 'F');
		$this->SetY(15);
		$this->SetX(75);
		$this->SetFont('Arial', 'B', 30);
		$this->SetTextColor(255,255,255);
		$this->Write(5, 'PUBLITODO');

	}

	public function footer()
	{
		$this->SetFillColor(9, 31,54);//20, 29,78
		$this->Rect(0, 250, 220, 50, 'F');
		$this->SetY(-20);
		$this->SetFont('Arial', 'B', 20);
		$this->SetTextColor(255,255,255);
		$this->SetX(120);
		$this->Write(5, 'PUBLITODO');
		$this->Ln();
		$this->SetX(120);
		$this->Write(5, 'PUBLITODO@gmail.com');
		$this->SetX(120);
		$this->Ln();
		$this->SetX(120);
		$this->Write(5, '+(503)7889-8787');
	}
}

$idDenuncias;
$fecha;
$cantidad;
$razones;
$idAnuncio;
$titulo;    
$precio;
$estado;
$denunciante;
$primerNombre;
$segundoNombre;
$primerApellido;
$segundoApellido;


$stmt = $mysqli -> prepare("SELECT d.idDenuncias, d.fecha, d.cantidad, d.razones, d.idAnuncios,a.titulo, d.estado, d.denunciante,p.primerNombre,p.segundoNombre,p.primerApellido,p.segundoApellido FROM denuncias d inner join anuncios a on a.idAnuncios=d.idAnuncios inner join persona p on p.idPersona=d.denunciante ORDER by d.fecha DESC");

// $stmt -> bind_param('i', $userId);
        $stmt -> execute();
        $stmt -> store_result();
        $stmt -> bind_result( 
        $idDenuncias,
		$fecha,
		$cantidad,
		$razones,
		$idAnuncios,
		$titulo,
		$estado,
		$denunciante,
		$primerNombre,
		$segundoNombre,
		$primerApellido,
		$segundoApellido
        );

$fpdf = new pdf('P','mm','letter',true);
$fpdf->AddPage('portrait', 'letter');
$fpdf->SetMargins(10,30,20,20);
$fpdf->SetFont('Arial', '', 14);
$fpdf->SetTextColor(255,255,255);

$fpdf->SetY(25);
$fpdf->SetX(90);
$fpdf->Write(5, 'Lista Denuncias ');
/*$fpdf->Ln();
$fpdf->SetX(90);
$fpdf->Write(5, 'Empresa ');
$fpdf->Ln();
$fpdf->SetX(120);
$fpdf->Write(5, 'Fecha de envío: ');
$fpdf->Ln();
$fpdf->SetX(120);
$fpdf->Write(5, 'Dirección: ');
$fpdf->Ln();
$fpdf->SetX(120);
$fpdf->Write(5, 'Ciudad: ');
*/
$fpdf->SetTextColor(0,0,0);
//$fpdf->Image('images/2.jpg', 20, 55);
$fpdf->SetFont('Arial', '', 9);
$fpdf->SetY(60);
$fpdf->SetTextColor(255,255,255);
$fpdf->SetFillColor(79,78,77);
$fpdf->Cell(10, 10, 'NO', 0, 0, 'C', 1);
$fpdf->Cell(40, 10, 'FECHA', 0, 0, 'C', 1);
$fpdf->Cell(40, 10, 'RAZONES', 0, 0, 'C', 1);
$fpdf->Cell(40, 10, 'ANUNCIO', 0, 0, 'C', 1);
$fpdf->Cell(40, 10,'DENUNCIANTE', 0, 0, 'C', 1);
$fpdf->Cell(20, 10, 'ESTADO', 0, 0, 'C', 1);
$fpdf->Ln();

$cantidad=1;

$fpdf->SetTextColor(0,0,0);
$fpdf->SetFillColor(255,255,255);
  while($stmt -> fetch()){
	$fpdf->Cell(10, 10, $cantidad  , 0, 0, 'C', 1);
	$fpdf->Cell(40, 10, $fecha, 0, 0, 'C', 1);
	$fpdf->Cell(40, 10, $razones, 0, 0, 'C', 1);
	$fpdf->Cell(40, 10, $titulo , 0, 0, 'C', 1);
	$fpdf->Cell(40, 10, $primerNombre." ".$segundoNombre." ".$primerApellido." ".$segundoApellido  , 0, 0, 'C', 1);
	$fpdf->Cell(20, 10, $estado , 0, 0, 'C', 1);
	$fpdf->Ln();
	$cantidad++;
	if ($cantidad==19) {
		# code...
		$fpdf->OutPut();
	}
}
$fpdf->OutPut();


