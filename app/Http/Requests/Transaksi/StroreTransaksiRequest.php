<?php

namespace App\Http\Requests\Transaksi;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransaksiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'no_resi'                  => 'string|required',
            'no_pesanan'               => 'string|required',
            'tgl_pesanan_dibuat'       => 'date|required',
            'status_pesanan'           => 'string|required',
            'status_pembatalan'        => 'string|nullable',
            'deadline_pengiriman'      => 'string|required', 
            'produk'                   => 'string|required',   
            'jasa_kirim'               => 'string|required',
            'username_pembeli'         => 'string|required',
            'nama_pembeli'             => 'string|required',
            'telfon_pembeli'           => 'string|required',
            'alamat_pembeli'           => 'string|required',
            'kota_pembeli'             => 'string|required',
            'provinsi_pembeli'         => 'string|required',
            'kode_pos_pembeli'         => 'string|required'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return 
        [
            'no_resi.required'              => 'Nomor Resi tidak diizinkan untuk kosong',
            'no_pesanan.required'           => 'Nomor Pesanan tidak diizinkan untuk kosong',
            'tgl_pesanan_dibuat.required'   => 'Tanggal Pesanan tidak diizinkan untuk kosong',
            'status_pesanan.required'       => 'Status dari pesanan tidak diizinkan untuk kosong',   
            'deadline_pengiriman.required'  => 'Deadline Pengiriman dari pesanan tidak diizinkan untuk kosong',   
            'produk.required'               => 'Produk dari pesanan tidak diizinkan untuk kosong',   
            'jasa_kirim.required'           => 'Jasa kirim dari pesanan tidak diizinkan untuk kosong',   
            'username_pembeli.required'     => 'Username dari pesanan tidak diizinkan untuk kosong',   
            'nama_pembeli.required'         => 'Nama Pembeli dari pesanan tidak diizinkan untuk kosong',   
            'telfon_pembeli.required'       => 'Telfon Pembeli dari pesanan tidak diizinkan untuk kosong',   
            'alamat_pembeli.required'       => 'Alamat Pembeli dari pesanan tidak diizinkan untuk kosong',   
            'kota_pembeli.required'         => 'Kota Pembeli dari pesanan tidak diizinkan untuk kosong',   
            'provinsi_pembeli.required'     => 'Provinsi Pembeli dari pesanan tidak diizinkan untuk kosong',   
            'kode_pos_pembeli.required'     => 'Kode Pos Pembeli dari pesanan tidak diizinkan untuk kosong',  
            'tgl_pesanan_dibuat.date'       => 'Tanggal pesanan Tidak sesuai format tanggal'
        ];
    }
}
