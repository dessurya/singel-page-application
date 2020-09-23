<table border="1" cellpadding="5" cellspacing="5">
    <tr>
        <th>Name</th>
        <th colspan="2">{{ $Transaction->name }}</th>
    </tr>
    <tr>
        <th>Email</th>
        <th colspan="2">{{ $Transaction->email }}</th>
    </tr>
    <tr>
        <th>Phone</th>
        <th colspan="2">{{ $Transaction->phone }}</th>
    </tr>

    @foreach($datas as $key => $row)
    <tr>
        <th colspan="{{ $row['count_qstn_n_asnwr'] }}" style="background:paleturquoise;">{{ $row['criteria'] }}</th>
    </tr>
    @foreach($row['qstn_n_asnwr'] as $rowSd)
    <tr>
        @foreach($rowSd as $val)
        <td {{ $val == 'true' ? 'style=background:pink;' : '' }}>{{ $val }}</td>
        @endforeach
    </tr>
    @endforeach
     
	@endforeach 

    
</table>