@extends('layouts.header')
@section('content')
<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">Дата</th>
      <th scope="col">Банк</th>
      <th scope="col">Валюта</th>
      <th scope="col">Продажа (грн)</th>
      <th scope="col">Покупка (грн)</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($values as $v)
    <tr>
      <td>{{$v['date']}}</td>
      <td>{{$v['bankName']}}</td>
      <td class="text-primary">{{$v['codeAlpha']}}</td>
      <td class="text-success">{{round($v['rateBuy'], 2)}}</td>
      <td class="text-danger">{{round($v['rateSale'], 2)}}</td>
    </tr>
    @endforeach
  </tbody>
</table>
@endsection
