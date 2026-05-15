<?php

namespace App\Models;
use CodeIgniter\Model;

class WarrantyModel extends Model {

    protected $table = 'hw_asset_warranties';
    protected $primaryKey = 'documentID'; // 1:1..0 with hardware_assets "HAS A"
    protected $useAutoIncrement = false; //also bcs of 1:1 one with other table
        protected $allowedFields = [
        'documentID',
        'expiration_date',
        'expiration_reminder_check',
        'reminder_sent',
        ];

    protected $validationRules = [
        'expiration_date'             => 'required|valid_date[Y-m-d]', // till 50 years after today is realistic
        'expiration_reminder_check'   => 'permit_empty|in_list[0,1]',//checkbox needs to have true/false
    ];
    

    //inserts if no id, else updates
    public function saveHwWarrantyData($warrantyData) {
            return $this->save($warrantyData);
    }


    public function getDueReminders(): array { // gibt immer Array zurück
        $targetDate = date('Y-m-d', strtotime('-3 weeks'));

        return $this->where('expiration_reminder_check', 1)
                    ->where('expiration_date', $targetDate)
                    ->where('reminder_sent', 0) // wichtig!
                    ->findAll();
    }


    //for Email
    // WarrantyModel.php
    public function getDueRemindersEmail(): array {
        $today = date('Y-m-d');

        return $this->select('hw_asset_warranties.*, hardware_assets.asset_name')
                    ->join('hardware_assets', 'hardware_assets.id = hw_asset_warranties.documentID')
                    ->where('expiration_reminder_check', 1)
                    ->where('expiration_date', $today)
                    ->where('reminder_sent', 0)
                    ->findAll();
    }
}