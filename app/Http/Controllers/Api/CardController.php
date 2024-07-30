<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Card\CardRequest;
use App\Models\Card;
use Exception;
use Illuminate\Support\Facades\DB;

class CardController extends Controller
{
    public function index()
    {
        $cards = DB::table('user_cards')
            ->select(
                'cards.id',
                'cards.uuid',
                'cards.activation_code',
                'cards.description',
                'user_cards.status',
                'user_cards.created_at'
            )
            ->join('cards', 'cards.id', 'user_cards.card_id')
            ->where('user_id', auth()->id())
            ->get();

        return response()->json(['data' => $cards]);
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
            return response()->json(["message" => trans('backend.card_not_found')]);
        }

        // check card is already activated
        if ($card->status) {
            return response()->json(["message" => trans('backend.card_already_active')]);
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

            return response()->json(["message" => trans('backend.card_active_success')]);
        } catch (Exception $ex) {
            return response()->json(["message" => $ex->getMessage()]);
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
            return response()->json(["message" => trans('backend.card_not_found')]);
        }

        // check is card belongs to the user
        $checkCard = DB::table('user_cards')
            ->where('user_id', auth()->id())
            ->where('card_id', $card->id)
            ->get()
            ->first();
        if (!$checkCard) {
            return response()->json(['message' => trans('backend.not_authenticated')]);
        }

        // update user_card status
        try {
            DB::table('user_cards')
                ->where('user_id', auth()->id())
                ->where('card_id', $card->id)
                ->update(['status' => $checkCard->status ? 0 : 1]);

            if ($checkCard->status) {
                return response()->json(['message' => trans('backend.card_deactive_success')]);
            }
            return response()->json(['message' => trans('backend.card_active_success')]);
        } catch (Exception $ex) {
            return response()->json(['message' => $ex->getMessage()]);
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
}
