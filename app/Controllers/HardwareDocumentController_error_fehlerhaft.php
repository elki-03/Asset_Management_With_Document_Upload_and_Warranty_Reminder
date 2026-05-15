<?php
// App/Controllers/HardwareDocumentController.php

namespace App\Controllers;

use App\Models\HardwareDocumentModel;
use App\Models\WarrantyModel;
use App\Services\HardwareDocumentService;

class HardwareDocumentController extends BaseController
{
    protected HardwareDocumentService $documentService;

    public function __construct()
    {
        $this->documentService = new HardwareDocumentService();
    }

    //upload
    public function uploadDocument(int $hardwareID)
    {
        $rules = [
            'pdf' => [
                'label' => 'PDF-Datei',
                'rules' => [
                    'uploaded[pdf]',
                    'max_size[pdf,5120]',
                    'ext_in[pdf,pdf]',
                    'mime_in[pdf,application/pdf]',
                ],
            ],
            'document_type' => [
                'label' => 'Dokumentenart',
                'rules' => ['required', 'in_list[manual,warranty,invoice,other]'],
            ],
        ];

        if (! $this->validateData($this->request->getPost(), $rules)) {
            return redirect()->back()->withInput()
                ->with('upload_errors', $this->validator->getErrors());
        }

        try {
            $this->documentService->uploadDocument(
                $this->request->getFile('pdf'),
                $hardwareID,
                $this->request->getPost('document_type')
            );
        } catch (\RuntimeException $e) {
            return redirect()->back()->with('upload_errors', [$e->getMessage()]);
        }

        return redirect()->back()->with('success', 'Dokument erfolgreich hochgeladen.');
    }



    //sjow all hw doc
    public function showDocument(int $hardwareID)
    {
        $hardwareModel = model(HardwareModel::class);

        // check if hwID existst
        if (! $hardwareModel->find($hardwareID)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException(
                "Hardware mit ID $hardwareID nicht gefunden."
            );
        }
    
        $documentModel = model(HardwareDocumentModel::class);

        return view('hardware_documents/hardware_document_upload', [
            'documents'  => $documentModel->getDocumentsForHardware($hardwareID),
            'hardwareID' => $hardwareID,
        ]);
    }



    // show singlehw doc
   public function showSingleHwDoc(int $hardwareID, int $documentID) {

    //check if doc exists
    $document = model(HardwareDocumentModel::class)->find($documentID);
    if (! $document) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException(
            "Dokument mit ID $documentID nicht gefunden."
        );
    }

    $filePath = $this->documentService->getFilePath($document);

    // check if file exists with path
    if (! file_exists($filePath)) {
        log_message('error', "Datei fehlt auf Disk: $filePath (documentId=$documentID)");
        return redirect()->back()->with('error', 'Die Datei konnte nicht gefunden werden.');
    }


    return $this->response
        ->setHeader('Content-Type', 'application/pdf')
        ->setHeader('Content-Disposition', 'inline; filename="' . $document['original_filename'] . '"')
        ->setBody(file_get_contents($filePath));
    }
    

    //delete
   public function deleteHwDoc(int $hardwareID, int $documentID) {
        // Ownership doc belongs to hw?
        $document = model(HardwareDocumentModel::class)->find($documentID);
        if (! $document || (int) $document['hardwareID'] !== $hardwareID) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException(
                "Dokument nicht gefunden oder gehört nicht zu dieser Hardware."
            );
        }

        try {
            $this->documentService->deleteDocument($documentID);
        } catch (\RuntimeException $e) {
            log_message('error', "Löschen fehlgeschlagen: documentID=$documentID – " . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->to("/hardware/$hardwareID/documents")
            ->with('success', 'Dokument gelöscht.');
    }

    //warranty part
    public function openWarrantyWindow(int $hardwareID, int $documentID) {
    // does doc belong to hw? does doc exist?
        $document = model(HardwareDocumentModel::class)->find($documentID);
        if (! $document || (int) $document['hardware_id'] !== $hardwareID) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException(
                "Dokument nicht gefunden oder gehört nicht zu dieser Hardware."
            );
        }

        helper('form');
        $warrantyModel  = model(WarrantyModel::class);
        $singleWarranty = $warrantyModel->where('documentID', $documentID)->first();

        if (! $singleWarranty) {
            $singleWarranty = [
                'documentID'                => $documentID,
                'hardwareID'                => $hardwareID,
                'expiration_date'           => '',
                'expiration_reminder_check' => 0,
                'reminder_sent'             => 0,
            ];
        }

        return view('warranty/warranty_reminder', ['single_warranty' => $singleWarranty]);
    }
}