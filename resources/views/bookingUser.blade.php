<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>
<center>
</br>
<div class="container">
  <div class="card" style="width: 20rem;">
  <div class="card-header b">
    Transaksi Kamu
  </div>
  <div class="card-body">
      <table class="table cwite">
  <tbody>
    <tr>
      <th scope="row" class="b">1</th>
      <td class="b">Merk</td>
      <td>{{$datas->merk}}</td>
    </tr>
    <tr>
      <th scope="row" class="b">2</th>
      <td  class="b">Transaksi</td>
      <td>{{$datas->tanggaltransaksi}}</td>
    </tr>
    <tr>
      <th scope="row" class="b">3</th>
      <td class="b">Bank</td>
      <td>{{$datas->bank_company}}</td>
    </tr>
    <tr>
      <th scope="row" class="b">4</th>
      <td  class="b">Jumlah Bayar</td>
      <td>{{$datas->user_price}}</td>
    </tr>
    <tr>
      <th scope="row" class="b">5</th>
      <td  class="b">Status</td>
      @if($datas->status == '1') 
      <td><div class="alert alert-info" role="alert">Berjalan</div></td>
      @elseif($datas->status == '2')
      <td><div class="alert alert-danger">Selesai</div></td>  
      @else
      <td>error</td>
      @endif
      </t>
    </tr>
  </tbody>
</table>
  </div>
</div>
</div>
</center>
</body>
<style>
.topp{
  margin-bottom:50px !important;
}
.img-thumbnail{
    width:70px;
    height: 70px;
}
.card{
    color:white;
 background-color:#28a745;
}
.cwite{
  color:white !important;
}
.b{
  font-weight: bold;
}
</style>
</html>
