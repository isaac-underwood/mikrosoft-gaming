<div class="col-lg-12 col-sm-12">
    <table class="table table-bordered">
        <thead>
            <th>Username</th>
            <th style="text-align:center;background:transparent;"><a href="#" class="addRowMikro"><i
                class="glypicon glyphicon-plus"></i>+</a></th>
        </thead>
        <tbody id="tr">
            <tr>
                <td>
                    <select name="userIDs[]" id="user-select">
                        @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->username }}</option>
                        @endforeach
                    </select>
                    <td class="text-center"><a href="#" class=" btn btn-danger btn-sm removeMikro"><i
                        class="glypicon glyphicon-plus"></i>X</a></td>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<script type="text/javascript">
    $('.addRowMikro').on('click', function() {
    addRowMikro();
    });
function addRowMikro() {
    var tr = '<tr>' +
        '<td>' +
        '<select name="userIDs[]" id="user-select">' +
        '<option value="">--Please choose a user--</option>' +
        '@foreach ($users as $user)' +
        '<option value="{{ $user->id }}">{{ $user->username }}</option>' +
        '@endforeach' +
        '</select>' +
        '</td>' +
        '<td class="text-center"><a href="#" class="btn btn-danger btn-sm removeMikro"><i class="glypicon glyphicon-plus"></i>X</a></td>' +
        '</tr>';
        $('#tr').append(tr);
        $('.removeMikro').on('click', function() {
        $(this).parent().parent().remove();
    })
};
</script>