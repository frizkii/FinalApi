<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\ModelUser;
use App\dummy;
use App\ModelSepeda;
use App\ModelBooking as booking;
use Validator;
use Response;
use Auth;
use DB;

class ApiController extends Controller
{ 
    
  public function pagelogin(Request $request){
    $email = $request->email;
    $password = $request->password;
    $akun = DB::table('TBUser')->where('email', $request->email)->first();
    if(!isset($akun)){
      $arr = array("status" => 201, "message" => "email incorect");
      return response()->json($arr);
    }
    $valPass = $akun->password;
    if($valPass == $password){
       if($akun->role_user =='2'){
          $getdata = DB::table('TBUser')->where('id', $akun->id)->first();
          $arr = array("status" => 200,"role" => "1","message" => "SUCCES", "data" => $getdata);
          return view('home',["data"=>$getdata]);
       }
    }else{  
      $arr = array("status" => 201, "message" => "password incorect");
      return response()->json($arr);
    } 

  }
  public function adminDelete($id){
    $data = booking::where('id',$id)->first();
    $data->delete();
    return redirect("booking");
  }
  public function adminOpsi(Request $r){
    DB::table('TBTransaksi')->where('id',$r->id)->update([
      'u_id' => $r->u_id,
      'i_id' => $r->i_id,
      'email' => $r->email,
      'merk' => $r->merk,
      'gambar' => $r->gambar,
      'tanggaltransaksi' => $r->tanggal,
      'bank_company' => $r->bank,
      'user_price' => $r->user,
      'status' => $r->status,
      'opsistatus'=> "hapus"
    ]);
    return redirect("booking");
  }
  public function update_item(Request $request){
    $id = $request->id;
    $getkodesepeda = $request->kodesepeda;
    $getmerk = $request->merk;
    $getwarna = $request->warna;
    $gethargasewa = $request->hargasewa;
    $mg = $request->file('image')->getClientOriginalName();
    $IsImage = DB::table('TBSepeda')->where('gambar', $mg)->first();
    $TbImage = DB::table('TBSepeda')->where('id', $id)->first();
    $OldImage = $TbImage->gambar;
    $path = storage_path('images/'.$OldImage);
    if(is_null($IsImage)){
      File::delete($path);
      $image = $request->file('image');
      $name = time().'.'.$image->getClientOriginalExtension();
      $destinationPath = storage_path('/images');
      $image->move($destinationPath, $name);
      $result = DB::table('TBSepeda')->where('id',$id)->update([
      'kodesepeda' => $getkodesepeda,
      'merk' => $getmerk,
      'warna' => $getwarna,
      'gambar' => $name,
      'hargasewa' => $gethargasewa
    ]);
    $arr = array(
      "status" => 200,  
      "message" => "SUCCES",
       "data" => '!Berhasil Update'
      );
    return response()->json($arr);
    if(!isset($result)){
      $result = array(
        "status" => 403,
        "message" => "FAILED",
        "data" => "Terjadi kesalahan saat mengirim data"
      );
      return response()->json($result);
    }
     $result = array(
       "status" => 200,
       "message" => "SUCCES",
       "data" => $result
      );
     return response()->json($result);
    }else{
      $result = DB::table('TBSepeda')->where('id',$id)->update([
        'kodesepeda' => $getkodesepeda,
        'merk' => $getmerk,
        'warna' => $getwarna,
        'gambar' => $mg,
        'hargasewa' => $gethargasewa
     ]);
     $arr = array(
       "status" => 200,
       "message" => "SUCCES",
       "data" => "Berhasil Update"
      );
     return response()->json($arr);
    }
  }
  public function viewbooking(){
      $result = booking::all();
      $cnt = $result->count();
      return view('booking',["data" => $result,"count"=>$cnt]);
  }
  public function viewbooking2(Request $req,$id){ 
    $getData = DB::table('TBTransaksi')->where('u_id',$id)->first();
    if(!isset($getData)){
      return view("bookingnotfound");
    }
    return view("bookingUser",["datas"=>$getData]);
  }
  public function userbooking2(Request $req){
    $u_id = $req->u_id;
    $i_id = $req->i_id;
    $price = $req->price;
    $bank = $req->bank;
    $getemail = DB::table('TBUser')->where('id', $u_id)->first();
    $getmerk = DB::table('TBSepeda')->where('id', $i_id)->first();
    $email = $getemail->email;
    $merk = $getmerk->merk;
    $gambar = $getmerk->gambar;
    $booking =booking::insert([
      'u_id' => $u_id,
      'i_id' => $i_id,
      'email' => $email,
      'merk' => $merk,
      'gambar' => $gambar,
      'tanggaltransaksi' => date("j, n, Y"),
      'bank_company' => $bank,
      'user_price'=>"$price",
      'status' => 1,
      'opsistatus' => "stop"
    ]);
    $arr = array("status" => 200,"message" => "SUCCES", "data" => "SUCCES");
    return response()->json($arr);
 }
  public function customerupdate(Request $request){
    $id = $request->id;
    $email = $request->email;
    $password = $request->password;
    $nama = $request->nama;
    $nohp = $request->nohp;
    $alamat = $request->alamat;
    $noktp = $request->noktp;
    DB::table('TBUser')->where('id',$id)->update([
      'email' => $email,
      'password' => $password,
      'nama' => $nama,
      'nohp' => $nohp,
      'alamat' => $alamat,
      'noktp' => $noktp
    ]);
    $arr = array("status" => 200,"message" => "SUCCES", "data" => "SUCCES");
    return response()->json($arr);
  }
  public function deleteitem(Request $req){
    $id = $req->id;
    $data = ModelSepeda::where('id',$id)->first();
    $path = storage_path('images/'.$data->gambar);
    File::delete($path);
    $data->delete();
    $arr = array("status" => 200, "message" => "SUCCES");
    return response()->json($arr);
  }
  public function getimage($filename){
    $path = storage_path('images/'.$filename);
    if(!File::exists($path)) abort(404);
    $file = File::get($path);
    $type = File::mimeType($path);
    $response = Response::make($file,200);
    $response->header("Content-Type",$type);
    return $response;
  }
  public function postsepeda(Request $request){
    $getkodesepeda = $request->kodesepeda;
    $getmerk = $request->merk;
    $getwarna = $request->warna;
    $gethargasewa = $request->hargasewa;

    if ($request->hasFile('image')) {
      $image = $request->file('image');
      $name = time().'.'.$image->getClientOriginalExtension();
      $destinationPath = storage_path('/images');
      $image->move($destinationPath, $name);
    }else{
      $arr = array("status" => 201, "message" => "failed");
      return response()->json($arr);
    }
    $newUser = ModelSepeda::insert([
      'kodesepeda' => $getkodesepeda,
      'merk' => $getmerk,
      'warna' => $getwarna,
      'gambar' => $name,
      'hargasewa' => $gethargasewa
    ]);

    $arr = array("status" => 200,"message" => "SUCCES", "data" => $newUser);
    return response()->json($arr);
  }
  public function deletecustomer(Request $req){
    $id = $req->id;
    $data = ModelUser::where('id',$id)->first();
    $data->delete();
    $arr = array("status" => 200, "message" => "SUCCES");
    return response()->json($arr);
  }
  public function bookingupdate(Request $req){
    $id = $req->id;
    $activated = $activated;
    $getdate = date("Y-m-d");
    DB::table('TBbooking')->where('id',$id)->update([
      'email' => $email,
    ]);
  } 
  public function bookingitem(Request $req){
    $i_user = $req->I_USER;
    $i_item = $req->I_ITEM;
    $getdate = date("Y-m-d");
    $booking = booking::insert([
      'user_id' => $i_user,
      'bicycle_id' => $i_item,
      'date_booking' => $getdate,
      'status' => "ACTIVATED" //END
    ]);
    if(!isset($booking)){
      $arr = array("status" => 201, "message" => "Failed");
      return response()->json($arr);
    }
    $arr = array("status" => 200,"message" => "SUCCES");
    return response()->json($arr,201);
  }

