<div class="container">
  <div class="row m-t">
    <div class="col-sm-12">
      <div class="card-box" style="padding:0">
        <div class="row">
          <div class="col-sm-8">
            <h4 class="page-title m-0" style="padding:20px">{{ trans('global.members') }}</h4>
          </div>
          <div class="col-sm-4 text-right">
            <div class="btn-group" style="margin:13px 13px 0 0">
              <button type="button" class="btn btn-inverse dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false">{{ trans('global.export') }} <span class="caret"></span></button>
              <ul class="dropdown-menu pull-right" role="menu">
                <li><a href="{{ url('platform/members/export?type=xls') }}">Excel5 (xls)</a></li>
                <li><a href="{{ url('platform/members/export?type=xlsx') }}">Excel2007 (xlsx)</a></li>
                <li><a href="{{ url('platform/members/export?type=csv') }}">CSV</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
var admin_users_table = $('#dt-table-members').DataTable({
  ajax: "{{ url('platform/members/data') }}",
  order: [
    [0, "asc"]
  ],
  dom: "<'row'<'col-sm-12 dt-header'<'pull-left'lr><'pull-right'f><'pull-right hidden-sm hidden-xs'T><'clearfix'>>>t<'row'<'col-sm-12 dt-footer'<'pull-left'i><'pull-right'p><'clearfix'>>>",
  processing: true,
  serverSide: true,
  stateSave: true,
  responsive: true,
  stripeClasses: [],
  lengthMenu: [
    [10, 25, 50, 75, 100, 1000000],
    [10, 25, 50, 75, 100, "{{ trans('global.all') }}"]
  ],
  columns: [{
    data: "name"
  }, {
    data: "email"
  }, {
    data: "logins"
  }, {
    data: "last_login"
  }, {
    data: "created_at"
  }, {
    data: "active"
  }, {
    data: "sl",
    width: 74,
    sortable: false
  }],
  fnDrawCallback: function() {
    onDataTableLoad();
  },
  columnDefs: [
    {
      render: function (data, type, row) {
        return '<div data-moment="fromNowDateTime">' + data + '</div>';
      },
      targets: [3, 4] /* Column to re-render */
    },
    {
      render: function (data, type, row) {
        return '<div class="text-center">' + data + '</div>';
      },
      targets: [2] /* Column to re-render */
    },
    {
      render: function (data, type, row) {
        if(data == 1)
        {
          return '<div class="text-center"><i class="fa fa-check" aria-hidden="true"></i></div>';
        }
        else
        {
          return '<div class="text-center"><i class="fa fa-times" aria-hidden="true"></i></div>';
        }
      },
      targets: 5
    },
    {
      render: function (data, type, row) {
        return '<div class="row-actions-wrap"><div class="text-center row-actions" data-sl="' + data + '">' + 
          '<a href="#/member/' + data + '" class="btn btn-xs btn-success row-btn-edit" data-toggle="tooltip" title="{{ trans('global.edit') }}"><i class="fa fa-pencil"></i></a> ' + 
          '<a href="javascript:void(0);" class="btn btn-xs btn-danger row-btn-delete" data-toggle="tooltip" title="{{ trans('global.delete') }}"><i class="fa fa-trash"></i></a>' + 
          '</div></div>';
      },
      targets: 6 /* Column to re-render */
    },
  ],
  language: {
    emptyTable: "{{ trans('global.empty_table') }}",
    info: "{{ trans('global.dt_info') }}",
    infoEmpty: "",
    infoFiltered: "(filtered from _MAX_ total entries)",
    thousands: "{{ trans('i18n.thousands_sep') }}",
    lengthMenu: "{{ trans('global.show_records') }}",
    processing: '<i class="fa fa-circle-o-notch fa-spin"></i>',
    paginate: {
      first: '<i class="fa fa-fast-backward"></i>',
      last: '<i class="fa fa-fast-forward"></i>',
      next: '<i class="fa fa-caret-right"></i>',
      previous: '<i class="fa fa-caret-left"></i>'
    }
  }
});

$('#dt-table-members_wrapper .dataTables_filter input').attr('placeholder', "{{ trans('global.search_') }}");

</script>
  <div class="row">
    <div class="col-sm-12">
      <div class="card-box table-responsive">
        <table class="table table-striped table-bordered table-hover" id="dt-table-members" style="width:100%">
          <thead>
            <tr>
              <th>{{ trans('global.name') }}</th>
              <th>{{ trans('global.email') }}</th>
              <th class="text-center">{{ trans('global.logins') }}</th>
              <th>{{ trans('global.last_login') }}</th>
              <th>{{ trans('global.created') }}</th>
              <th class="text-center">{{ trans('global.active') }}</th>
              <th class="text-center">{{ trans('global.actions') }}</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
  <script>

$('#dt-table-members').on('click', '.row-btn-delete', function() {
  var sl = $(this).parent('.row-actions').attr('data-sl');

  swal({
    title: _lang['confirm'],
    type: "warning",
    showCancelButton: true,
    cancelButtonText: _lang['cancel'],
    confirmButtonColor: "#DD6B55",
    confirmButtonText: _lang['yes_delete']
  }, 
  function(){
    blockUI();
  
    var jqxhr = $.ajax({
      url: "{{ url('platform/member/delete') }}",
      data: {sl: sl,  _token: '<?= csrf_token() ?>'},
      method: 'POST'
    })
    .done(function(data) {
      if(data.result == 'success')
      {
        admin_users_table.ajax.reload();
      }
      else
      {
        swal(data.msg);
      }
    })
    .fail(function() {
      console.log('error');
    })
    .always(function() {
      unblockUI();
    });
  });
});

</script> 
</div>
<!-- end container --> 