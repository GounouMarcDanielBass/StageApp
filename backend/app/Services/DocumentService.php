<?php

namespace App\Services;

use App\Models\Document;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class DocumentService
{
    protected array $allowedMimeTypes = [
        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'image/jpeg',
        'image/png',
        'image/gif',
        'text/plain',
    ];

    protected array $allowedExtensions = [
        'pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png', 'gif', 'txt'
    ];

    protected int $maxFileSize = 10240; // KB (10MB)

    /**
     * Upload a document file.
     */
    public function uploadDocument(
        UploadedFile $file,
        User $uploader,
        string $type,
        ?int $applicationId = null,
        ?int $offerId = null,
        ?int $stageId = null
    ): Document {
        // Validate file
        $this->validateFile($file);

        // Generate unique filename
        $originalName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $filename = Str::uuid() . '.' . $extension;

        // Store file
        $path = $file->storeAs('documents', $filename, 'public');

        if (!$path) {
            throw new \Exception('Failed to store file.');
        }

        // Create document record
        $document = Document::create([
            'name' => pathinfo($originalName, PATHINFO_FILENAME),
            'original_name' => $originalName,
            'path' => $path,
            'type' => $type,
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'status' => 'pending',
            'student_id' => $uploader->hasRole('student') ? $uploader->id : null,
            'application_id' => $applicationId,
            'offer_id' => $offerId,
            'stage_id' => $stageId,
            'uploaded_by' => $uploader->id,
        ]);

        Log::info("Document uploaded: {$document->id} by user {$uploader->id}");

        return $document;
    }

    /**
     * Validate uploaded file.
     */
    public function validateFile(UploadedFile $file): void
    {
        // Check file size
        if ($file->getSize() > $this->maxFileSize * 1024) {
            throw new \InvalidArgumentException("File size exceeds maximum limit of {$this->maxFileSize}KB.");
        }

        // Check MIME type
        if (!in_array($file->getMimeType(), $this->allowedMimeTypes)) {
            throw new \InvalidArgumentException('File type not allowed.');
        }

        // Check extension
        $extension = strtolower($file->getClientOriginalExtension());
        if (!in_array($extension, $this->allowedExtensions)) {
            throw new \InvalidArgumentException('File extension not allowed.');
        }

        // Check for malicious content (basic check)
        if ($this->containsMaliciousContent($file)) {
            throw new \InvalidArgumentException('File contains potentially malicious content.');
        }
    }

    /**
     * Approve a document.
     */
    public function approveDocument(Document $document, User $reviewer): bool
    {
        return $document->approve($reviewer);
    }

    /**
     * Reject a document.
     */
    public function rejectDocument(Document $document, User $reviewer, ?string $reason = null): bool
    {
        return $document->reject($reviewer, $reason);
    }

    /**
     * Delete a document and its file.
     */
    public function deleteDocument(Document $document): bool
    {
        try {
            // Delete physical file
            if ($document->path && Storage::disk('public')->exists($document->path)) {
                Storage::disk('public')->delete($document->path);
            }

            // Delete database record
            $document->delete();

            Log::info("Document deleted: {$document->id}");

            return true;
        } catch (\Exception $e) {
            Log::error("Failed to delete document {$document->id}: {$e->getMessage()}");
            return false;
        }
    }

    /**
     * Get document download URL.
     */
    public function getDownloadUrl(Document $document): ?string
    {
        if (!$document->path || !Storage::disk('public')->exists($document->path)) {
            return null;
        }

        return Storage::disk('public')->url($document->path);
    }

    /**
     * Bulk approve documents.
     */
    public function bulkApprove(array $documentIds, User $reviewer): int
    {
        $documents = Document::whereIn('id', $documentIds)
            ->where('status', 'pending')
            ->get();

        $approved = 0;
        foreach ($documents as $document) {
            if ($this->approveDocument($document, $reviewer)) {
                $approved++;
            }
        }

        return $approved;
    }

    /**
     * Bulk reject documents.
     */
    public function bulkReject(array $documentIds, User $reviewer, ?string $reason = null): int
    {
        $documents = Document::whereIn('id', $documentIds)
            ->where('status', 'pending')
            ->get();

        $rejected = 0;
        foreach ($documents as $document) {
            if ($this->rejectDocument($document, $reviewer, $reason)) {
                $rejected++;
            }
        }

        return $rejected;
    }

    /**
     * Get documents statistics.
     */
    public function getStatistics(): array
    {
        return [
            'total' => Document::count(),
            'pending' => Document::where('status', 'pending')->count(),
            'approved' => Document::where('status', 'approved')->count(),
            'rejected' => Document::where('status', 'rejected')->count(),
            'total_size' => Document::sum('size'),
        ];
    }

    /**
     * Clean up orphaned files.
     */
    public function cleanupOrphanedFiles(): int
    {
        $files = Storage::disk('public')->files('documents');
        $cleaned = 0;

        foreach ($files as $file) {
            $document = Document::where('path', $file)->first();
            if (!$document) {
                Storage::disk('public')->delete($file);
                $cleaned++;
            }
        }

        return $cleaned;
    }

    /**
     * Basic malicious content check.
     */
    private function containsMaliciousContent(UploadedFile $file): bool
    {
        $content = file_get_contents($file->getRealPath());

        // Check for common malicious patterns
        $maliciousPatterns = [
            '<?php',
            '<script',
            'javascript:',
            'vbscript:',
            'onload=',
            'onerror=',
        ];

        foreach ($maliciousPatterns as $pattern) {
            if (stripos($content, $pattern) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get allowed file types and sizes.
     */
    public function getAllowedTypes(): array
    {
        return [
            'mime_types' => $this->allowedMimeTypes,
            'extensions' => $this->allowedExtensions,
            'max_size_kb' => $this->maxFileSize,
        ];
    }
}
