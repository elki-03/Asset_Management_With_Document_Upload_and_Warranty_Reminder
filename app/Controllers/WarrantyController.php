<?php

namespace App\Controllers;

use App\Models\WarrantyModel;

class WarrantyController extends BaseController {

    public function showWarrantyForm() {
        helper('form'); 
        return view('warranty/warranty_reminder');
    }


    //shows Detail for one warranty data if there is existing data
    public function showDetail($id) {
        $model = model(HardwareModel::class);
        $data = [
            'hw' => $model->getNicDetail($id),
        ];
        return view('hardware/hardware_asset_detail', $data);
    }


    //Waranty insert into with exiting documetID ald also filled out data (view button click)
    public function saveHwWarranty() {

        $warrantyModel = model(WarrantyModel::class);

        //get Data
        $warrantyData = $this->request->getPost(['documentID','expiration_date', 'expiration_reminder_check']);
        
        // Checkboxes: entweder 1 oder 0 — nie null
        $warrantyData['expiration_reminder_check'] = $this->request->getPost('expiration_reminder_check') ? 1 : 0; //coz of checkbox.else if not checked == NULL --> Errors
        $warrantyData['reminder_sent'] = 0; // might be reason for a service later
       
        $warrantyModel->saveHwWarrantyData($warrantyData);
  
        return redirect()->back()->with(
            'success',
            'Garantie erfolgreich gespeichert.' //waranty successfully saved
        );
    }
}