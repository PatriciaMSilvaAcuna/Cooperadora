<?php
class Alumno {
    private $nombre;
    private $apellido;
    private $valorAbonado;
    private $fecha;
    private $tipoDePago;
    // private $nombreConcepto;

    public function __construct($nombre, $apellido, $valorAbonado, $fecha, $tipoDePago) {// $nombreConcepto
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->valorAbonado = $valorAbonado;
        $this->fecha = $fecha;
        $this->tipoDePago = $tipoDePago;
        // $this->nombreConcepto = $nombreConcepto;
    }

    public function toArray() {
        return array(
            'nombre' => $this->nombre,
            'apellido' => $this->apellido,
            'valorAbonado' => $this->valorAbonado,
            'fecha' => $this->fecha,
            'tipoDePago' => $this->tipoDePago,
            // 'nombreConcepto' => $this->nombreConcepto
        );
    }
}
?>
