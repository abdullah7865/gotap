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
            'status' => 200,
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
                "status"  => 400,
                "message" => trans('backend.card_not_found')
            ]);
        }

        // check card is already activated
        if ($card->status) {
            return response()->json([
                "status" => 400,
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
                "status" => 200,
                "message" => trans('backend.card_active_success')
            ]);
        } catch (Exception $ex) {
            return response()->json([
                "status" => 400,
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
                "status" => 400,
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
                "status" => 400,
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
                    'status' => 200,
                    'message' => trans('backend.card_deactive_success')
                ]);
            }
            return response()->json([
                'status' => 200,
                'message' => trans('backend.card_active_success')
            ]);
        } catch (Exception $ex) {
            return response()->json([
                'status' => 400,
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
            'card_uuid' => 'required',
        ]);

        $card = Card::where('uuid', $request->card_uuid)->first();

        if (!$card) {
            return response()->json(["status" => 422, 'message' => 'Card not found']);
        }

        if (!$card->status) {
            return response()->json(["status" => 200, "message" => "Card not activated"]);
        }

        $checkCard = UserCard::where('card_id', $card->id)
            ->where('status', 1)
            ->first();

        if (!$checkCard) {
            return response()->json(["status" => 200, "message" => "User profile not accessible"]);
        }

        $user = User::find($checkCard->user_id);

        if (!$user) {
            return response()->json(["status" => 404, "message" => "Profile not found"]);
        }

        $user->connected = 0;
        if ($user->id != auth()->id()) {
            $connected = Connect::where('connecting_id', auth()->id())
                ->where('connected_id', $user->id)
                ->exists();

            if ($connected) {
                $user->connected = 1;
            }
        }

        $categories = $this->custom->returnPlatforms($user->id, 'user');
        $res['categories'] = $categories['categories'];
        $user->direct = $categories['direct'];
        $res['user'] = $user;

        if ($request->query('source') == 'gotap') {
            $user->increment('tiks');

            $visited = ScanVisit::where('visiting_id', auth()->id())
                ->where('visited_id', $user->id)
                ->first();

            if (!$visited) {
                ScanVisit::create([
                    'visiting_id' => auth()->id(),
                    'visited_id' => $user->id,
                ]);
            }

            $connected = Connect::where('connecting_id', auth()->id())
                ->where('connected_id', $user->id)
                ->first();

            if (!$connected) {
                Connect::create([
                    'connecting_id' => auth()->id(),
                    'connected_id' => $user->id,
                ]);
            }

            $user->connected = 1;
        }

        return response()->json(["status" => 200, "message" => "User Profile", 'data' => $res]);
    }
}
