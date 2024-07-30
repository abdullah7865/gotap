<?php

namespace App\Http\Controllers;

use App\Models\User;
use JeroenDesloovere\VCard\VCard;

class VCardController extends Controller
{
    // public function saveContact($id)
    // {
    //     $user = User::where('id', $id)->first();
    //     $vcard = new VCard();
        
        
    //     if ($user->photo) {
    //         $imageUrl = 'https://tocky.co/storage/uploads/photos/1690272558.png';
            
    //         // Fetch the image data from the URL
    //         $imageData = file_get_contents($imageUrl);
            

    //         // Convert the image data to base64 encoding
    //         $base64Image = base64_encode($imageData);
            
    //         // Add the photo to the VCard using the base64-encoded image
    //         $vcard->addPhoto($base64Image);
    //     }

    //     $vcard->addName('', $user->name);
    //     $vcard->addEmail($user->email);
    //     $vcard->addPhoneNumber($user->phone, 'WORK');
    //     $vcard->addCompany($user->company);
    //     $vcard->addJobtitle($user->job_title);

    //     return $vcard->download();
    // }
    
    public function saveContact($id)
    {
        $user = User::where('id', $id)->first();
        $vcard = new VCard();


        $vcard->addName('', $user->name);
        $vcard->addEmail($user->email);
        $vcard->addPhoneNumber($user->phone, 'WORK');
        $vcard->addCompany($user->company);
        $vcard->addJobtitle($user->job_title);
        

        
        return response()->make(
            $vcard->getOutput(),
            200,
            $vcard->getHeaders(true)
        );
    }
}
