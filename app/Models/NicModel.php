<?php

namespace App\Models;
use CodeIgniter\Model;

class NicModel extends Model {
    protected $table = 'hw_assets_nic';
    protected $primaryKey = 'hardwareID'; // 1:1..0 with hardware_assets "HAS A"
    protected $useAutoIncrement = false; //also bcs of 1:1 one with other table
        protected $allowedFields = [
        'hardwareID',
        'mac_adress',
        'ip_adress',
        ];

    protected $validationRules = [
        'mac_adress' => 'required|max_length[50]',
        'ip_adress' => 'required|max_length[200]',
    ];


    public function insertNic($data) { //$nicData besser?
        return $this->save($data);
    }

    // updates
    public function updateNic(int $hardwareID, $nicData) {
        return $this->update($hardwareID, $nicData);
    }

    //delete only Nic (Falls Netzwerkkarte ausgebaut)
    public function deleteNic(int $hardwareID, $nicData) {
        return $this->where('hardwareID', $hardwareID)->delete();
    }
}