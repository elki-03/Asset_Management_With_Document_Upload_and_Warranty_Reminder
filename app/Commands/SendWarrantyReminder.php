<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Services\WarrantyReminderService; 

class SendWarrantyReminder extends BaseCommand
{
    protected $group   = 'Reminders';
    protected $name    = 'reminders:send';

    public function run(array $params) {
        $service = new WarrantyReminderService();
        $count = $service->sendDueReminders();
        CLI::write("$count Erinnerung(en) gesendet.");
    }
}