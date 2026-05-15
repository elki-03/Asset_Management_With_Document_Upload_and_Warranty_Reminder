<?php

namespace App\Models;
use CodeIgniter\Model;

class HardwareModel extends Model {
    protected $table = 'hardware_assets';
    protected $primaryKey = 'hardwareID';//weil nur id reicht nicht
    protected $allowedFields = [
        'hardwareID',
        'hw_name',
        'hw_type',
        'hw_function',
        'hw_manufacturer',
        'hw_model',
        'hw_serial_number',
        'hw_inventory',
        'hw_deprecated',
        'hw_status',
        'hw_has_network_interface_card',
        // 'ownerID', // later implementation
        // 'owner_deputyID',
        // 'adminID',
        // 'admin_deputyID'
        ];

        protected $validationRules = [
        'hw_name' => 'required|max_length[255]|min_length[3]',
        'hw_type' => 'required|max_length[255]|min_length[3]',
        'hw_function' => 'required|max_length[400]|min_length[3]',
        'hw_manufacturer'  => 'required|max_length[5000]|min_length[10]',
        'hw_model' => 'required|max_length[255]|min_length[3]',
        'hw_serial_number' => 'required|max_length[1000]|min_length[10]',
        'hw_inventory' => 'in_list[0,1]', //checkbox
        'hw_deprecated' => 'in_list[0,1]',
        'hw_status' => 'required',
        'hw_has_network_interface_card' => 'in_list[0,1]',
    ];


    //read
    public function getHwTable() {
        return $this->findAll();
    }

    //read for single hw
    public function getHwDetail($id) {
        return $this->find($id);
    }

    //gets from db data for hardware and nic-data    
    public function getNicDetail($id): ?array { //array or NULL for getRowArray()
    return $this->db->table('hardware_assets a')
        ->select('a.*, n.mac_adress, n.ip_adress')
        ->join('hw_assets_nic n', 'n.hardwareID = a.hardwareID', 'left')
        ->where('a.hardwareID', $id)
        ->get()
        ->getRowArray();
    }

    //inserts data for one hardware into db
    public function insertHw($data) {
        return $this->save($data);
    }

    // updates
    public function updateHw(int $hardwareID, $hwData) {
        return $this->update($hardwareID, $hwData);
    }

    //delete hardware together with nic. cascading delete within mysql-db with pk-fk (pk =fk)
    public function deleteHw(int $hardwareID, $hwData) {
        return $this->where('hardwareID', $hardwareID)->delete();
    }
}