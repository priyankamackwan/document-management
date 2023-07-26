<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyDocumentRequest;
use App\Http\Requests\StoreDocumentRequest;
use App\Http\Requests\UpdateDocumentRequest;
use App\Models\Document;
use App\Models\DocumentType;
use App\Models\User;
use Gate;
use Auth;
use DB;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
Use \Carbon\Carbon;

class DocumentsController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('document_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            if(Auth::check()) {
                if(Auth::user()->role_id === config('constants.ADMIN_ROLE_ID')){
                    $query = Document::with(['user'])->select(sprintf('%s.*', (new Document)->table));
                }else{
                    $query = Document::with(['user'])->select(sprintf('%s.*', (new Document)->table))
                            ->where('user_id',Auth::id());
                }
            }
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'document_show';
                $editGate      = 'document_edit';
                $deleteGate    = 'document_delete';
                $crudRoutePart = 'documents';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });
            $table->addColumn('user_name', function ($row) {
                return $row->user ? $row->user->name : '';
            });

            $table->editColumn('title', function ($row) {
                return $row->title ? $row->title : "";
            });
            $table->editColumn('policy_number', function ($row) {
                return $row->policy_number ? $row->policy_number : "";
            });
            $table->editColumn('policy_owner', function ($row) {
                return $row->policy_owner ? $row->policy_owner : "";
            });

            $table->editColumn('maturity_amount', function ($row) {
                return $row->maturity_amount ? $row->maturity_amount : "";
            });
            $table->editColumn('description', function ($row) {
                return $row->description ? $row->description : "";
            });
            $table->editColumn('premium_payment_amount', function ($row) {
                return $row->premium_payment_amount ? $row->premium_payment_amount : "";
            });
            $table->editColumn('premium_payment_duration', function ($row) {
                return $row->premium_payment_duration ? Document::PREMIUM_PAYMENT_DURATION_SELECT[$row->premium_payment_duration] : '';
            });
            $table->editColumn('is_reminder', function ($row) {
                return $row->is_reminder ? Document::IS_REMINDER_RADIO[$row->is_reminder] : '';
            });
            $table->editColumn('policy_purchased_from', function ($row) {
                return $row->policy_purchased_from ? $row->policy_purchased_from : "";
            });
            $table->editColumn('document_photo', function ($row) {
                if (!$row->document_photo) {
                    return '';
                }

                $links = [];

                foreach ($row->document_photo as $media) {
                    $links[] = '<a href="' . $media->getUrl() . '" target="_blank"><img src="' . $media->getUrl('thumb') . '" width="50px" height="50px"></a>';
                }

                return implode(' ', $links);
            });

            $table->rawColumns(['actions', 'placeholder', 'user', 'document_photo']);

            return $table->make(true);
        }

        $users = User::get();

        return view('admin.documents.index', compact('users'));
    }

    public function create()
    {
        abort_if(Gate::denies('document_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if(Auth::check()) {
            if(Auth::user()->role_id && Auth::user()->role_id === config('constants.ADMIN_ROLE_ID')){
                $documentType = DocumentType::all()->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');
                $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
            }else {
                $documentType = DocumentType::all()->where('user_id',Auth::user()->id)->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');
                $users = User::all()->where('id',Auth::user()->id)->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
            }
        }
        return view('admin.documents.create', compact('users','documentType'));
    }

    public function store(StoreDocumentRequest $request)
    {

        $document = Document::create($request->all());

        foreach ($request->input('document_file', []) as $file) {
            $document->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('document_file');
        }

        foreach ($request->input('document_photo', []) as $file) {
            $document->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('document_photo');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $document->id]);
        }

        return redirect()->route('admin.documents.index');
    }

    public function edit(Document $document)
    {
        abort_if(Gate::denies('document_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if(Auth::check()) {
            if(Auth::user()->role_id && Auth::user()->role_id == config('constants.ADMIN_ROLE_ID')){
                $documentType = DocumentType::all()->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');
                $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
            }
            else {
                $documentType = DocumentType::all()->where('user_id',Auth::user()->id)->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');
                $users = User::all()->where('id',Auth::user()->id)->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
            }
        }
        $document->load('user');
        return view('admin.documents.edit', compact('users', 'document','documentType'));
    }

    public function update(UpdateDocumentRequest $request, Document $document)
    {
       
        $document->update($request->all());

        if (count($document->document_file) > 0) {
            foreach ($document->document_file as $media) {
                if (!in_array($media->file_name, $request->input('document_file', []))) {
                    $media->delete();
                }
            }
        }

        $media = $document->document_file->pluck('file_name')->toArray();

        foreach ($request->input('document_file', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $document->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('document_file');
            }
        }

        if (count($document->document_photo) > 0) {
            foreach ($document->document_photo as $media) {
                if (!in_array($media->file_name, $request->input('document_photo', []))) {
                    $media->delete();
                }
            }
        }

        $media = $document->document_photo->pluck('file_name')->toArray();

        foreach ($request->input('document_photo', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $document->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('document_photo');
            }
        }

        return redirect()->route('admin.documents.index');
    }

    public function show(Document $document)
    {
        abort_if(Gate::denies('document_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $document->load('user');

        return view('admin.documents.show', compact('document'));
    }

    public function destroy(Document $document)
    {
        abort_if(Gate::denies('document_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $document->delete();

        return back();
    }

    public function massDestroy(MassDestroyDocumentRequest $request)
    {
        Document::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('document_create') && Gate::denies('document_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Document();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }

}
