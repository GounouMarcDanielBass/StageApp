<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DocumentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Document::query();

        if ($user->role->name === 'admin') {
            // Admin can see all documents
        } elseif ($user->role->name === 'entreprise') {
            $query->whereHas('offer.entreprise', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        } else {
            $query->where('student_id', $user->id);
        }

        if ($request->has('offer_id')) {
            $query->where('offer_id', $request->offer_id);
        }

        $documents = $query->with(['student', 'offer'])->get();
        return response()->json($documents);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,doc,docx,jpg,png|max:5120',
            'type' => 'required|string|in:CV,Motivation Letter,Report',
            'offer_id' => 'nullable|integer|exists:offers,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $file = $request->file('file');
        $path = $file->store('documents');
        $mimeType = $file->getMimeType();
        $size = $file->getSize();

        $document = Document::create([
            'name' => $request->name,
            'path' => $path,
            'type' => $request->type,
            'mime_type' => $mimeType,
            'size' => $size,
            'status' => 'pending',
            'student_id' => Auth::id(),
            'offer_id' => $request->offer_id,
        ]);

        return response()->json($document, 201);
    }

    public function show(Document $document)
    {
        $this->authorize('view', $document);
        return response()->json($document->load(['student', 'offer']));
    }

    public function update(Request $request, Document $document)
    {
        $this->authorize('update', $document);

        $validator = Validator::make($request->all(), [
            'status' => 'required|string|in:pending,validated,rejected',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $document->update($request->only('status'));

        return response()->json($document);
    }

    public function destroy(Document $document)
    {
        $this->authorize('delete', $document);
        Storage::delete($document->path);
        $document->delete();

        return response()->json(null, 204);
    }
}
