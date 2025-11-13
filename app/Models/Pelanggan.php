<?php
namespace App\Models;

use App\Models\Pelanggan;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table      = 'pelanggan';
    protected $primaryKey = 'pelanggan_id';
    protected $fillable   = [
        'first_name',
        'last_name',
        'birthday',
        'gender',
        'email',
        'phone',
    ];

    public function store(Request $request)
    {

        //dd($request->all())

        $data['first_name'] = $request->first_name;
        $data['last_name']  = $request->last_name;
        $data['birthday']   = $request->birthday;
        $data['gender']     = $request->gender;
        $data['email']      = $request->email;
        $data['phone']      = $request->phone;

        Pelanggan::create($data);

        return redirect()->route('pelanggan.index')->with('success', 'Penambahan Data Berhasil!');
    }
}
