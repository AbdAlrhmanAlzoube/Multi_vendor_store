<?php

namespace App\Observers;

use Illuminate\Notifications\DatabaseNotification;

class NotificationObserver
{
    public function retrieved(DatabaseNotification $notification)
    {
        if ($notification->unread()) {
            $notification->markAsRead();
        }
    }
}

