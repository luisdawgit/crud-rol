<?php

namespace App\Service;

class PointAllocationService
{
    public function validarDistribucion(
        array $data,
        callable $resolverCategoria,
        array $distribucionEsperada,
        int $base = 0
    ): bool {

        $puntosPorCategoria = [];

        foreach ($data as $id => $nivel) {

            $categoria = $resolverCategoria($id);

            if (!isset($puntosPorCategoria[$categoria])) {
                $puntosPorCategoria[$categoria] = 0;
            }

            $puntosPorCategoria[$categoria] += ((int)$nivel) - $base;
        }

        $valores = array_values($puntosPorCategoria);

        sort($valores);
        sort($distribucionEsperada);

        return $valores === $distribucionEsperada;
    }

    public function validarTotal(
        array $data,
        int $totalEsperado,
        int $base = 0
    ): bool {

        $total = 0;

        foreach ($data as $nivel) {
            $total += ((int)$nivel) - $base;
        }

        return $total === $totalEsperado;
    }


}