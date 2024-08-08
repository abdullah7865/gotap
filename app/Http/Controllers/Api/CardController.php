<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Card;
use App\Models\User;
use App\Models\Connect;
use App\Models\UserCard;
use App\Models\ScanVisit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Card\CardRequest;

class CardController extends Controller
{
    public function index()
    {
        $cards = DB::table('user_cards')
            ->select(
                'cards.id',
                'cards.uuid',
                'cards.description',
                'user_cards.status',
                'user_cards.created_at'
            )
            ->join('cards', 'cards.id', 'user_cards.card_id')
            ->where('user_id', auth()->id())
            ->get();

        return response()->json([
            'data' => $cards
        ]);
    }

    public function activateCard(CardRequest $request)
    {
        $card = null;
        // check card exist
        if ($request->has('card_uuid')) {
            $card = Card::where('uuid', $request->card_uuid)->first();
        }
        if ($request->has('activation_code')) {
            $card = Card::where('activation_code', $request->activation_code)->first();
        }

        if (!$card) {
            return response()->json([
                "message" => trans('backend.card_not_found')
            ]);
        }

        // check card is already activated
        if ($card->status) {
            return response()->json([
                "message" => trans('backend.card_already_active')
            ]);
        }

        try {
            // insert card in user cards table
            DB::table('user_cards')->insert([
                'card_id' => $card->id,
                'user_id' => auth()->id(),
                'status' => 1
            ]);

            // update card status to activated
            DB::table('cards')->where('id', $card->id)->update([
                'status' => 1
            ]);

            return response()->json([
                "message" => trans('backend.card_active_success')
            ]);
        } catch (Exception $ex) {
            return response()->json([
                "message" => $ex->getMessage()
            ]);
        }
    }

    public function changeCardStatus(CardRequest $request)
    {

        $card = null;
        // check card exist
        if ($request->has('card_uuid')) {
            $card = Card::where('uuid', $request->card_uuid)->first();
        }
        if ($request->has('activation_code')) {
            $card = Card::where('activation_code', $request->activation_code)->first();
        }

        if (!$card) {
            return response()->json([
                "message" => trans('backend.card_not_found')
            ]);
        }

        // check is card belongs to the user
        $checkCard = DB::table('user_cards')
            ->where('user_id', auth()->id())
            ->where('card_id', $card->id)
            ->get()
            ->first();
        if (!$checkCard) {
            return response()->json([
                'message' => trans('backend.not_authenticated')
            ]);
        }

        // update user_card status
        try {
            DB::table('user_cards')
                ->where('user_id', auth()->id())
                ->where('card_id', $card->id)
                ->update(['status' => $checkCard->status ? 0 : 1]);

            if ($checkCard->status) {
                return response()->json([
                    'message' => trans('backend.card_deactive_success')
                ]);
            }
            return response()->json([
                'message' => trans('backend.card_active_success')
            ]);
        } catch (Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ]);
        }
    }

    /**
     * Get User Tags
     */
    public function userTags()
    {
        $tags = DB::table('user_cards')
            ->select(
                'cards.id',
                'cards.uuid',
                'cards.activation_code',
                'cards.status',
                'cards.description'
            )
            ->join('cards', 'cards.id', 'user_cards.card_id')
            ->where('user_id', auth()->id())
            ->get();

        return response()->json(['tags' => $tags]);
    }


    public function cardProfileDetail(Request $request)
    {
        $request->validate([
            'card_uuid' => 'required|string',
        ]);

        $card_uuid = $request->input('card_uuid');

        $card = DB::table('cards')->where('uuid', $card_uuid)->first();

        if (!$card) {
            return response()->json(['error' => 'Card not found'], 404);
        }

        $userCard = DB::table('user_cards')->where('card_id', $card->id)->first();

        if (!$userCard) {
            return response()->json(['error' => 'User not found for this card'], 404);
        }
        $user = DB::table('users')->where('id', $userCard->user_id)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $platforms = DB::table('user_platforms')
            ->join('platforms', 'user_platforms.platform_id', '=', 'platforms.id')
            ->where('user_platforms.user_id', $user->id)
            ->select('platforms.id', 'platforms.title', 'platforms.icon', 'platforms.input', 'platforms.baseUrl',
                     'platforms.placeholder_en', 'platforms.placeholder_sv', 'platforms.description_en',
                     'platforms.description_sv', 'user_platforms.path', 'user_platforms.label', 'user_platforms.direct',
                     'user_platforms.platform_order')
            ->get();

    $isConnected = DB::table('connects')
    ->where('connecting_id', auth()->id())
    ->where('connected_id', $user->id)
    ->exists() ? 1 : 0;


        $response = [
            'profile' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'username' => $user->username,
                'phone' => $user->phone,
                'job_title' => $user->job_title,
                'company' => $user->company,
                'photo' => $user->photo,
                'cover_photo' => $user->cover_photo,
                'status' => $user->status,
                'is_suspended' => $user->is_suspended,
                'user_direct' => $user->user_direct,
                'address' => $user->address,
                'work_position' => $user->work_position,
                'gender' => $user->gender,
                'tiks' => $user->tiks,
                'dob' => $user->dob,
                'private' => $user->private,
                'verified' => $user->verified,
                'featured' => $user->featured,
                'bio' => $user->bio,
                'deactivated_at' => $user->deactivated_at,
                'created_at' => $user->created_at
            ],
            'platforms' => $platforms,
            'is_connected' => $isConnected
        ];

        return response()->json($response);
    }

}
