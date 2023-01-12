<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostalCodeController extends Controller
{

    public function searchPostalCode($code){

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
                    'locality' => $data[5],
                    'federal_entity' => [
                        'key'  => (int) $data[7],
                        'name' => $data[4],
                        'code' => null
                    ],
                    'settlements' => [],
                    'municipality' => [
                        'key'  => (int) $data[11],
                        'name' => $data[3]
                    ]
                ];

                $settlements[] = [
                    'key'       => (int) $data[12],
                    'name'      => $data[1],
                    'zona_type' => $data[13],
                    'settlement_type' => [
                        'name' => $data[2]
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
    
}
