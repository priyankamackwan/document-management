@extends('layouts.admin')
@section('content')
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
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Document">
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
                <tr>
                    <td>
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <select class="search">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach($users as $key => $item)
                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <select class="search" strict="true">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach(App\Models\Document::PREMIUM_PAYMENT_DURATION_SELECT as $key => $item)
                                <option value="{{ $key }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select class="search" strict="true">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach(App\Models\Document::IS_REMINDER_RADIO as $key => $item)
                                <option value="{{ $key }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>
            </thead>
        </table>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('document_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.documents.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
          return entry.id
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

  let dtOverrideGlobals = {
    buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('admin.documents.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'user_name', name: 'user.name' },
{ data: 'title', name: 'title' },
{ data: 'policy_number', name: 'policy_number' },
{ data: 'policy_owner', name: 'policy_owner' },
{ data: 'start_date', name: 'start_date' },
{ data: 'end_date', name: 'end_date' },
{ data: 'maturity_date', name: 'maturity_date' },
{ data: 'maturity_amount', name: 'maturity_amount' },
{ data: 'description', name: 'description' },
{ data: 'premium_payment_amount', name: 'premium_payment_amount' },
{ data: 'premium_payment_duration', name: 'premium_payment_duration' },
{ data: 'is_reminder', name: 'is_reminder' },
{ data: 'policy_purchased_from', name: 'policy_purchased_from' },
{ data: 'document_photo', name: 'document_photo', sortable: false, searchable: false },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-Document').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  $('.datatable thead').on('input', '.search', function () {
      let strict = $(this).attr('strict') || false
      let value = strict && this.value ? "^" + this.value + "$" : this.value
      table
        .column($(this).parent().index())
        .search(value, strict)
        .draw()
  });
});
</script>
@endsection