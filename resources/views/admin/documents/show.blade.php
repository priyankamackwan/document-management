@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.document.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.documents.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.document.fields.id') }}
                        </th>
                        <td>
                            {{ $document->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.document.fields.user') }}
                        </th>
                        <td>
                            {{ $document->user->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.document.fields.title') }}
                        </th>
                        <td>
                            {{ $document->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.document.fields.document_type') }}
                        </th>
                        <td>
                            {{ $document->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.document.fields.policy_number') }}
                        </th>
                        <td>
                            {{ $document->policy_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.document.fields.policy_owner') }}
                        </th>
                        <td>
                            {{ $document->policy_owner }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.document.fields.start_date') }}
                        </th>
                        <td>
                            {{ $document->start_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.document.fields.end_date') }}
                        </th>
                        <td>
                            {{ $document->end_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.document.fields.maturity_date') }}
                        </th>
                        <td>
                            {{ $document->maturity_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.document.fields.maturity_amount') }}
                        </th>
                        <td>
                            {{ $document->maturity_amount }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.document.fields.description') }}
                        </th>
                        <td>
                            {{ $document->description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.document.fields.premium_payment_amount') }}
                        </th>
                        <td>
                            {{ $document->premium_payment_amount }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.document.fields.premium_payment_duration') }}
                        </th>
                        <td>
                            {{ App\Models\Document::PREMIUM_PAYMENT_DURATION_SELECT[$document->premium_payment_duration] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.document.fields.is_reminder') }}
                        </th>
                        <td>
                            {{ App\Models\Document::IS_REMINDER_RADIO[$document->is_reminder] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.document.fields.policy_purchased_from') }}
                        </th>
                        <td>
                            {{ $document->policy_purchased_from }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.document.fields.document_file') }}
                        </th>
                        <td>
                            @foreach($document->document_file as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.document.fields.document_photo') }}
                        </th>
                        <td>
                            @foreach($document->document_photo as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.documents.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection