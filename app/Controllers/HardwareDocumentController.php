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
    public function uploadDocument(int $hardwareId)
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
                $hardwareId,
                $this->request->getPost('document_type')
            );
        } catch (\RuntimeException $e) {
            return redirect()->back()->with('upload_errors', [$e->getMessage()]);
        }

        return redirect()->back()->with('success', 'Dokument erfolgreich hochgeladen.');
    }

    //sjow all hw
    public function showDocument(int $hardwareId)
    {
        $documentModel = model(HardwareDocumentModel::class);

        return view('hardware_documents/hardware_document_upload', [
            'documents'  => $documentModel->getDocumentsForHardware($hardwareId),
            'hardwareId' => $hardwareId,
        ]);
    }

    // show singlehw doc
    public function showSingleHwDoc(int $hardwareId, int $documentId)
    {
        $document = model(HardwareDocumentModel::class)->find($documentId);
        $filePath = $this->documentService->getFilePath($document);

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'inline; filename="' . $document['original_filename'] . '"')
            ->setBody(file_get_contents($filePath));
    }

    //delete
    public function deleteHwDoc(int $hardwareId, int $documentId)
    {
        try {
            $this->documentService->deleteDocument($documentId);
        } catch (\RuntimeException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->to("/hardware/$hardwareId/documents")
            ->with('success', 'Dokument gelöscht.');
    }

    //warranty part
    public function openWarrantyWindow(int $hardwareID, int $documentID)
    {
        helper('form');

        $warrantyModel   = model(WarrantyModel::class);
        $singleWarranty  = $warrantyModel->where('documentID', $documentID)->first();

        if (! $singleWarranty) {
            $singleWarranty = [
                'documentID'                 => $documentID,
                'hardwareID'                 => $hardwareID,
                'expiration_date'            => '',
                'expiration_reminder_check'  => 0,
                'reminder_sent'              => 0,
            ];
        }

        return view('warranty/warranty_reminder', ['single_warranty' => $singleWarranty]);
    }
}