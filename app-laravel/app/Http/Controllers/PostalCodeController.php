<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PostalCodeController extends Controller
{

    public function searchPostalCode($code){

        Log::debug("Peticion realizada");

        $path = storage_path() . "/codes.txt";

        $file = file_get_contents($path);

        $rows = explode("\n", $file);

        $codeData = [];
        $settlements = [];
        $findCode = false;
        foreach($rows as $row){

            $data = explode("|", $row);

            // $data[0] is a postal code
            if($data[0] == $code){
                
                $codeData = [
                    'zip_code' => $code,
                    'locality' => $this->eliminar_tildes(mb_strtoupper($data[5])),
                    'federal_entity' => [
                        'key'  => (int) $data[7],
                        'name' => $this->eliminar_tildes(mb_strtoupper($data[4])),
                        'code' => null
                    ],
                    'settlements' => [],
                    'municipality' => [
                        'key'  => (int) $data[11],
                        'name' => $this->eliminar_tildes(mb_strtoupper($data[3]))
                    ]
                ];

                $settlements[] = [
                    'key'       => (int) $data[12],
                    'name'      => $this->eliminar_tildes(mb_strtoupper($data[1])),
                    'zona_type' => $this->eliminar_tildes(mb_strtoupper($data[13])),
                    'settlement_type' => [
                        'name' => $this->eliminar_tildes($data[2])
                    ]
                ];

                $findCode = true;

            }


            if($findCode){
                if($data[0] != $code){
                    break;
                }
            }

        }

        if($codeData == []){
            abort(404);
        }

        $codeData['settlements'] = $settlements;

        return response()->json($codeData);

    }

    private function eliminar_tildes($cadena){
    
        //Ahora reemplazamos las letras
        $cadena = str_replace(
            array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
            array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
            $cadena
        );
    
        $cadena = str_replace(
            array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
            array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
            $cadena );
    
        $cadena = str_replace(
            array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
            array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
            $cadena );
    
        $cadena = str_replace(
            array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
            array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
            $cadena );
    
        $cadena = str_replace(
            array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
            array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
            $cadena );
    
        $cadena = str_replace(
            array('ñ', 'Ñ', 'ç', 'Ç'),
            array('n', 'N', 'c', 'C'),
            $cadena
        );
    
        return $cadena;
    }
    
}
