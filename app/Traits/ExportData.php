<?php

namespace App\Traits;

trait ExportData
{

    // public function downloadCsvOld()
    // {
    //     $fileName = session()->get('file_name');
    //     // $cards = $this->getFilteredData()->get();

    //     // dd($this->cards);

    //     $data = session()->get('data');


    //     $oldKeys = array_keys($data[0]->toArray());

    //     $newKeys = array();

    //     foreach ($oldKeys as $key) {
    //         $capitalizeKey = ucfirst($key);
    //         $new_key = $capitalizeKey;
    //         if (str_contains($capitalizeKey, '_')) {
    //             $new_key = str_replace('_', ' ', $capitalizeKey);
    //         }

    //         array_push($newKeys, $new_key);
    //     }

    //     $data = $data->toArray();
    //     // dd($data[0][$oldKeys[0]]);
    //     // dd($oldKeys, $newKeys);

    //     $headers = array(
    //         "Content-type"        => "text/csv",
    //         "Content-Disposition" => "attachment; filename=$fileName",
    //         "Pragma"              => "no-cache",
    //         "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
    //         "Expires"             => "0"
    //     );

    //     $columns = $newKeys;

    //     // dd($oldKeys);

    //     $callback = function () use ($data, $columns) {

    //         $file = fopen('php://output', 'w');
    //         fputcsv($file, $columns);


    //         foreach ($data as $item) {
    //             // $fileColums = array();

    //             // $row['Id']              = $item->id;
    //             // $row['UUID']            = $item->uuid;
    //             // $row['Type']            = $item->type;
    //             // $row['Description']     = $item->description;

    //             $row['Id']              = $item['id'];
    //             $row['UUID']            = $item['uuid'];
    //             $row['Type']            = $item['type'];
    //             $row['Description']     = $item['description'];

    //             // for ($i = 0; $i < count($columns); $i++) {
    //             //     $row[$columns[$i]] = $item[$index][$oldKeys[$i]];
    //             //     array_push($fileColums, $row[$columns[$i]]);
    //             // }


    //             fputcsv($file, array($row['Id'], $row['UUID'], $row['Type'], $row['Description']));
    //         }

    //         fclose($file);
    //     };

    //     return response()->stream($callback, 200, $headers);
    // }

    public function downloadCsv()
    {
        $fileName = session()->get('file_name');
        $cards = session()->get('data');

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('Card UUID', 'Activation Code', 'Status');

        $callback = function () use ($cards, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);


            foreach ($cards as $card) {
                $row['Card UUID']  = request()->getSchemeAndHttpHost() . '/card_id/' . $card->uuid;
                $row['Activation Code'] = $card->activation_code;
                $row['Status'] = $card->status;

                fputcsv($file, array($row['Card UUID'], $row['Activation Code'] ,$row['Status']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
