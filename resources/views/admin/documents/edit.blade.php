@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.document.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.documents.update", [$document->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="user_id">{{ trans('cruds.document.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id">
                    @foreach($users as $id => $user)
                        <option value="{{ $id }}" {{ (old('user_id') ? old('user_id') : $document->user->id ?? '') == $id ? 'selected' : '' }}>{{ $user }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <div class="invalid-feedback">
                        {{ $errors->first('user') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.document.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
              <label for="user_id">{{ trans('cruds.document.fields.document_type') }}</label>
                <select class="form-control select2 {{ $errors->has('document_type_id') ? 'is-invalid' : '' }}" name="document_type_id" id="document_type_id">
                    @foreach($documentType as $id => $dtype)
                            <option value="{{ $id }}" {{ (old('document_type_id') ? old('document_type_id') : $document->document_type_id ?? '') == $id ? 'selected' : '' }}>{{ $dtype }}</option>    
                    @endforeach
                </select>
                @if($errors->has('document_type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('document_type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.document.fields.document_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="title">{{ trans('cruds.document.fields.title') }}</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', $document->title) }}" required>
                @if($errors->has('title'))
                    <div class="invalid-feedback">
                        {{ $errors->first('title') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.document.fields.title_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="policy_number">{{ trans('cruds.document.fields.policy_number') }}</label>
                <input class="form-control {{ $errors->has('policy_number') ? 'is-invalid' : '' }}" type="text" name="policy_number" id="policy_number" value="{{ old('policy_number', $document->policy_number) }}">
                @if($errors->has('policy_number'))
                    <div class="invalid-feedback">
                        {{ $errors->first('policy_number') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.document.fields.policy_number_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="policy_owner">{{ trans('cruds.document.fields.policy_owner') }}</label>
                <input class="form-control {{ $errors->has('policy_owner') ? 'is-invalid' : '' }}" type="text" name="policy_owner" id="policy_owner" value="{{ old('policy_owner', $document->policy_owner) }}" required>
                @if($errors->has('policy_owner'))
                    <div class="invalid-feedback">
                        {{ $errors->first('policy_owner') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.document.fields.policy_owner_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="start_date">{{ trans('cruds.document.fields.start_date') }}</label>
                <input class="form-control date {{ $errors->has('start_date') ? 'is-invalid' : '' }}" type="text" name="start_date" id="start_date" value="{{ old('start_date', $document->start_date) }}">
                @if($errors->has('start_date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('start_date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.document.fields.start_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="end_date">{{ trans('cruds.document.fields.end_date') }}</label>
                <input class="form-control date {{ $errors->has('end_date') ? 'is-invalid' : '' }}" type="text" name="end_date" id="end_date" value="{{ old('end_date', $document->end_date) }}">
                @if($errors->has('end_date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('end_date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.document.fields.end_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="maturity_date">{{ trans('cruds.document.fields.maturity_date') }}</label>
                <input class="form-control date {{ $errors->has('maturity_date') ? 'is-invalid' : '' }}" type="text" name="maturity_date" id="maturity_date" value="{{ old('maturity_date', $document->maturity_date) }}">
                @if($errors->has('maturity_date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('maturity_date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.document.fields.maturity_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="maturity_amount">{{ trans('cruds.document.fields.maturity_amount') }}</label>
                <input class="form-control {{ $errors->has('maturity_amount') ? 'is-invalid' : '' }}" type="number" name="maturity_amount" id="maturity_amount" value="{{ old('maturity_amount', $document->maturity_amount) }}" step="0.01">
                @if($errors->has('maturity_amount'))
                    <div class="invalid-feedback">
                        {{ $errors->first('maturity_amount') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.document.fields.maturity_amount_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="description">{{ trans('cruds.document.fields.description') }}</label>
                <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{{ old('description', $document->description) }}</textarea>
                @if($errors->has('description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('description') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.document.fields.description_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="premium_payment_amount">{{ trans('cruds.document.fields.premium_payment_amount') }}</label>
                <input class="form-control {{ $errors->has('premium_payment_amount') ? 'is-invalid' : '' }}" type="number" name="premium_payment_amount" id="premium_payment_amount" value="{{ old('premium_payment_amount', $document->premium_payment_amount) }}" step="0.01">
                @if($errors->has('premium_payment_amount'))
                    <div class="invalid-feedback">
                        {{ $errors->first('premium_payment_amount') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.document.fields.premium_payment_amount_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.document.fields.premium_payment_duration') }}</label>
                <select class="form-control {{ $errors->has('premium_payment_duration') ? 'is-invalid' : '' }}" name="premium_payment_duration" id="premium_payment_duration">
                    <option value disabled {{ old('premium_payment_duration', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Document::PREMIUM_PAYMENT_DURATION_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('premium_payment_duration', $document->premium_payment_duration) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('premium_payment_duration'))
                    <div class="invalid-feedback">
                        {{ $errors->first('premium_payment_duration') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.document.fields.premium_payment_duration_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="premium_payment_date">{{ trans('cruds.document.fields.premium_payment_date') }}</label>
                <input class="form-control date {{ $errors->has('premium_payment_date') ? 'is-invalid' : '' }}" type="text" name="premium_payment_date" id="premium_payment_date" value="{{ old('premium_payment_date', date('m/d/Y', strtotime($document->premium_payment_date))) }}">
                @if($errors->has('premium_payment_date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('premium_payment_date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.document.fields.premium_payment_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.document.fields.is_reminder') }}</label>
                @foreach(App\Models\Document::IS_REMINDER_RADIO as $key => $label)
                    <div class="form-check {{ $errors->has('is_reminder') ? 'is-invalid' : '' }}">
                        <input class="form-check-input" type="radio" id="is_reminder_{{ $key }}" name="is_reminder" value="{{ $key }}" {{ old('is_reminder', $document->is_reminder) === (string) $key ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_reminder_{{ $key }}">{{ $label }}</label>
                    </div>
                @endforeach
                @if($errors->has('is_reminder'))
                    <div class="invalid-feedback">
                        {{ $errors->first('is_reminder') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.document.fields.is_reminder_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="policy_purchased_from">{{ trans('cruds.document.fields.policy_purchased_from') }}</label>
                <input class="form-control {{ $errors->has('policy_purchased_from') ? 'is-invalid' : '' }}" type="text" name="policy_purchased_from" id="policy_purchased_from" value="{{ old('policy_purchased_from', $document->policy_purchased_from) }}">
                @if($errors->has('policy_purchased_from'))
                    <div class="invalid-feedback">
                        {{ $errors->first('policy_purchased_from') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.document.fields.policy_purchased_from_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="document_file">{{ trans('cruds.document.fields.document_file') }}</label>
                <div class="needsclick dropzone {{ $errors->has('document_file') ? 'is-invalid' : '' }}" id="document_file-dropzone">
                </div>
                @if($errors->has('document_file'))
                    <div class="invalid-feedback">
                        {{ $errors->first('document_file') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.document.fields.document_file_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="document_photo">{{ trans('cruds.document.fields.document_photo') }}</label>
                <div class="needsclick dropzone {{ $errors->has('document_photo') ? 'is-invalid' : '' }}" id="document_photo-dropzone">
                </div>
                @if($errors->has('document_photo'))
                    <div class="invalid-feedback">
                        {{ $errors->first('document_photo') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.document.fields.document_photo_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection

@section('scripts')
<script>
    var uploadedDocumentFileMap = {}
Dropzone.options.documentFileDropzone = {
    url: '{{ route('admin.documents.storeMedia') }}',
    maxFilesize: 10, // MB
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 10
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="document_file[]" value="' + response.name + '">')
      uploadedDocumentFileMap[file.name] = response.name
    },
    removedfile: function (file) {
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedDocumentFileMap[file.name]
      }
      $('form').find('input[name="document_file[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($document) && $document->document_file)
          var files =
            {!! json_encode($document->document_file) !!}
              for (var i in files) {
              var file = files[i]
              this.options.addedfile.call(this, file)
              file.previewElement.classList.add('dz-complete')
              $('form').append('<input type="hidden" name="document_file[]" value="' + file.file_name + '">')
            }
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>
<script>
    var uploadedDocumentPhotoMap = {}
Dropzone.options.documentPhotoDropzone = {
    url: '{{ route('admin.documents.storeMedia') }}',
    maxFilesize: 10, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 10,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="document_photo[]" value="' + response.name + '">')
      uploadedDocumentPhotoMap[file.name] = response.name
    },
    removedfile: function (file) {
      console.log(file)
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedDocumentPhotoMap[file.name]
      }
      $('form').find('input[name="document_photo[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($document) && $document->document_photo)
      var files = {!! json_encode($document->document_photo) !!}
          for (var i in files) {
          var file = files[i]
          this.options.addedfile.call(this, file)
          this.options.thumbnail.call(this, file, file.preview)
          file.previewElement.classList.add('dz-complete')
          $('form').append('<input type="hidden" name="document_photo[]" value="' + file.file_name + '">')
        }
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>
@endsection