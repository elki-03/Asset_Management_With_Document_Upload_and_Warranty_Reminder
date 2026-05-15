<?php

namespace App\Models;

use CodeIgniter\Model;

class HardwareDocumentModel extends Model
{
    protected $table = 'hw_asset_documents';
    protected $primaryKey = 'documentID';

    protected $allowedFields = [
        'hardwareID',
        'original_filename',
        'stored_filename',
        'mime_type',
        'file_size',
        'uploaded_at',
        'document_type'
    ];

    public function getDocumentsForHardware(int $hardwareId): array
    {
        return $this->where('hardwareID', $hardwareId)
                    ->orderBy('uploaded_at', 'DESC')
                    ->findAll();
    }
}