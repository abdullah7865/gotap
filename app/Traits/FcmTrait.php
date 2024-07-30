<?php

namespace App\Traits;

use App\Models\FcmToken;
use Http;

use App\Models\{
    User,
    Notification,
    Transaction,
};
use App\Notifications\FcmNotification;

trait FcmTrait
{

    public string $subject;
    public string $body;
    public int|string|null $notifiableId = null;
    public string $type = 'general';
    public int|null $childID = null;
    public string $transactionType;
    public bool  $storeNotification;
    public int $senderID;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function sendNotification(int|string|array $receiver, string $subject, string $body, int|string|null $notifiableId = null, string|null $type = null, $childID = null, $transacationType = null, $storeNotification = true)
    {
        $this->subject = $subject;
        $this->body = $body;
        $this->childID = $childID;
        $this->transactionType = $transacationType;

        if ($notifiableId) {
            $this->notifiableId = $notifiableId;
        }

        if ($type) {
            $this->type = $type;
        }
        if ($childID) {
            $this->childID = $childID;
        }
        if ($storeNotification && is_numeric($receiver)) {
            $this->storeNotification = $storeNotification;
        }

        $this->senderID = auth()->id();

        if (is_numeric($receiver)) {
            $this->sendToSingle($receiver);
        } else if ($receiver == 'contacts') {
            $this->sendToContacts();
        } else if ($receiver == 'all') {
            $this->sendToAll();
        } else if ($receiver == 'new') {
            $this->sendToNew();
        } else if (is_array($receiver)) {
            $this->sendToMultiple($receiver);
        } else {
            die('invalid Receiver');
        }
    }

    private function sendToSingle($receiverID)
    {
        $notifyId = '';
        if ($receiverID == auth()->id())
            return false;

        $user = User::findOrFail($receiverID);


        $tokens = $user->fcmTokens->pluck('token')->toArray();

        // Save Notification to Database
        if ($this->storeNotification) {
            $notifyId = $this->saveNotification($receiverID);
        }

        return $this->send($tokens, $user, $notifyId);
    }


    private function sendToMultiple($receiverIDs)
    {
        $tokens = FcmToken::whereIn('user_id', $receiverIDs)->pluck('token')->toArray();
        return $this->send($tokens);
    }

    private function sendToAll()
    {
        $limit = 1000;
        $offset = 0;
        $hasMoreTokens = true;

        while ($hasMoreTokens) {
            $tokens = FcmToken::offset($offset)->limit($limit);
            $tokens = $tokens->pluck('token')->toArray();
            $hasMoreTokens = count($tokens) === $limit;
            if (empty($tokens))
                return true;

            $offset += $limit;
            $this->send($tokens);
        }
        return true;
    }

    private function sendToNew()
    {
        $hours24Behind = now()->subDays(1)->format('Y-m-d H:i:s');
        $tokens = FcmToken::join('users', 'users.id', '=', 'user_id')
            ->where('users.created_at', $hours24Behind)
            ->limit(1000)->pluck('token')->toArray();
        if (empty($tokens))
            return true;
        $this->send($tokens);
        return true;
    }



    private function saveNotification(int $receiverID)
    {
        $types = [
            'user' => User::class,
            'tag' => User::class,
            'invite' => User::class,
            'post' => Post::class,
            'payment' => Payment::class,
            'message' => User::class,
            'general' => User::class,
            'transaction' => Transaction::class,
        ];

        $storeNotification = true;

        if ($this->type == 'message') {
            $dateTime = now()->subMinutes(3)->format('Y-m-d H:i:s');
            $recentNotification = Notification::where('reciever_id', $receiverID)->where('sender_id', $this->senderID)
                ->where('notifiable_id',  $this->notifiableId)->where('notifiable_type', $types[$this->type])
                ->where('updated_at', '>', $dateTime)->first();

            // if same notification sent recently than just update notificaion (do not save new)
            if ($recentNotification) {
                $storeNotification = false;
                $recentNotification->update([
                    'read' => 0,
                    'body' => $this->body
                ]);

                if (!$recentNotification->isDirty()) {
                    $recentNotification->touch();
                }
            }
        }

        if ($storeNotification) {

            $notification = Notification::create([
                'reciever_id' => $receiverID,
                'sender_id' => $this->senderID,
                'subject' => $this->subject,
                'body' => $this->body,
                'notifiable_id' => $this->notifiableId,
                'notifiable_type' =>  $types[$this->type],
                'child_id' => $this->childID,
                'type' => $this->transactionType,
            ]);

            return $notification->id;
        }
    }


    public function send(array $tokens, $user = null, $notifyId = null)
    {
        if (empty($tokens)) {
            return false;
        }

        if (!$user) {
            $user = auth()->user();
        }

        $data = [
            'subject' => $this->subject,
            'body' => $this->body,
            'senderID' => (string) $this->senderID,
            'notifiable_id' => (string) $this->notifiableId,
            'notifiable_type' => $this->type,
            'childID' => (string) $this->childID,
            'image' => '',
            'notfication_id' => (string) $notifyId
        ];

        $user->notify(new FcmNotification($data));
    }
}
