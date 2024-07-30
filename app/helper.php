<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

// define('ENCRYPT_METHOD', 'AES-256-CBC');
// define('SECRET_KEY', 'live4ajvf11224vb');
// define('SECRET_IV', 'liveaves2211bfhhj34hb');

// if (!function_exists('customEncrypt')) {
//     function customEncrypt($string)
//     {
//         // hash
//         $key = hash('sha256', SECRET_KEY);
//         // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
//         $iv = substr(hash('sha256', SECRET_IV), 0, 16);
//         $output = openssl_encrypt($string, ENCRYPT_METHOD, $key, 0, $iv);
//         $output = base64_encode($output);
//         return $output;
//     }
// }

// if (!function_exists('customDecrypt')) {

//     function customDecrypt($string)
//     {
//         if (is_numeric($string)) {
//             return $string;
//         }
//         // hash
//         $key = hash('sha256', SECRET_KEY);
//         // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
//         $iv = substr(hash('sha256', SECRET_IV), 0, 16);
//         $output = openssl_decrypt(base64_decode($string), ENCRYPT_METHOD, $key, 0, $iv);
//         return $output;
//     }
// }


if (!function_exists('model_delete_status')) {
    function model_delete_status($model)
    {
        if ($model->trashed()) {
            return [
                'status' => 'Deactivated',
                'background' => 'bg-label-danger'
            ];
        }
        if (!$model->trashed()) {
            return [
                'status' => 'Activated',
                'background' => 'bg-label-primary'
            ];
        }
    }
}

if (!function_exists('model_status')) {
    function model_status($model)
    {
        if ($model->status == 0) {
            return [
                'status' => 'Inactive',
                'background' => 'bg-label-danger'
            ];
        }
        if ($model->status == 1) {
            return [
                'status' => 'Active',
                'background' => 'bg-label-success'
            ];
        }
    }
}

if (!function_exists('defaultDateFormat')) {
    function defaultDateFormat($date)
    {
        return Carbon::parse($date)->format('Y-M-d');
    }
}

if (!function_exists('default_time_format')) {
    function default_time_format($date)
    {
        return Carbon::parse($date)->format('g:i:s a');
    }
}

if (!function_exists('generate_string')) {
    function generate_string($input, $strength = 16) {
    $input_length = strlen($input);
    $random_string = '';
    for($i = 0; $i < $strength; $i++) {
        $random_character = $input[mt_rand(0, $input_length - 1)];
        $random_string .= $random_character;
    }
    return $random_string;
    }
}

if (!function_exists('uploadImage')) {
    function uploadImage($image, $oldImage = null, $path = 'uploads')
    {
        $imagePath = '';
        if (!is_string($image)) {
            $fileName = rand(111, 999) . time() . '.' . $image->getClientOriginalExtension();
            // $image->storeAs('/', $fileName, 'real_public');
            $image->move(public_path($path), $fileName);
            $imagePath = $path . '/' . $fileName;
        } else {
            $imagePath = $image;
        }

        if ($oldImage) {
            if (!is_string($image)) {
                if (File::exists(public_path($oldImage))) {
                    unlink(public_path($oldImage));
                }
            }
        }

        return $imagePath;
    }
}

if (!function_exists('isImageExist')) {
    function isImageExist($image, $type=null)
    {
        if ($image) {
            if (Storage::exists('public/' . $image)) {
                return 'storage/' . $image;
            } else {
                if($type == 'profile') {
                    return 'user.png';
                }
                if($type == 'platform') {
                    return 'pbg.png';
                }
                return 'platform-bg.png';
            }
        }
        if($type == 'profile') {
             return 'user.png';
        }
        if($type == 'platform') {
            return 'pbg.png';
        }
        return 'platform-bg.png';
    }
}

if (!function_exists('clearTempFiles')) {
    function clearTempFiles()
    {
        Storage::deleteDirectory('livewire-tmp');
        // $files = Storage::files('livewire-tmp');
        // foreach ($files as $file) {
        //     Storage::delete($file);
        // }
    }
}
/**
 * User's unique number
 */
if (!function_exists('userUniqueNumber')) {
    function userUniqueNumber()
    {

        $unique_number = rand(1, 9) . time() . rand(1, 9);
        $unique_number = $unique_number - (rand(1, 9) + rand(3, 11) + rand(2, 10));

        return $unique_number;
    }
}

/**
 * Tranaction's unique number
 */
if (!function_exists('transUniqueNumber')) {
    function transUniqueNumber()
    {

        $unique_number = rand(1, 9) . time() . rand(1, 9);
        $unique_number = $unique_number - (rand(1, 9) + rand(3, 11) + rand(2, 10));

        return $unique_number;
    }
}

/**
 * Tranaction's unique number
 */
if (!function_exists('moneyFormat')) {
    function moneyFormat($money)
    {
        return number_format($money);
    }
}

/**
 * Device id
 */
if (!function_exists('getDeviceId')) {
    function getDeviceId()
    {
        return request()->header('Device-Id') ?: null;
    }
}


/**
 * Device Type
 */
if (!function_exists('getDeviceType')) {
    function getDeviceType()
    {
        return request()->header('Device-Type') ?: null;
    }
}

/**
 * Logo
 */
if (!function_exists('getCompanyLogo')) {
    function getCompanyLogo()
    {
        return 'assets/admin/assets/img/images/Taaply_logo.png';
    }
}

/**
 * Currencies
 */
if (!function_exists('getCurrencies')) {
    function getCurrencies()
    {
        $file = database_path('currencies.json');
        $content = json_decode(file_get_contents($file), true);
        foreach ($content['currencies'] as $element) {
            $hash = $element['currencyCode'];
            $unique_array[$hash] = $element;
        }

        $result = array_values($unique_array);

        usort($result, function ($a, $b) {
            return $a['currencyCode'] <=> $b['currencyCode'];
        });
        return $result;
    }
}
