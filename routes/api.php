<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CardController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\GroupController;
use App\Http\Controllers\Api\LinkController;
use App\Http\Controllers\Api\PhoneContactController;
use App\Http\Controllers\Api\PlatformController;
use App\Http\Controllers\Api\ProfileController as UserProfileController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ConnectController;
use App\Http\Controllers\Api\ViewProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Card;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/platformClick', [PlatformController::class, 'incrementClick'])->name('inc.platform.click');
Route::get('/getCards',function () {
    return Card::select(
        'id',
        'uuid',
        'status'
    )
    ->where('status', 0)
    ->get()->toArray();
});
// Route::post('/incrementProfileView', [PlatformController::class, 'incrementProfileView'])->name('inc.profile.view');

Route::middleware('localization')->group(function () {

    Route::post('register', [AuthController::class, 'register'])->middleware(['throttle:6,1']);
    Route::post('login', [AuthController::class, 'login'])->middleware(['throttle:6,1']);
    Route::post('forgetPassword', [AuthController::class, 'forgotPassword'])->middleware(['throttle:6,1']);
    Route::post('resetPassword', [AuthController::class, 'resetPassword']);
    Route::post('/recoverAccount', [AuthController::class, 'recoverAccount']);

    //old gotap
    // $router->post('/forgetPassword', [AuthController::class, 'forgetPassword']);
    Route::post('/otpVerification', [AuthController::class, 'otpVerify']);

    Route::middleware('auth:sanctum')->group(function () {

        Route::middleware('user.status')->group(function () {

            Route::post('/change-password', [AuthController::class, 'changePassword']);
            // Category
            Route::get('/categories', [CategoryController::class, 'index']);

            // User
            // Route::post('/connect', [UserController::class, 'connect']);
            Route::get('/analytics', [UserController::class, 'analytics']);
            Route::post('/privateProfile', [UserController::class, 'privateProfile']);

            Route::get('/deactivateAccount', [UserController::class, 'deactivateAccount']);
            Route::get('/delete', [UserController::class, 'deleteAccount']);

            // User Profile
            Route::get('/profile', [UserProfileController::class, 'index']);
            Route::post('/updateProfile', [UserProfileController::class, 'update']);
            Route::get('/userDirect', [UserProfileController::class, 'userDirect']);
            Route::get('/search', [UserProfileController::class, 'search']);



            //old gotap user
            // $router->get('/search', [UserController::class, 'search']);

            // Links
            Route::get('/links', [LinkController::class, 'index']);
            Route::post('/addLink', [LinkController::class, 'add']);
            Route::post('/updateLink', [LinkController::class, 'update']);
            Route::get('/removeLink/{id}', [LinkController::class, 'remove']);

            // Platform
            // Route::post('/searchPlatform', [PlatformController::class, 'search']);
            Route::post('/addPlatform', [PlatformController::class, 'add']);
            Route::post('/removePlatform', [PlatformController::class, 'remove']);
            Route::post('/swapOrder', [PlatformController::class, 'swap']);
            // Route::post('/platformDirect', [PlatformController::class, 'direct']);
            // Route::post('/platformDetails', [PlatformController::class, 'details']);

            //old gotap

            // $router->get('/phoneContact/{num}', [PlatformController::class, 'phone_contact']);


            // Phone Contact
            Route::get('/phoneContacts', [PhoneContactController::class, 'index']);
            Route::post('/addPhoneContact', [PhoneContactController::class, 'add']);
            Route::post('/phoneContact', [PhoneContactController::class, 'phoneContact']);
            Route::post('/updatePhoneContact', [PhoneContactController::class, 'update']);
            Route::post('/removeContact', [PhoneContactController::class, 'remove']);

            // Group
            Route::get('/groups', [GroupController::class, 'index']);
            Route::post('/group', [GroupController::class, 'group']);
            Route::post('/addGroup', [GroupController::class, 'add']);
            Route::post('/updateGroup', [GroupController::class, 'update']);
            Route::post('/removeGroup', [GroupController::class, 'destroy']);
            Route::post('/addUserIntoGroup', [GroupController::class, 'addUser']);
            Route::post('/addContactIntoGroup', [GroupController::class, 'addContact']);
            Route::post('/removeUserFromGroup', [GroupController::class, 'removeUser']);
            Route::post('/removeContactFromGroup', [GroupController::class, 'removeContact']);
            Route::get('/groupDetail/{num}', [GroupController::class, 'groupDetail']);


            //olg gotap groups


            // Cards
            Route::get('/cards', [CardController::class, 'index']);
            Route::post('/activateCard', [CardController::class, 'activateCard']);
            Route::post('/changeCardStatus', [CardController::class, 'changeCardStatus']);
            Route::post('/cardProfileDetail', [CardController::class, 'cardProfileDetail']);
            // Route::get('/userTags', [CardController::class, 'userTags']);

            //old gotap card
            // $router->post('/cardProfileDetail', [CardController::class, 'cardProfileDetail']);

            // View User Profile
            Route::post('/viewUserProfile', [ViewProfileController::class, 'viewUserProfile']);

            // Connects
            Route::post('/connect', [ConnectController::class, 'connect']); //done
            Route::post('/disconnect', [ConnectController::class, 'disconnect']);
            Route::post('/connectionProfile', [ConnectController::class, 'getConnectionProfile']);
            Route::get('/connections', [ConnectController::class, 'getConnections']);
        });
        Route::get('logout', [AuthController::class, 'logout']);
    });
});
