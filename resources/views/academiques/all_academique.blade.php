<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<table id="example" class="table table-hover">
    <thead>
        <th>Logo</th>
        <th>Name</th>
        <th>Code</th>
        <th>Telephone</th>
        <th>Email</th>
        <th>Ville</th>
        <th>Status</th>
        <th>Aciton</th>
    </thead>
    <tbody>
        @forelse ($academiques as $item)
        <tr>
            <td><img src="/storage/files/{{$item->logo}}" alt="" class="d-flex align-self-start rounded mr-3" height="64"></td>
            <td>{{$item->name}}</td>
            <td>{{$item->code}}</td>
            <td>{{$item->telephone}}</td>
            <td>{{$item->email}}</td>
            <td>{{$item->ville}}</td>
            <td>
                @if($item->status ==1)
                    <span class="badge bg-success">Oneline</span>
                @else
                    <span class="badge bg-danger">Ofline</span>
                @endif
            </td>
            <td>
                <div class="btn-group">
                    <button class="btn btn-sm btn-primary">Editer</button>
                    <button class="btn btn-sm btn-danger">Supprimer</button>
                </div>
            </td>
        </tr>
        @empty
            <code>Aucun Academique Disponible</code>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <th>Logo</th>
            <th>Name</th>
            <th>Code</th>
            <th>Telephone</th>
            <th>Email</th>
            <th>Ville</th>
            <th>Status</th>
            <th>Aciton</th>
        </tr>
    </tfoot>
</table>
<script>
    $(document).ready(function () {
    $('#example').DataTable();
});
</script>