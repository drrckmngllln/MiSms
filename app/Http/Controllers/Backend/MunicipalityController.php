<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MunicipalityController extends Controller
{


    public function municipalities(Request $request)
    {
        $region = [

            ["code" => "020000000", "name" => "Cagayan Valley"],
            ["code" => "140000000", "name" => "Cordillera Administrative Region"],
        ];
        return response()->json($region);
    }

    //cagayan
    public function citiesProvince(Request $request)
    {
        $citiesProvince = [
            ["code" => "021501000", "name" => "Abulug, Cagayan", "regionCode" => "020000000"],
            ["code" => "021502000", "name" => "Alcala, Cagayan", "regionCode" => "020000000"],
            ["code" => "021503000", "name" => "Allacapan, Cagayan", "regionCode" => "020000000"],
            ["code" => "021504000", "name" => "Amulung, Cagayan", "regionCode" => "020000000"],
            ["code" => "021505000", "name" => "Aparri, Cagayan", "regionCode" => "020000000"],
            ["code" => "021506000", "name" => "Baggao, Cagayan", "regionCode" => "020000000"],
            ["code" => "021507000", "name" => "Ballesteros, Cagayan", "regionCode" => "020000000"],
            ["code" => "021508000", "name" => "Buguey, Cagayan", "regionCode" => "020000000"],
            ["code" => "021509000", "name" => "Calayan, Cagayan", "regionCode" => "020000000"],
            ["code" => "021510000", "name" => "Camalaniugan, Cagayan", "regionCode" => "020000000"],
            ["code" => "021511000", "name" => "Claveria, Cagayan", "regionCode" => "020000000"],
            ["code" => "021512000", "name" => "Enrile, Cagayan", "regionCode" => "020000000"],
            ["code" => "021513000", "name" => "Gattaran, Cagayan", "regionCode" => "020000000"],
            ["code" => "021514000", "name" => "Gonzaga, Cagayan", "regionCode" => "020000000"],
            ["code" => "021515000", "name" => "Iguig, Cagayan", "regionCode" => "020000000"],
            ["code" => "021516000", "name" => "Lal-Lo, Cagayan", "regionCode" => "020000000"],
            ["code" => "021517000", "name" => "Lasam, Cagayan", "regionCode" => "020000000"],
            ["code" => "021518000", "name" => "Pamplona, Cagayan", "regionCode" => "020000000"],
            ["code" => "021519000", "name" => "Peñablanca, Cagayan", "regionCode" => "020000000"],
            ["code" => "021520000", "name" => "Piat, Cagayan", "regionCode" => "020000000"],
            ["code" => "021521000", "name" => "Rizal, Cagayan", "regionCode" => "020000000"],
            ["code" => "021522000", "name" => "Sanchez-Mira, Cagayan", "regionCode" => "020000000"],
            ["code" => "021523000", "name" => "Santa Ana, Cagayan", "regionCode" => "020000000"],
            ["code" => "021524000", "name" => "Santa Praxedes, Cagayan", "regionCode" => "020000000"],
            ["code" => "021525000", "name" => "Santa Teresita, Cagayan", "regionCode" => "020000000"],
            ["code" => "021526000", "name" => "Santo Niño, Cagayan", "regionCode" => "020000000"],
            ["code" => "021527000", "name" => "Solana, Cagayan", "regionCode" => "020000000"],
            ["code" => "021528000", "name" => "Tuao, Cagayan", "regionCode" => "020000000"],
            ["code" => "021529000", "name" => "Tuguegarao City, Cagayan", "regionCode" => "020000000"],
            //isabela
            ["code" => "023101000", "name" => "Alicia, Isabela", "regionCode" => "020000000"],
            ["code" => "023102000", "name" => "Angadanan, Isabela", "regionCode" => "020000000"],
            ["code" => "023103000", "name" => "Aurora, Isabela", "regionCode" => "020000000"],
            ["code" => "023104000", "name" => "Benito Soliven, Isabela", "regionCode" => "020000000"],
            ["code" => "023105000", "name" => "Burgos, Isabela", "regionCode" => "020000000"],
            ["code" => "023106000", "name" => "Cabagan, Isabela", "regionCode" => "020000000"],
            ["code" => "023107000", "name" => "Cabatuan, Isabela", "regionCode" => "020000000"],
            ["code" => "023108000", "name" => "City of Cauayan, Isabela", "regionCode" => "020000000"],
            ["code" => "023109000", "name" => "Cordon, Isabela", "regionCode" => "020000000"],
            ["code" => "023110000", "name" => "Dinapigue, Isabela", "regionCode" => "020000000"],
            ["code" => "023111000", "name" => "Divilacan, Isabela", "regionCode" => "020000000"],
            ["code" => "023112000", "name" => "Echague, Isabela", "regionCode" => "020000000"],
            ["code" => "023113000", "name" => "Gamu, Isabela", "regionCode" => "020000000"],
            ["code" => "023114000", "name" => "City of Ilagan, Isabela", "regionCode" => "020000000"],
            ["code" => "023115000", "name" => "Jones, Isabela", "regionCode" => "020000000"],
            ["code" => "023116000", "name" => "Luna, Isabela", "regionCode" => "020000000"],
            ["code" => "023117000", "name" => "Maconacon, Isabela", "regionCode" => "020000000"],
            ["code" => "023118000", "name" => "Delfin Albano, Isabela", "regionCode" => "020000000"],
            ["code" => "023119000", "name" => "Mallig, Isabela", "regionCode" => "020000000"],
            ["code" => "023120000", "name" => "Naguilian, Isabela", "regionCode" => "020000000"],
            ["code" => "023121000", "name" => "Palanan, Isabela", "regionCode" => "020000000"],
            ["code" => "023122000", "name" => "Quezon, Isabela", "regionCode" => "020000000"],
            ["code" => "023123000", "name" => "Quirino", "regionCode" => "020000000"],
            ["code" => "023124000", "name" => "Ramon, Isabela", "regionCode" => "020000000"],
            ["code" => "023125000", "name" => "Reina Mercedes, Isabela", "regionCode" => "020000000"],
            ["code" => "023126000", "name" => "Roxas, Isabela", "regionCode" => "020000000"],
            ["code" => "023127000", "name" => "San Agustin, Isabela", "regionCode" => "020000000"],
            ["code" => "023128000", "name" => "San Guillermo, Isabela", "regionCode" => "020000000"],
            ["code" => "023129000", "name" => "San Isidro, Isabela", "regionCode" => "020000000"],
            ["code" => "023130000", "name" => "San Manuel, Isabela", "regionCode" => "020000000"],
            ["code" => "023131000", "name" => "San Mariano, Isabela", "regionCode" => "020000000"],
            ["code" => "023132000", "name" => "San Mateo, Isabela", "regionCode" => "020000000"],
            ["code" => "023133000", "name" => "San Pablo, Isabela", "regionCode" => "020000000"],
            ["code" => "023134000", "name" => "Santa Maria, Isabela", "regionCode" => "020000000"],
            ["code" => "023135000", "name" => "City of Santiago, Isabela", "regionCode" => "020000000"],
            ["code" => "023136000", "name" => "Santo Tomas, Isabela", "regionCode" => "020000000"],
            ["code" => "023137000", "name" => "Tumauini, Isabela", "regionCode" => "020000000"],

            // batanes
            ["code" => "020901000", "name" => "Basco", "regionCode" => "020000000"],
            ["code" => "020902000", "name" => "Itbayat", "regionCode" => "020000000"],
            ["code" => "020903000", "name" => "Ivana", "regionCode" => "020000000"],
            ["code" => "020904000", "name" => "Mahatao", "regionCode" => "020000000"],
            ["code" => "020905000", "name" => "Sabtang", "regionCode" => "020000000"],
            ["code" => "020906000", "name" => "Uyugan", "regionCode" => "020000000"],
            //car
            ["code" => "148101000", "name" => "Calanasan, Apayao", "regionCode" => "140000000"],
            ["code" => "148102000", "name" => "Conner, Apayao", "regionCode" => "140000000"],
            ["code" => "148103000", "name" => "Flora, Apayao", "regionCode" => "140000000"],
            ["code" => "148104000", "name" => "Kabugao, Apayao", "regionCode" => "140000000"],
            ["code" => "148105000", "name" => "Luna, Apayao", "regionCode" => "140000000"],
            ["code" => "148106000", "name" => "Pudtol, Apayao", "regionCode" => "140000000"],
            ["code" => "148107000", "name" => "Santa Marcela, Apayao", "regionCode" => "140000000"],
            //kalinga
            ["code" => "143201000", "name" => "Balbalan, Kalinga", "regionCode" => "140000000"],
            ["code" => "143206000", "name" => "Lubuagan, Kalinga", "regionCode" => "140000000"],
            ["code" => "143208000", "name" => "Pasil, Kalinga", "regionCode" => "140000000"],
            ["code" => "143209000", "name" => "Pinukpuk, Kalinga", "regionCode" => "140000000"],
            ["code" => "143211000", "name" => "Rizal, Kalinga", "regionCode" => "140000000"],
            ["code" => "143214000", "name" => "Tanudan, Kalinga", "regionCode" => "140000000"],
            ["code" => "143215000", "name" => "Tinglayan, Kalinga", "regionCode" => "140000000"],

            //ifugao 
            ["code" => "142701000", "name" => "Banaue, Ifugao", "regionCode" => "140000000"],
            ["code" => "142702000", "name" => "Hungduan, Ifugao", "regionCode" => "140000000"],
            ["code" => "142703000", "name" => "Kiangan, Ifugao", "regionCode" => "140000000"],
            ["code" => "142704000", "name" => "Lagawe, Ifugao", "regionCode" => "140000000"],
            ["code" => "142705000", "name" => "Lamut, Ifugao", "regionCode" => "140000000"],
            ["code" => "142706000", "name" => "Mayoyao, Ifugao", "regionCode" => "140000000"],
            ["code" => "142707000", "name" => "Alfonso Lista, Ifugao", "regionCode" => "140000000"],
            ["code" => "142708000", "name" => "Aguinaldo, Ifugao", "regionCode" => "140000000"],
            ["code" => "142709000", "name" => "Hingyon, Ifugao", "regionCode" => "140000000"],
            ["code" => "142710000", "name" => "Tinoc, Ifugao", "regionCode" => "140000000"],
            ["code" => "142711000", "name" => "Asipulo, Ifugao", "regionCode" => "140000000"],

            //Benguet
            ["code" => "141101000", "name" => "Atok, Benguet", "regionCode" => "140000000"],
            ["code" => "141103000", "name" => "Bakun, Benguet", "regionCode" => "140000000"],
            ["code" => "141104000", "name" => "Bokod, Benguet", "regionCode" => "140000000"],
            ["code" => "141105000", "name" => "Buguias, Benguet", "regionCode" => "140000000"],
            ["code" => "141106000", "name" => "Itogon, Benguet", "regionCode" => "140000000"],
            ["code" => "141107000", "name" => "Kabayan, Benguet", "regionCode" => "140000000"],
            ["code" => "141108000", "name" => "Kapangan, Benguet", "regionCode" => "140000000"],
            ["code" => "141109000", "name" => "Kibungan, Benguet", "regionCode" => "140000000"],
            ["code" => "141110000", "name" => "La Trinidad, Benguet", "regionCode" => "140000000"],
            ["code" => "141111000", "name" => "Mankayan, Benguet", "regionCode" => "140000000"],
            ["code" => "141112000", "name" => "Sablan, Benguet", "regionCode" => "140000000"],
            ["code" => "141113000", "name" => "Tuba, Benguet", "regionCode" => "140000000"],
            ["code" => "141114000", "name" => "Tublay, Benguet", "regionCode" => "140000000"],

            //ABRA
            ["code" => "140101000", "name" => "Abra", "regionCode" => "140000000"],




        ];
        return response()->json($citiesProvince);
    }
    public function barangay(Request $request)
    {
        $filePath = storage_path('app/public/barangay.json');
        $isabelaFilePath = storage_path('app/public/isabelabarangay.json');
        $batanesFilePath = storage_path('app/public/batanesbarangay.json');
        $carFilePath = storage_path('app/public/carbarangay.json');
        $kalingaFilePath = storage_path('app/public/kalingabarangay.json');
        $ifugaoFilePath = storage_path('app/public/ifugaobarangay.json');
        $benguetFilePath = storage_path('app/public/benguetbrgy.json');
        $abramFilePath = storage_path('app/public/Abranbrgy.json');

        if (
            !file_exists($filePath) || !file_exists($isabelaFilePath) || !file_exists($batanesFilePath) || !file_exists($carFilePath) || !file_exists($kalingaFilePath)
            || !file_exists($ifugaoFilePath) || !file_exists($benguetFilePath) || !file_exists($abramFilePath)
        ) {
            return response()->json(['message' => 'Barangay data files not found'], 404);
        }

        $barangayData = json_decode(file_get_contents($filePath), true);
        $isabelaData = json_decode(file_get_contents($isabelaFilePath), true);
        $batanesData = json_decode(file_get_contents($batanesFilePath), true);
        $carData = json_decode(file_get_contents($carFilePath), true);
        $kalingaData = json_decode(file_get_contents($kalingaFilePath), true);
        $ifugaoData = json_decode(file_get_contents($ifugaoFilePath), true);
        $benguetData = json_decode(file_get_contents($benguetFilePath), true);
        $abramData = json_decode(file_get_contents($abramFilePath), true);
        $combinedBarangays = array_merge($barangayData, $isabelaData, $batanesData, $carData, $kalingaData, $ifugaoData, $benguetData, $abramData);
        // dd($carData);
        $regionCode = $request->input('regionCode');
        $municipalityCode = $request->input('municipalityCode');



        $filteredBarangays = array_filter($combinedBarangays, function ($barangay) use ($regionCode, $municipalityCode) {
            return $barangay['regionCode'] === $regionCode && $barangay['municipalityCode'] === $municipalityCode;
        });
        // dd($filteredBarangays);

        // If no barangays are found, check if it's in the Isabela data
        if (empty($filteredBarangays)) {
            $filteredBarangays = array_filter($isabelaData, function ($barangay) use ($regionCode, $municipalityCode) {
                return $barangay['regionCode'] === $regionCode && $barangay['municipalityCode'] === $municipalityCode;
            });
        }

        return response()->json(array_values($filteredBarangays));
    }
}