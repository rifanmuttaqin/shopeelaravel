<table class="table">
<thead>
    <tr>
    <th scope="col">No</th>
    <th scope="col">Nama Pelanggan</th>
    <th scope="col">WA</th>
    <th scope="col">Domisili</th>
    </tr>
</thead>
<tbody>

    @foreach ($data as $key => $customer)
        <tr>
            <th scope="row">{{ $key+1 }}</th>
            <td>{{ $customer[0] }}</td>
            <td>{{ $customer[1] }}</td>
            <td>{{ $customer[2] }}</td>
        </tr>        
    @endforeach

</tbody>
</table>