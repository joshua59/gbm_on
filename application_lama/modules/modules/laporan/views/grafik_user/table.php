    <table id="dataTable" class="display" cellspacing="0" style="max-height:1000px;width: 100%">
        <thead>
            <tr>
                <th></th>
                <th>LEVEL USER</th>
                <th>JUMLAH LOGIN</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
<script type="text/javascript">
    var userCounter = 1;
    var n_obj = '<?php echo json_encode($obj) ?>';
    var obj = JSON.parse(n_obj);
    var t = $('#dataTable').DataTable({
                data: obj,
                paging: false,
                ordering:false,
                columns: [{
                  className: 'term-details-control',
                  orderable: false,
                  data: null,
                  defaultContent: '<img src="http://i.imgur.com/SD7Dz.png">'
                }, {
                  data: "LEVEL_USER"
                }, {
                  data: "log_count"
                }]
            });
    $('#dataTable tbody').on('click', 'td.term-details-control', function() {
        var tr = $(this).closest('tr');
        var row = t.row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(formatUser(userCounter)).show();
            tr.addClass('shown');

            var termTable = $('#user_' + userCounter).dataTable({
                data: row.data().user,
                paging: false,
                searching: false,
                ordering: false,
                columns: [{
                    data: "username"
                },{
                    data: "nama_regional"
                },{
                    data: "level1"
                },{
                    data: "level2"
                }, {
                    data: "level3"
                },{
                    data: "total"
                }],
                order: [
                    [1, 'asc']
                ]
            });

            userCounter += 1;
        }
    });

    function formatUser(table_id) {
      return '<table class="table table-striped" id="user_' + table_id + '">' +
        '<thead><tr><th>Username</th><th>Nama Regional</th><th>Level 1</th><th>Level 2</th><th>Level 3</th><th>Jumlah Login</th></tr></thead></table>';
    }

</script>