<?php

namespace App\Console\Commands\Traits;

use App\User;
use Illuminate\Support\Facades\Log;
use App\Notifications\ConsoleCommandFailedNotification;
use Illuminate\Support\Facades\Cache;

trait NotifyUsersOnFailedCommandsTrait
{
    /**
     * Array of roles to query the users. All users with
     * these roles will receive this notification;
     *
     * @var array
     */
    public $notifiable_roles = ['admin'];

    /**
     * Notify all queried users;
     *
     * @param \Exception $th
     * @return void
     */
    protected function notifyUsers($th)
    {
        Cache::flush();
        
        $users = User::role($this->notifiable_roles)->get();

        foreach ($users as $user) {
            $user->notify(new ConsoleCommandFailedNotification(
                get_class($this), $th->getMessage()
            ));
        }

        return $this;
    }

    /**
     * Save the exception to a log.
     *
     * @param \Exception $th
     * @return void
     */
    protected function logError($th)
    {
        Log::error($th);

        return $this;
    }   

    /**
     * Wrapper to Notify all desired users and log the errors
     *
     * @param \Eception $th
     * @return void
     */
    protected function notifyUsersAndLogError($th)
    {
        $this->notifyUsers($th)
            ->logError($th);
    }
}