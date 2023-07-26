@can('document_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.documents.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.document.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.document.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-userDocuments">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.document.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.document.fields.user') }}
                        </th>
                        <th>
                            {{ trans('cruds.document.fields.title') }}
                        </th>
                        <th>
                            {{ trans('cruds.document.fields.policy_number') }}
                        </th>
                        <th>
                            {{ trans('cruds.document.fields.policy_owner') }}
                        </th>
                        <th>
                            {{ trans('cruds.document.fields.start_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.document.fields.end_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.document.fields.maturity_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.document.fields.maturity_amount') }}
                        </th>
                        <th>
                            {{ trans('cruds.document.fields.description') }}
                        </th>
                        <th>
                            {{ trans('cruds.document.fields.premium_payment_amount') }}
                        </th>
                        <th>
                            {{ trans('cruds.document.fields.premium_payment_duration') }}
                        </th>
                        <th>
                            {{ trans('cruds.document.fields.is_reminder') }}
                        </th>
                        <th>
                            {{ trans('cruds.document.fields.policy_purchased_from') }}
                        </th>
                        <th>
                            {{ trans('cruds.document.fields.document_photo') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($documents as $key => $document)
                        <tr data-entry-id="{{ $document->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $document->id ?? '' }}
                            </td>
                            <td>
                                {{ $document->user->name ?? '' }}
                            </td>
                            <td>
                                {{ $document->title ?? '' }}
                            </td>
                            <td>
                                {{ $document->policy_number ?? '' }}
                            </td>
                            <td>
                                {{ $document->policy_owner ?? '' }}
                            </td>
                            <td>
                                {{ $document->start_date ?? '' }}
                            </td>
                            <td>
                                {{ $document->end_date ?? '' }}
                            </td>
                            <td>
                                {{ $document->maturity_date ?? '' }}
                            </td>
                            <td>
                                {{ $document->maturity_amount ?? '' }}
                            </td>
                            <td>
                                {{ $document->description ?? '' }}
                            </td>
                            <td>
                                {{ $document->premium_payment_amount ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\Document::PREMIUM_PAYMENT_DURATION_SELECT[$document->premium_payment_duration] ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\Document::IS_REMINDER_RADIO[$document->is_reminder] ?? '' }}
                            </td>
                            <td>
                                {{ $document->policy_purchased_from ?? '' }}
                            </td>
                            <td>
                                @foreach($document->document_photo as $key => $media)
                                    <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $media->getUrl('thumb') }}">
                                    </a>
                                @endforeach
                            </td>
                            <td>
                                @can('document_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.documents.show', $document->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('document_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.documents.edit', $document->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('document_delete')
                                    <form action="{{ route('admin.documents.destroy', $document->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('document_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.documents.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-userDocuments:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection