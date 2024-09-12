<?php
class Alumno {
    private $nombre;
    private $apellido;
    private $valorabonado;
    private $fecha;
    private $metodopago;
    // private $nombreConcepto;

    public function __construct($nombre, $apellido, $valorabonado, $fecha, $metodopago) {// $nombreConcepto
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->valorabonado = $valorabonado;
        $this->fecha = $fecha;
        $this->metodopago = $metodopago;
        // $this->nombreConcepto = $nombreConcepto;
    }

    public function toArray() {
        return array(
            'nombre' => $this->nombre,
            'apellido' => $this->apellido,
            'valorabonado' => $this->valorabonado,
            'fecha' => $this->fecha,
            'metodopago' => $this->metodopago,
            // 'nombreConcepto' => $this->nombreConcepto
        );
    }
}
?>
