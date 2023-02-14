@extends('main')
@section('result')
    <div class="container mt-2">
        <table class="table border border-collapse border-slate-100">
            <thead>
            <tr>
                <th>Клиент</th>
                <th>Счет</th>
                <th>Статус</th>
                <th>Бюджет</th>
                @for($i = 1; $i <= $result['member_count']; $i++)
                    <th>Mem{{$i}}, est</th>
                    <th>Mem{{$i}}, часы</th>
                    <th>Mem{{$i}}, итого$</th>
                @endfor
                <th>Итого затраты</th>
                <th>Валовая прибыль</th>
            </tr>
            </thead>
            <tbody>
            @foreach($result['invoices'] as $invoice)
                <tr>
                    <td>{{$invoice['project']}}</td>
                    <td>{{$invoice['invoice']}}</td>
                    <td>{{$invoice['status']}}</td>
                    <td>{{$invoice['budget']}}</td>
                    @foreach($invoice['members'] as $member)
                        <td>{{$member['est']}}</td>
                        <td>{{$member['spent']}}</td>
                        <td>{{$member['total']}}</td>
                    @endforeach
                    <td>{{$invoice['expenses']}}</td>
                    <td>{{$invoice['profit']}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