  public function getcustomer(){
    $data = ModelUser::get();
    if(!isset($data)){
      $arr = array("status" => 201, "message" => "FAILED","data" => $data);
      return response()->json($arr);
    }
    $arr = array("status" => 200, "message" => "SUCCES","data" => $data);
    return response()->json($arr);
  }
  public function postRegister(Request $request){
    $email = $request->email;
    $password = $request->password;
    $nama = $request->nama;
    $nohp = $request->nohp;
    $alamat = $request->alamat;
    $noktp = $request->noktp;
    if(!isset($email)){
      $arr = array(
        "status" => 422,
        "message" => "email tidak boleh kosong.."
      );
      return $arr;
    }if(!isset($password)){
      $arr = array(
        "status" => 422,
        "message" => "password tidak boleh kosong.."
      );
      return $arr;
    }if(!isset($nama)){
      $arr = array(
        "status" => 422,
        "message" => "nama tidak boleh kosong.."
      );
      return $arr;
    }if(!isset($nohp)){
      $arr = array(
      "status" => 422,"message" 
      => "nohp tidak boleh kosong.."
    );
    return $arr;
    }if(!isset($noktp)){
      $arr = array(
        "status" => 422,
        "message" => "noktp tidak boleh kosong.."
      );
      return $arr;
    }if(!isset($alamat)){
      $arr = array(
        "status" => 422,
        "message" => "alamat tidak boleh kosong.."
      );
      return $arr;
    }
    $there_is = ModelUser::where('email',$email)->first();
    if(isset($there_is))
    {$arr=array("message"=>"email sudah terpakai");
     return $arr;
    }
    $there_isUsernama = ModelUser::where('nama',$nama)->first();
    if(isset($there_is))
    {$arr=array("message"=>"nama sudah terpakai");
     return $arr;
    }
    $newUser = ModelUser::insert([
      'email' => $email,
      'password' => $password,
      'nama' => $nama,
      'nohp' => $nohp,
      'alamat' => $alamat,
      'noktp' => $noktp,
      'role_user' => '1',
    ]);
    if(!isset($newUser)){
      $arr = array("status" => 201, "message" => "Failed");
      return response()->json($arr);
    }
    $arr = array("status" => 200,"message" => "SUCCES");
    return response()->json($arr,201);
  }
  public function postLogin(Request $request){
    $email = $request->email;
    $password = $request->password;
    $akun = DB::table('TBUser')->where('email', $request->email)->first();
    if(!isset($akun)){
      $arr = array("status" => 201, "message" => "email incorect");
      return response()->json($arr);
    }
    $valPass = $akun->password;
    if($valPass == $password){
       if($akun->role_user =='1'){
          $getdata = DB::table('TBUser')->where('id', $akun->id)->first();
          $arr = array("status" => 200,"role" => "1","message" => "SUCCES", "data" => $getdata);
          return response()->json($arr);
       }elseif($akun->role_user =='2'){
        $getdata = DB::table('TBUser')->where('id', $akun->id)->first();
          $arr = array("status" => 200,"role" => "2","message" => "SUCCES", "data" => $getdata);
          return response()->json($arr);
       }
    }else{  
      $arr = array("status" => 201, "message" => "password incorect");
      return response()->json($arr);
    } 
  }
  public function getitem(){
    //final
    $data = ModelSepeda::get();
    $arr = array("status" => 200,"role"=> "2","message" => "Succes", "data" => $data);
    return response()->json($arr);
  }
  public function dummyimage(Request $request){
    if ($request->hasFile('image')) {
      $image = $request->file('image');
      $name = time().'.'.$image->getClientOriginalExtension();
      $destinationPath = storage_path('/images');
      $image->move($destinationPath, $name);
    }else{
      $arr = array("status" => 201, "message" => "failed");
      return response()->json($arr);
    }
    $dummy = Dummy::insert([
      'image' => $name,
    ]);

    $arr = array("status" => 200,"message" => "SUCCES", "data" => $dummy);
    return response()->json($arr);
  }
  
}

