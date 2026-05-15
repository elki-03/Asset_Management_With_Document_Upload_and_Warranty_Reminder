<?php
// App/Services/HardwareDocumentService.php

namespace App\Services;

use App\Models\HardwareDocumentModel;
use CodeIgniter\HTTP\Files\UploadedFile;

class HardwareDocumentService
{
    protected HardwareDocumentModel $documentModel;
    protected string $uploadPath;

    public function __construct()
    {
        $this->documentModel = model(HardwareDocumentModel::class);
        $this->uploadPath    = WRITEPATH . 'uploads/hardware_documents/';
    }

    
     //Datei speichern + DB-Eintrag anlegen.
     //ibt im Fehlerfall eine Exception, kein redirect() – das ist Controllersache.
    public function uploadDocument(UploadedFile $file, int $hardwareId, string $documentType): void
    {
        $storedFilename = $file->getRandomName();

        // Dateisystem
        if (! $file->move($this->uploadPath, $storedFilename)) {
            throw new \RuntimeException('Datei konnte nicht gespeichert werden.');
        }

        // Datenbank
        $inserted = $this->documentModel->insert([
            'hardwareID'        => $hardwareId,
            'original_filename' => $file->getClientName(),
            'stored_filename'   => $storedFilename,
            'mime_type'         => $file->getClientMimeType(),
            'file_size'         => $file->getSize(),
            'uploaded_at'       => date('Y-m-d H:i:s'),
            'document_type'     => $documentType,
        ]);

        // Rollback: Datei wieder löschen wenn DB fehlschlägt
        if (! $inserted) {
            @unlink($this->uploadPath . $storedFilename);
            throw new \RuntimeException('Datenbankfehler beim Speichern des Dokuments.');
        }
    }

    //Datei löschen + DB-Eintrag entfernen
    public function deleteDocument(int $documentId): void
    {
        $document = $this->documentModel->find($documentId);

        if (! $document) {
            throw new \RuntimeException('Dokument nicht gefunden.');
        }

        $filePath = $this->uploadPath . $document['stored_filename'];

        // Dateisystem
        if (file_exists($filePath) && ! @unlink($filePath)) {
            throw new \RuntimeException('Datei konnte nicht gelöscht werden.');
        }

        // Datenbank (erst nach erfolgreichem unlink)
        if (! $this->documentModel->delete($documentId)) {
            // Datei ist weg, DB-Eintrag bleibt – das loggen wir wenigstens
            log_message('error', "Dokument {$documentId}: Datei gelöscht, DB-Delete fehlgeschlagen.");
            throw new \RuntimeException('Datenbankfehler beim Löschen des Dokuments.');
        }
    }

     //Vollständigen Dateipfad für ein Dokument zurückgeben.
    public function getFilePath(array $document): string
    {
        return $this->uploadPath . $document['stored_filename'];
    }
}