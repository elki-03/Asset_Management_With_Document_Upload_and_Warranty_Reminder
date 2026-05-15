<?php

namespace App\Controllers;

use App\Models\HardwareModel;
use App\Models\NicModel;
use App\Services\HardwareService;

class HardwareController extends BaseController {

    public function index() {
        $model = model(HardwareModel::class);
        $data = [
            'hw_list' => $model->getHwTable(),
        ];
        return view('hardware/hardware_asset_table', $data);
    }

    public function showDetail($id) {
        helper('form');

        $hwModel       = model(HardwareModel::class);
        $documentModel = model(\App\Models\HardwareDocumentModel::class);
        $warrantyModel = model(\App\Models\WarrantyModel::class);

        $documents = $documentModel->getDocumentsForHardware($id);

        $warranties = [];
        foreach ($documents as $document) {
            if ($document['document_type'] === 'warranty') {
                $warranty = $warrantyModel->where('documentID', $document['documentID'])->first();
                if (!$warranty) {
                    $warranty = [
                        'documentID'                => $document['documentID'],
                        'expiration_date'           => '',
                        'expiration_reminder_check' => 0,
                        'reminder_sent'             => 0,
                    ];
                }
                $warranties[$document['documentID']] = $warranty;
            }
        }

        //type and existance check
        $hw = $hwModel->getNicDetail($id);
        if (! $hw) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException(
                "Hardware mit ID $id nicht gefunden."
            );
        }

        $data = [
            'hw' => $hw,
            'documents' => $documents,
            'hardwareID'=> $id,
            'warranties'=> $warranties,
        ];

        return view('hardware/hardware_asset_detail', $data);
    }
    

    public function createHw() {

        $service = new HardwareService(); //instantiate directly no registration on services for now coz project too small

        $result = $service->createHardware(
            $this->request->getPost()
        );

        if (!$result['success']) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $result['errors']);
            }

        return redirect()
            ->to('hardware/hardware_asset_table')
            ->with('success', 'Hardware erfolgreich erstellt.');
    }

    public function showCreateDetailForm() {
        helper('form');
        return view('hardware/hardware_asset_detail_create', [
            'single_hw' => []
        ]);
    }

    public function showEditDetailForm(int $hardwareID) {
        helper('form');

        $hwModel = model(HardwareModel::class);
        $hw      = $hwModel->getNicDetail($hardwareID);

        if (!$hw) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('hardware/hardware_asset_detail_create', [
            'single_hw' => $hw
        ]);
    }

public function update(int $hardwareID)
{
    $hwModel = model(HardwareModel::class);

    if (!$hwModel->find($hardwareID)) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    $service = new HardwareService();

    $result = $service->updateHardware(
        $hardwareID,
        $this->request->getPost()
    );

    if (!$result['success']) {
        return redirect()->back()
            ->withInput()
            ->with('errors', $result['errors']);
    }

    return redirect()
        ->to('hardware/hardware_asset_table')
        ->with('success', 'Hardware erfolgreich aktualisiert.');
    }


    //before if $id not existed, it would still be "succesfully deleted. also when delete() failed, there was still success msg
    public function deleteHw(int $id) {
        $hwModel = model(HardwareModel::class);

        if (! $hwModel->find($id)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException(
                "Hardware mit ID $id nicht gefunden."
            );
        }

        try {
            $hwModel->delete($id);
        } catch (\Throwable $e) {
            log_message('error', "Hardware löschen fehlgeschlagen ID=$id: " . $e->getMessage());
            return redirect()->back()->with('error', 'Hardware konnte nicht gelöscht werden.');
        }

        return redirect()->to('hardware/hardware_asset_table')
            ->with('success', 'Hardware erfolgreich gelöscht.');
    }
}