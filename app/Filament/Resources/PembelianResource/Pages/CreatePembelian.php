<?php

namespace App\Filament\Resources\PembelianResource\Pages;

use App\Filament\Resources\PembelianResource;
use Filament\Resources\Pages\CreateRecord;

use App\Models\Pembelian;
use App\Models\Barang;
use App\Models\PembelianBarang;

use Illuminate\Support\Facades\DB;

class CreatePembelian extends CreateRecord
{
    protected static string $resource = PembelianResource::class;

    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        return DB::transaction(function () use ($data) {

            // ambil repeater
            $items = $this->form->getState()['items'] ?? [];

            // =====================
            // 1. Simpan pembelian
            // =====================
            $pembelian = Pembelian::create([
                'no_faktur' => $data['no_faktur'],
                'tgl' => $data['tgl'],
                'penjual_id' => $data['penjual_id'],
                'status' => $data['status'],
                'tagihan' => 0,
            ]);

            $total = 0;

            foreach ($items as $item) {

                // =====================
                // Barang baru
                // =====================
                if ($item['is_barang_baru'] == '1') {

                    $barang = Barang::create([
                    'kode_barang' => Barang::getKodeBarang(),
                    'nama_barang' => $item['nama_barang_baru'],
                    'harga_barang' => $item['harga_jual'],
                    'stok' => 0, // ✅ WAJIB
                    'rating' => $item['rating_baru'] ?? 0,
                    'foto' => $item['foto_baru'] ?? 'default.png',
                    ]);

                    $barang_id = $barang->id;

                } else {

                    $barang_id = $item['barang_id'];
                }

                // =====================
                // simpan detail
                // =====================
                PembelianBarang::create([
                'pembelian_id' => $pembelian->id,
                'barang_id' => $barang_id,
                'harga_beli' => $item['harga_beli'],
                'harga_jual' => $item['harga_jual'], // ✅ TAMBAH INI
                'jml' => $item['jml'],
                'tgl' => $item['tgl'],
                ]);

                $total += $item['harga_beli'] * $item['jml'];

            }

            // =====================
            // update total
            // =====================
            $pembelian->update([
                'tagihan' => $total
            ]);

            return $pembelian;
        });
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}