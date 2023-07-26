<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreDocumentRequest;
use App\Http\Requests\UpdateDocumentRequest;
use App\Http\Resources\Admin\DocumentResource;
use App\Models\Document;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DocumentsApiController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('document_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
      
        if(!empty($request->user()->role_id) && ($request->user()->role_id == config('constants.ADMIN_ROLE_ID'))) {
            return new DocumentResource(Document::with('user','documentType')
                ->whereHas('documentType', function($query) use($request) {
                })->get());   
        }else {
            return new DocumentResource(Document::with('user','documentType')
                ->whereHas('documentType', function($query) use($request) {
                    $query->where('user_id',$request->user()->id);
                })->get());
        }
       
    }

    public function store(StoreDocumentRequest $request)
    {
        $document = Document::create($request->all());

        if ($request->input('document_file', false)) {
            $document->addMedia(storage_path('tmp/uploads/' . $request->input('document_file')))->toMediaCollection('document_file');
        }

        if ($request->input('document_photo', false)) {
            $document->addMedia(storage_path('tmp/uploads/' . $request->input('document_photo')))->toMediaCollection('document_photo');
        }

        return (new DocumentResource($document))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Document $document)
    {
        abort_if(Gate::denies('document_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DocumentResource($document->load(['user']));
    }

    public function update(UpdateDocumentRequest $request, Document $document)
    {
       
        $document->update($request->all());
     
        if ($request->input('document_file', false)) {
            if (!$document->document_file || $request->input('document_file') !== $document->document_file->file_name) {
                if ($document->document_file) {
                    $document->document_file->delete();
                }

                $document->addMedia(storage_path('tmp/uploads/' . $request->input('document_file')))->toMediaCollection('document_file');
            }
        } elseif ($document->document_file) {
            //$document->document_file->delete();
        }

        if ($request->input('document_photo', false)) {
            if (!$document->document_photo || $request->input('document_photo') !== $document->document_photo->file_name) {
                if ($document->document_photo) {
                    $document->document_photo->delete();
                }

                $document->addMedia(storage_path('tmp/uploads/' . $request->input('document_photo')))->toMediaCollection('document_photo');
            }
        } elseif ($document->document_photo) {
            //$document->document_photo->delete();
        }

        if(!empty($request->user()->role_id) && ($request->user()->role_id == config('constants.ADMIN_ROLE_ID'))) {
            return (new DocumentResource(Document::with('user','documentType')
                ->whereHas('documentType', function($query) use($request) {
                })->get())) 
                ->response()
                ->setStatusCode(Response::HTTP_ACCEPTED);
        }else {
            return (new DocumentResource(Document::with('user','documentType')
                ->whereHas('documentType', function($query) use($request) {
                    $query->where('user_id',$request->user()->id);
                })->get()))
                ->response()
                ->setStatusCode(Response::HTTP_ACCEPTED);
        }
    }

    public function destroy(Document $document)
    {
        abort_if(Gate::denies('document_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $document->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
