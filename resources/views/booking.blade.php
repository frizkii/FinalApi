<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <title>Document</title>
</head>

<body>

    <div class="container" >
        <div class="card">
            <center><div class="card-header">Daftar Transaksi</div></center>
            <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Email</th>
                        <th scope="col">Merk</th>
                        <th scope="col">Gambar</th>
                        <th scope="col">Tanggal Transaksi</th>
                        <th scope="col">Nama Bank</th>
                        <th scope="col">Jumlah Bayar</th>
                        <th scope="col">Status</th>
                        <th scope="col">Opsi</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                       
                @foreach($data as $d)
                <tr>
                    <td>{{$d->email}}</td>
                    <td>{{$d->merk}}</td>
                    <td><img src="http://192.168.6.96:8000/api/image/{{$d->gambar}}" alt="..." class="img-thumbnail"></td>
                    <td>{{$d->tanggaltransaksi}}</td>
                    <td>{{$d->bank_company}}</td>
                    <td>{{$d->user_price}}</td>
                    @if($d->status == '1')
                    <td><div class="alert alert-success" role="alert">Berjalan</div></td>
                    @elseif($d->status == '2')
                    <td><div class="alert alert-primary" role="alert">Selesai</div></td>
                    @else
                    <td>error</td>
                    @endif

                    @if($d->opsistatus == 'stop')
                    <form method="POST" action="http://192.168.6.96:8000/a34d56">
                        @csrf
                        <input type="hidden" value="{{$d->id}}" name="id" />
                        <input type="hidden" value="{{$d->u_id}}" name="u_id" />
                        <input type="hidden" value="{{$d->i_id}}" name="i_id" />
                        <input type="hidden" value="{{$d->email}}" name="email" />
                        <input type="hidden" value="{{$d->merk}}" name="merk" />
                        <input type="hidden" value="{{$d->gambar}}" name="gambar" />
                        <input type="hidden" value="{{$d->tanggaltransaksi}}" name="tanggal" />
                        <input type="hidden" value="{{$d->bank_company}}" name="bank" />
                        <input type="hidden" value="{{$d->user_price}}" name="user" />
                        <input type="hidden" value="2" name="status" />
                        <td><input type="submit" class="btn btn-warning" value="Stop" onClick="showActivity()"/></td>
                    </form>

                    @elseif($d->opsistatus == 'hapus')
                    <form method="POST" action="http://192.168.6.96:8000/deletetrs/{{$d->id}}">
                         @csrf
                        <td><button type="submit" class="btn btn-danger" onClick="showActivity()">Hapus</button></td>
                        @else
                        <td>error</td>
                    @endif
                </tr>
                @endforeach
                    </tr>
                </tbody>
            </table>
          </div>
        </div>
  </div>
</body>
<script type="text/javascript">
    function showActivity() {
        Android.startNewActivity();
    }
</script>
<style>
    .container{
        max-width:750px !important;
    }
    .topp {
        margin-bottom: 50px !important;
    }
    
    .img-thumbnail {
        width: 70px;
        height: 70px;
    }
</style>

</html>
