<?php

namespace App\Services;

use App\Models\HardwareModel;
use App\Models\NicModel;
use Config\Database;

class HardwareService
{
    protected HardwareModel $hwModel;
    protected NicModel $nicModel;

    public function __construct() {
        $this->hwModel  = model(HardwareModel::class);
        $this->nicModel = model(NicModel::class);
    }

    public function createHardware(array $postData): array {
        $db = Database::connect();

        $hwData = $this->prepareHardwareData($postData);

        $db->transStart();

        if (!$this->hwModel->insert($hwData)) {
            return [
                'success' => false,
                'errors'  => $this->hwModel->errors(),
            ];
        }

        $hardwareID = $this->hwModel->getInsertID();

        $this->saveNic($hardwareID, $postData, $hwData);

        $db->transComplete();

        if (!$db->transStatus()) {
            return [
                'success' => false,
                'errors'  => ['db' => 'Datenbankfehler'],
            ];
        }

        return ['success' => true];
    }

    public function updateHardware(int $hardwareID, array $postData): array {
        $db = Database::connect();

        $hwData = $this->prepareHardwareData($postData);

        $db->transStart();

        if (!$this->hwModel->update($hardwareID, $hwData)) {
            return [
                'success' => false,
                'errors'  => $this->hwModel->errors(),
            ];
        }

        $this->saveNic($hardwareID, $postData, $hwData);

        $db->transComplete();

        if (!$db->transStatus()) {
            return [
                'success' => false,
                'errors'  => ['db' => 'Datenbankfehler'],
            ];
        }

        return ['success' => true];
    }

    protected function saveNic(int $hardwareID, array $postData, array $hwData): void
    {
        if ($hwData['hw_has_network_interface_card']) {

            $nicData = [
                'hardwareID' => $hardwareID,
                'mac_adress' => $postData['mac_adress'] ?? null,
                'ip_adress'  => $postData['ip_adress'] ?? null,
            ];

            $nic = $this->nicModel
                ->where('hardwareID', $hardwareID)
                ->first();

            if ($nic) {
                $this->nicModel->update($nic['hardwareID'], $nicData);
            } else {
                $this->nicModel->insert($nicData);
            }

        } else {

            $this->nicModel
                ->where('hardwareID', $hardwareID)
                ->delete();
        }
    }

    protected function prepareHardwareData(array $postData): array
    {
        return [
            'hw_name'                       => $postData['hw_name'] ?? null,
            'hw_type'                       => $postData['hw_type'] ?? null,
            'hw_function'                   => $postData['hw_function'] ?? null,
            'hw_manufacturer'               => $postData['hw_manufacturer'] ?? null,
            'hw_model'                      => $postData['hw_model'] ?? null,
            'hw_serial_number'              => $postData['hw_serial_number'] ?? null,
            'hw_inventory'                  => isset($postData['hw_inventory']) ? 1 : 0,
            'hw_deprecated'                 => isset($postData['hw_deprecated']) ? 1 : 0,
            'hw_status'                     => $postData['hw_status'] ?? null,
            'hw_has_network_interface_card' => isset($postData['hw_has_network_interface_card']) ? 1 : 0,
            'ownerID'                       => $postData['ownerID'] ?? null,
            'owner_deputyID'                => $postData['owner_deputyID'] ?? null,
            'adminID'                       => $postData['adminID'] ?? null,
            'admin_deputyID'                => $postData['admin_deputyID'] ?? null,
        ];
    }
}