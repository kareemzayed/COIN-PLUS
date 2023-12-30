<table>
    <thead>
    <tr>
        <th>{{__('Key')}}</th>
        <th>{{__('Value')}}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($languages as $key => $value)
        <tr>
            <td>{{ $key }}</td>
            <td>{{ $value }}</td>
        </tr>
    @endforeach
    </tbody>
</table>