<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyDocumentTypeRequest;
use App\Http\Requests\StoreDocumentTypeRequest;
use App\Http\Requests\UpdateDocumentTypeRequest;
use App\Models\DocumentType;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use Auth;
class DocumentTypesController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('document_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    
        if ($request->ajax()) {
            if(Auth::check()) {
                if(Auth::user()->role_id && Auth::user()->role_id === config('constants.ADMIN_ROLE_ID')){
                    $query = DocumentType::with(['user'])->select(sprintf('%s.*', (new DocumentType)->table));
                }else{
                    $query = DocumentType::with(['user'])->select(sprintf('%s.*', (new DocumentType)->table))
                    ->where('user_id',Auth::id());
                }
            }
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'document_type_show';
                $editGate      = 'document_type_edit';
                $deleteGate    = 'document_type_delete';
                $crudRoutePart = 'document-types';

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
            $table->editColumn('title', function ($row) {
                return $row->title ? $row->title : "";
            });
            $table->addColumn('user_name', function ($row) {
                return $row->user ? $row->user->name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'user']);

            return $table->make(true);
        }

        $users = User::get();

        return view('admin.documentTypes.index', compact('users'));
    }

    public function create()
    {
        abort_if(Gate::denies('document_type_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.documentTypes.create', compact('users'));
    }

    public function store(StoreDocumentTypeRequest $request)
    {
        $documentType = DocumentType::create($request->all());

        return redirect()->route('admin.document-types.index');
    }

    public function edit(DocumentType $documentType)
    {
        abort_if(Gate::denies('document_type_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $documentType->load('user');

        return view('admin.documentTypes.edit', compact('users', 'documentType'));
    }

    public function update(UpdateDocumentTypeRequest $request, DocumentType $documentType)
    {   
        $documentType->update($request->all());

        return redirect()->route('admin.document-types.index');
    }

    public function show(DocumentType $documentType)
    {
        abort_if(Gate::denies('document_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $documentType->load('user');

        return view('admin.documentTypes.show', compact('documentType'));
    }

    public function destroy(DocumentType $documentType)
    {
        abort_if(Gate::denies('document_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $documentType->delete();

        return back();
    }

    public function massDestroy(MassDestroyDocumentTypeRequest $request)
    {
        DocumentType::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
