<?php

namespace App\Services;

use App\Models\WarrantyModel;
use Myth\Auth\Models\UserModel; // Shield UserModel

class WarrantyReminderService
{
    public function sendDueReminders(): int
    {
        $model = new WarrantyModel();
        // bool == true and date - 3 weeks == today
        $records = $model->getDueReminders();

        foreach ($records as $record) {
            $this->sendMail($record);
        }
        return count($records);
    }


    private function sendMail(array $record): void {
       $userModel = model(\CodeIgniter\Shield\Models\UserModel::class);// Shield User Provider

        // Alle User mit Rolle admin oder superadmin holen
        $admins = $userModel// gibt das UserModel zurück
            ->join('auth_identities', 'auth_identities.user_id = users.id')
            ->whereIn('users.id', function($builder) {
                $builder->select('user_id')
                        ->from('auth_groups_users')
                        ->whereIn('group', ['admin', 'superadmin']);
            })
            ->findAll();

        $email = service('email');

        foreach ($admins as $admin) {
            $email->clear();
            $email->setTo($admin->email);
            $email->setSubject('Garantieerinnerung');
            $email->setMessage(view('emails/reminder', $record));
            $email->send();
        }
    }



    // // WarrantyReminderService.php
    // public function sendDueRemindersEmail(): int {
    //     $model = new WarrantyModel();
    //     $records = $model->getDueRemindersEmail(); // fertiger Datensatz kommt rein
        
    //     foreach ($records as $record) {
    //         $this->sendMail($record);
    //     }
    //     return count($records);
    // }
}