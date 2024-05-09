<?php  

function l($variable) {	$l = array();


//sales po

//	$tbl1='sales_po_items';
//	$fld1='id,induk,namabarang,ukuran,tebal,hardness,warna,size,qty,totalqty,unitprice,amount' ;

$l['ukuran'] = 'Ukuran';
$l['tebal'] = 'Tebal';
$l['hardness'] = 'Hardness';
$l['warna'] = 'Warna';
$l['size'] = 'Size';
$l['qty'] = 'QTY';
$l['totalqty'] = 'Total QTY';
$l['unitprice'] = 'Unit Price';
$l['amount'] = 'Amount';
$l['nopo'] = 'No PO';


//master kurslog
$l['kurslog'] = 'Kurs Log';
$l['tahun'] = 'Tahun';
$l['bulan'] = 'Bulan';
$l['us'] = 'USD';
$l['vn'] = 'VND';
$l['rp'] = 'IDR';
$l['remark'] = 'Remark';



//po purchasing
$l['popurchasing'] = 'PO Purchasing';
$l['unit'] = 'unit';
$l['tanggalpenyerahan'] = 'Tanggal Penyerahan';
$l['popurchasing'] = 'PO Purchasing';


$l['hapus'] = 'Hapus';
$l['packinglist'] = 'Packing List';
$l['packing_list'] = 'Packing List';

$l['poimport'] = 'PO Import';
$l['importpurchasing'] = 'Import Purchasing';
$l['purchasingimport'] = 'Purchasing Import ';


$l['ya'] = 'Ya';
$l['tanggal'] = 'Tanggal';

$l['purchasing'] = 'Purchasing';
$l['posting'] = 'Posting';
$l['pop'] = 'POP';

//reprt formula
$l['warna'] = 'warna';
$l['namacampuran'] = 'Nama Campuran';
$l['model'] = 'Model';
$l['nama'] = 'nama';
$l['kekerasan'] = 'Tingkat Kekerasan';
$l['items'] = 'Items';
$l['pembagian'] = 'Pembagian';
$l['bahanbaku'] = 'nama Bahan Baku';
$l['qty'] = 'QTY Pemakaian';
$l['satuan'] = 'Satuan Unit';
$l['tambah'] = 'Tambah';
$l['item'] = 'Item';

//master-setting
$l['semuaperiode'] = 'Semua Periode';
$l['hariini'] = 'Hari Ini';
$l['bulanini'] = 'Bulan Ini';
$l['pilihan'] = 'Pilihan';

$l['online'] = 'Online';
$l['kurs'] = 'Kurs';
$l['nilai'] = 'Nilai';
$l['alokasi'] = 'Alokasi';
$l['param'] = 'Parameter';
$l['formula'] = 'Formula';
$l['isi'] = 'Isi';


$l['bank'] = 'Bank';
$l['rekening'] = 'Rekening';
$l['npwp'] = 'NPWP';
$l['select'] = 'Select';

$l['quickstart'] = 'Quick Start';
$l['profile'] = 'Profil';
$l['master'] = 'Master';
$l['setting'] = 'Setting';
$l['id'] = 'ID';
$l['kode'] = 'Kode';
$l['nama'] = 'Nama';
$l['alamat'] = 'Alamat';
$l['telpon'] = 'Telpon';
$l['keterangan'] = 'Keterangan';
$l['beli'] = 'Beli';
$l['jual'] = 'Jual';
$l['masuk'] = 'Masuk';
$l['keluar'] = 'Keluar';
$l['Posting'] = 'Posting';
$l['Periode1'] = 'Periode 1';
$l['Periode2'] = 'Periode 2';
//master-menu
$l['menu'] = 'Menu';
$l['urut'] = 'Urut';
$l['induk'] = 'Induk';
$l['map'] = 'Map';
$l['judul'] = 'Judul';
$l['url'] = 'URL';
$l['status'] = 'Status';
//master-akses
$l['akses'] = 'Akses';
$l['pintas'] = 'Pintas';
$l['edit'] = 'Edit';
//master-user
$l['user'] = 'User';
$l['email'] = 'Emali';
$l['sandi'] = 'Sandi';
$l['lokasi'] = 'Lokasi';
$l['kontak'] = 'Kontak';
$l['printer'] = 'Printer';
//inventory-barang
$l['inventory'] = 'Inventory';
$l['barang'] = 'Produk';
$l['kategori'] = 'Kategori';
$l['satuan'] = 'Satuan';
//inventory-lokasi
//inventory-masuk
$l['tanggal'] = 'Tanggal';
$l['pembuat'] = 'Pembuat';
//inventory-keluar
//inventory-laporan
$l['stok'] = 'Persediaan';
//pos-kontak
$l['pos'] = 'POS';
$l['harga'] = 'Harga';
$l['hargajual'] = 'Harga Jual';
//pos-beli
$l['subtotal'] = 'Subtotal';
$l['ppn'] = 'PPN';
$l['total'] = 'Total';
$l['sales'] = 'Sales';
$l['supplier'] = 'Pemasok';
$l['customer'] = 'Pelanggan';
$l['marketing'] = 'Penjual';
//pos-jual
//pos-tagihan
$l['tagihan'] = 'Tagihan';
$l['tanggal1'] = 'Tanggal 1';
$l['jumlah1'] = 'Jumlah 1';
$l['tanggal2'] = 'Tanggal 2';
$l['jumlah2'] = 'Jumlah 2';
//pos-laporan
$l['kegiatan'] = 'Kegiatan';
$l['jumlah'] = 'Jumlah';
//akuntansi-akun
$l['akuntansi'] = 'Finance';
$l['akun'] = 'Akun';
$l['kelompok'] = 'Kelompok';
$l['Nomor'] = 'Nomor';
$l['Aktiva'] = 'Aktiva';
$l['Passiva'] = 'Passiva';
$l['beban'] = 'Beban';
$l['modal'] = 'Modal';
$l['pendapatan'] = 'Pendapatan';
$l['ekuitas'] = 'Ekuitas';
$l['jumlah_pendapatan'] = 'Jumlah Pendapatan';
$l['pendapatan_pendapatan'] = 'Pendapatan-Pendapatan';
$l['jumlah_beban'] = 'Jumlah Beban';
$l['beban_beban'] = 'Beban-Beban';
$l['laba_bersih'] = 'Laba Bersih';
$l['laporan_neraca'] = 'Laporan Neraca';
$l['laporan_ekuitas'] = 'Laporan Ekuitas';

//akuntansi-persamaan
$l['akuntansi_persamaan'] = 'Akuntansi Persamaan';
$l['persamaan'] = 'Persamaan';
$l['debit'] = 'Debit';
$l['Kredit'] = 'Kredit';
//akuntansi-jurnal
$l['jurnal'] = 'Jurnal';
$l['ref'] = 'Ref';
$l['neraca'] = 'Neraca';
$l['laba_rugi'] = 'Laba Rugi';
$l['laporan_rugi_laba'] = 'Laporan Laba Rugi';
$l['jumlah_aktiva'] = 'Jumlah Aktiva';
$l['jumlah_passiva'] = 'Jumlah Passiva';

//akuntansi-posting 
//akuntansi-jurnal
$l['bukubesar'] = 'Buku Besar';
$l['salin'] = 'Salin';

//akuntansi-jurnal
$l['laporan'] = 'Laporan';

//undefine
$l['banyak'] = 'Banyak';
$l['diskon'] = 'Diskon';

//menu
$l['add'] = 'Tambah';
$l['delete'] = 'Hapus';
$l['filter'] = 'Saring';
$l['export'] = 'Ekspor';
$l['import'] = 'Impor';
$l['save'] = 'Simpan';
$l['update'] = 'Update';
$l['jejak'] = 'Jejak';
$l['persediaan'] = 'Persediaan';
$l['cetak'] = 'Cetak';
$l['struk'] = 'Struk';
$l['penjualan'] = 'Penjualan';
$l['pembelian'] = 'Pembelian';
$l['close'] = 'Tutup';
$l['selesai'] = 'Selesai';
$l['insert'] = 'Insert';
$l['pilihbanyak'] = 'Pilih Terseleksi';

//label
$l['jumlah_data'] = 'Jumlah Data';
$l['halaman'] = 'Halaman';
$l['cari'] = 'Cari';
$l['username'] = 'Username';
$l['password'] = 'Password';
$l['help'] = 'Help';
$l['welcome'] = 'Selamat datang';
$l['tampil'] = 'Tampil';
$l['sembunyi'] = 'Sembunyi';
$l['lunas'] = 'Lunas';
$l['belumlunas'] = 'Belum Lunas';
$l['hutang'] = 'Hutang';
$l['piutang'] = 'Piutang';

$l['tidak_ditemukan'] = 'Tidak ditemukan produk dengan kode';
$l['ditambahkan'] = 'Ditambahkan produk dengan kode';
$l['sudah_ada'] = 'Sudah ada produk dengan kode';
$l['periode'] = 'Periode';
$l['kodebarang'] = 'Kode Produk';
$l['namabarang'] = 'Nama Produk';
 
//button
$l['login'] = 'Log In';
$l['logout'] = 'Log Out';
$l['lanjut'] = 'Lanjut';
$l['scan'] = 'Scan';
$l['lihat'] = 'Lihat';

//title
$l['masukitems'] = 'Masuk Items';
$l['keluaritems'] = 'Keluar Items';
$l['kontakitems'] = 'Kontak Items';
$l['barangitems'] = 'Produk Items';
$l['beliitems'] = 'Beli Items';
$l['jualitems'] = 'Jual Items';
$l['ya'] = 'Ya';
$l['tidak'] = 'Tidak';
$l['ppnstatus'] = 'PPN Status';
$l['jualppn'] = 'Penjualan PPN';
$l['proses'] = 'Proses';
$l['bahasa'] = 'Bahasa';
$l['gambar'] = 'Gambar';

$l['excel'] = 'Excel';
$l['kadaluarsa'] = 'Kadaluarsa';
$l['batas'] = 'Batas';
$l['backup'] = 'Backup';
$l['restore'] = 'Restore';

$l['title'] = 'Stokbarang';
$l['v_free'] = 'Gratis Sistem Informasi Dagang';

$l['otagihan'] = 'Tagihan Otomatis';
$l['opersediaan'] = 'Persediaan Otomatis';

$l['home'] = 'Beranda';
$l['baris'] = 'Baris';
$l['album'] = 'Album';
$l['install'] = 'Instalasi';
$l['license'] = 'Lisensi';
$l['custom'] = 'Custom';
$l['laba'] = 'Laba';
$l['hargabeli'] = 'Harga Beli';
$l['lisensi'] = 'Lisensi';
$l['kasir'] = 'Kasir';
$l['pole'] = 'Pole';

$l['bayar'] = 'Bayar';
$l['mulai'] = 'Mulai';



//export - import
$l['pajak'] = 'Faktur Pajak';
$l['laporanpajak'] = 'Laporan Faktur Pajak';


//export - import
$l['exim'] = 'Ekspor Impor';
$l['bc27m'] = 'BC.2.7 Masuk';
$l['bc27k'] = 'BC.2.7 Keluar';
$l['bc40'] = 'BC.4.0 Lokal/Hasil Reparasi';
$l['bc41'] = 'BC.4.1 Pengembalian/Reparasi';
$l['bc261'] = 'BC.2.6.1 SubCon';
$l['bc262'] = 'BC.2.6.2 Hasil SubCon';
$l['bc23'] = 'BC.2.3 Impor';
$l['bc25'] = 'BC.2.5 PIB';
$l['bc30'] = 'BC.3.0 PEB';


$l['ppic'] = 'Inventory';
$l['admin'] = 'Administration';
$l['quotation'] = 'Quotation';
$l['po'] = 'PO';
$l['claim'] = 'Material Claim';
$l['sample'] = 'Sample Order';
$l['salesreport'] = 'Sales Report';

//ppic
$l['delivery'] = 'Delivery';

//akuntansi
$l['invoice'] = 'Invoice';
$l['rekapinvoice'] = 'AR Invoice';

//bc27k
$l['f0'] = 'Status';
$l['f1'] = 'Kode';
$l['f2'] = 'Nomor Pengajuan';
$l['f3'] = 'Kantor Asal';
$l['f4'] = 'Kantor Tujuan';
$l['f5'] = 'Jenis TPB Asal';
$l['f6'] = 'Jenis TPB Tujuan';
$l['f7'] = 'Tujuan Pengiriman';
$l['f8'] = 'Nomor Pendafataran';
$l['f9'] = 'Tangal';
$l['f10'] = 'Asal-NPWP';

$l['f11'] = 'Asal-Nama';
$l['f12'] = 'Asal-Alamat';
$l['f13'] = 'Asal-Izin';
$l['f14'] = 'Tujuan-NPWP';
$l['f15'] = 'Tujuan-Nama';
$l['f16'] = 'Tujuan-Alamat';
$l['f17'] = 'Tujuan-Izin';
$l['f18'] = 'Invoice';
$l['f19'] = 'Packing List';
$l['f20'] = 'Kontrak';

$l['f21'] = 'Surat Jalan';
$l['f22'] = 'Surat Keputusan';
$l['f23'] = 'Lainnya';
$l['f24'] = 'Riwayat Barang - Asal';
$l['f25'] = 'Tanggal';
$l['f26'] = 'Jenis Valuta Asing';
$l['f27'] = 'CIF';
$l['f28'] = 'Harga Penyerahan';
$l['f29'] = 'Jenis Angkutan';
$l['f30'] = 'NoPol';

$l['f31'] = 'Segel-No';
$l['f32'] = 'Segel-Jenis';
$l['f33'] = 'Segel-Catatan';
$l['f34'] = 'Kemas-Merek';
$l['f35'] = 'Kemas-Jumlah & Jenis';
$l['f36'] = 'Volume';
$l['f37'] = 'Berat Kotor';
$l['f38'] = 'Berat Bersih';
$l['f39'] = 'Pengusaha TPB';
$l['f40'] = 'BC Asal';
$l['f41'] = 'BC Tujuan';


//bc262
$l['bc262f0'] = 'Status';
$l['bc262f1'] = 'Kode';
$l['bc262f2'] = 'Nomor Pengajuan';
$l['bc262f3'] = 'Jenis TPB';
$l['bc262f4'] = 'Jenis Pengeriman';
$l['bc262f5'] = 'EX BC 2.6.1';
$l['bc262f6'] = 'Nomor Pendaftaran';
$l['bc262f7'] = 'Tanggal';


$l['bc262f8'] = 'NPWP';
$l['bc262f9'] = 'Nama';
$l['bc262f10'] = 'Alamat';
$l['bc262f11'] = 'No Izin TPB';

$l['bc262f12'] = 'NPWP';
$l['bc262f13'] = 'Nama';
$l['bc262f14'] = 'Alamat';

$l['bc262f15'] = 'Packing List';
$l['bc262f16'] = 'Surat Jalan';
$l['bc262f17'] = 'Kontrak';
$l['bc262f18'] = 'Surat Keputusan';
$l['bc262f19'] = 'Jenis Sarana Pengangkutan darat';
$l['bc262f20'] = 'Nomor Polisi';

$l['bc262f21'] = 'Jenis Valuta Asing';
$l['bc262f22'] = 'Nilai CIF';

$l['bc262f23'] = 'Jenis Kemasan';
$l['bc262f24'] = 'Merek Kemasan';
$l['bc262f25'] = 'Jumlah Kemasan';

$l['bc262f26'] = 'Volume(M3)';
$l['bc262f27'] = 'Berat Kotor (Kg)';
$l['bc262f28'] = 'Berat Bersih (Kg)';


$l['bc262f29'] = '22. No';
$l['bc262f30'] = '23. Deskripsi';
$l['bc262f31'] = '24. Jumlah';

$l['bc262f32'] = '25. Nilai CIF';

$l['bc262f33'] = '26. BM';
$l['bc262f34'] = '27. Cukai';
$l['bc262f35'] = '28. PPN';
$l['bc262f36'] = '29. PPnBM';
$l['bc262f37'] = '30. PPh';
$l['bc262f38'] = '31. Total';

$l['bc262f39'] = '32. Jenis Jaminan';
$l['bc262f40'] = '33. Nomor Jaminan';
$l['bc262f41'] = '34. Nilai Jaminan';
$l['bc262f42'] = '35. Jatuh Tempo Jaminan';
$l['bc262f43'] = '36. Penjamin';
$l['bc262f44'] = '37. Bukti Penerimaan Jaminan';


//bc261
$l['bc261f0'] = 'Status';
$l['bc261f1'] = 'Kode';
$l['bc261f2'] = 'Nomor Pengajuan';
$l['bc261f3'] = 'Jenis TPB';
$l['bc261f4'] = 'Jenis Pengeriman';
$l['bc261f5'] = 'EX BC 2.6.1';
$l['bc261f6'] = 'Nomor Pendaftaran';
$l['bc261f7'] = 'Tanggal';


$l['bc261f8'] = 'NPWP';
$l['bc261f9'] = 'Nama';
$l['bc261f10'] = 'Alamat';
$l['bc261f11'] = 'No Izin TPB';

$l['bc261f12'] = 'NPWP';
$l['bc261f13'] = 'Nama';
$l['bc261f14'] = 'Alamat';

$l['bc261f15'] = 'Packing List';
$l['bc261f16'] = 'Surat Jalan';
$l['bc261f17'] = 'Kontrak';
$l['bc261f18'] = 'Surat Keputusan';
$l['bc261f19'] = 'Jenis Sarana Pengangkutan darat';
$l['bc261f20'] = 'Nomor Polisi';

$l['bc261f21'] = 'Jenis Valuta Asing';
$l['bc261f22'] = 'Nilai CIF';

$l['bc261f23'] = 'Jenis Kemasan';
$l['bc261f24'] = 'Merek Kemasan';
$l['bc261f25'] = 'Jumlah Kemasan';

$l['bc261f26'] = 'Volume(M3)';
$l['bc261f27'] = 'Berat Kotor (Kg)';
$l['bc261f28'] = 'Berat Bersih (Kg)';


$l['bc261f29'] = '22. No';
$l['bc261f30'] = '23. Deskripsi';
$l['bc261f31'] = '24. Jumlah';

$l['bc261f32'] = '25. Nilai CIF';

$l['bc261f33'] = '26. BM';
$l['bc261f34'] = '27. Cukai';
$l['bc261f35'] = '28. PPN';
$l['bc261f36'] = '29. PPnBM';
$l['bc261f37'] = '30. PPh';
$l['bc261f38'] = '31. Total';

$l['bc261f39'] = '32. Jenis Jaminan';
$l['bc261f40'] = '33. Nomor Jaminan';
$l['bc261f41'] = '34. Nilai Jaminan';
$l['bc261f42'] = '35. Jatuh Tempo Jaminan';
$l['bc261f43'] = '36. Penjamin';
$l['bc261f44'] = '37. Bukti Penerimaan Jaminan';


//faktur-pajak
$l['pajakf0'] = 'Status';
$l['pajakf1'] = 'Kode';
$l['pajakf2'] = 'Nama';
$l['pajakf3'] = 'Alamat';
$l['pajakf4'] = 'NPWP';
$l['pajakf5'] = 'Tanggal Pengukuhan PKP';
$l['pajakf6'] = 'Nama';
$l['pajakf7'] = 'Alamat';
$l['pajakf8'] = 'NPWP';
$l['pajakf9'] = 'NPPKP';

$l['pajakf10'] = 'No';
$l['pajakf11'] = 'Nama Barang';
$l['pajakf12'] = 'Harga';

$l['pajakf13'] = 'Harga Jual';
$l['pajakf14'] = 'Potongan Harga';

$l['pajakf15'] = 'Uang Muka';
$l['pajakf16'] = 'DPP';
$l['pajakf17'] = 'PPN';
$l['pajakf18'] = 'Tempat';
$l['pajakf19'] = 'Tanggal';
$l['pajakf20'] = 'Nama';

$l['pajakf21'] = 'Jabatan';





$l['sales_contract'] = 'Sales Contract';
$l['surat_jalan'] = 'Surat Jalan';
$l['report_delivery'] = 'Report Delivery';


//SALES CONTACT
$l['scf1'] = 'Kode';
$l['scf2'] = 'Party A';
$l['scf3'] = 'Party B';
$l['scf4'] = 'Article I : Commodity';
$l['scf5'] = 'Article II: Payment';
$l['scf6'] = 'Article III: Validity';
$l['scf7'] = 'ArtileIV : Shipment';
$l['scf8'] = 'Article V : Remark';
$l['scf9'] = 'Seller';
$l['scf10'] = 'Buyer';

//Packing List
$l['plf1'] = 'Consignee';
$l['plf2'] = 'Invoice No';
$l['plf3'] = 'Date';
$l['plf4'] = 'Due Date';
$l['plf5'] = 'PO No';
$l['plf6'] = 'Notify Party';
$l['plf7'] = 'Destination';
$l['plf8'] = 'Payment Term';

//Invoice
$l['invf0'] = 'Status';
$l['invf1'] = 'Kode';
$l['invf2'] = 'Consigner';
$l['invf3'] = 'Date';
$l['invf4'] = 'Due Date';
$l['invf5'] = 'PO No';
$l['invf6'] = 'Destination';
$l['invf7'] = 'Payment Term';
$l['invf8'] = 'Total';
$l['invf9'] = 'PPN';
$l['invf10'] = 'Grand Total';
$l['invf11'] = 'Bank';
$l['invf12'] = 'ttd';

//Surtat jalan 
$l['surat_jalan'] = 'Surat Jalan';
$l['suratjalan'] = 'Surat Jalan';
$l['sjf0'] = 'Status';
$l['sjf1'] = 'Cutomer';
$l['sjf2'] = 'Style';
$l['sjf3'] = 'Date';
$l['sjf4'] = 'Total';
$l['sjf5'] = 'Keterangan';
$l['sjf6'] = 'No.Invoice';
$l['sjf7'] = 'Penerima';
$l['sjf8'] = 'Security';
$l['sjf9'] = 'Supir';
$l['sjf10'] = 'Pengisi';
$l['sjf11'] = 'Kabag';
$l['sjf12'] = 'Kabag';


$l['po'] = 'PO';

 //report
$l['report'] = 'Report';
$l['jadwalproduksi'] = 'Jadwal Produksi';
$l['spkproduksi'] = 'SPK Produksi';
$l['laporanproduksi'] = 'Laporan Produksi';
$l['POP'] = 'PO Purchasing';

//report jadwal produksi
$l['jpf1'] = 'Customer';
$l['jpf2'] = 'Nomor PO';
$l['jpf3'] = 'Plan No';
$l['jpf4'] = 'Nama Produk';
$l['jpf5'] = 'Deskripsi';
$l['jpf6'] = 'Warna';
$l['jpf7'] = 'Kekerasan';
$l['jpf8'] = 'Jumlah';
$l['jpf9'] = 'Satuan';
$l['jpf10'] = 'Jumlah Pengiriman';
$l['jpf11'] = 'Balance';

//report laporan produksi
$l['lpf1'] = 'Lokasi';
$l['lpf2'] = 'Shift A';
$l['lpf3'] = 'Shift B';
$l['lpf4'] = 'Shift C';
$l['lpf5'] = 'Satuan';
$l['lpf6'] = 'Total';
$l['lpf7'] = 'Stock';
$l['lpf8'] = 'Pengiriman';

//report laporan produksi
$l['spkpf0'] = 'Status';
$l['spkpf1'] = 'Kode';
$l['spkpf2'] = 'Purchase No';
$l['spkpf3'] = 'Code';
$l['spkpf4'] = 'Model Name';
$l['spkpf5'] = 'Material Description';
$l['spkpf6'] = 'Color';
$l['spkpf7'] = 'Reg Date';
$l['spkpf8'] = 'Pur QTY';
$l['spkpf9'] = 'Unit';
$l['spkpf10'] = '4';
$l['spkpf11'] = '4T';
$l['spkpf12'] = '5';
$l['spkpf13'] = '5T';
$l['spkpf14'] = '6';
$l['spkpf15'] = '6T';
$l['spkpf16'] = '7';
$l['spkpf17'] = '7T';
$l['spkpf18'] = '8';
$l['spkpf19'] = '8T';
$l['spkpf20'] = '9';
$l['spkpf21'] = '9T';
$l['spkpf22'] = '10';
$l['spkpf23'] = '10T';
$l['spkpf24'] = '11';
$l['spkpf25'] = '11T';
$l['spkpf26'] = '12';
$l['spkpf27'] = '12T';
$l['spkpf28'] = '13';
$l['spkpf29'] = '14';



//report formula
$l['rff1'] = 'Model';
$l['rff2'] = 'Warna';
$l['rff3'] = 'nama Formula';
$l['rff4'] = 'Tingkat Kekerasan';
$l['rff5'] = 'EVA';
$l['rff6'] = 'PE';
$l['rff7'] = 'Diproduksi Lagi';
$l['rff8'] = 'Bahan Obat U Variasi';
$l['rff9'] = 'Bahan Obat';
$l['rff10'] = 'Butiran Warna';
$l['rff11'] = 'Total';

//report pembelian
$l['fpf1'] = 'Penjual';
$l['fpf2'] = 'Departemen';
$l['fpf3'] = 'Deskripsi';
$l['fpf4'] = 'Pengisi Form';
$l['fpf5'] = 'Ka. Bagian';
$l['fpf6'] = 'Acc';

//admin purchasing
$l['apf1'] = 'No PO';
$l['apf2'] = 'Supplier';
$l['apf3'] = 'Deskripsi';
$l['apf4'] = 'QTY';
$l['apf5'] = 'Satuan';
$l['apf6'] = 'Price';
$l['apf7'] = 'Total Amount';
$l['apf8'] = 'Shipment';
$l['apf9'] = 'Remark';



//sales PO
$l['pof1'] = 'Customer';
$l['pof2'] = 'No PO';
$l['pof3'] = 'Nama Produk';
$l['pof4'] = 'Ukuran';
$l['pof5'] = 'Tebal (mm)';
$l['pof6'] = 'Hardness';
$l['pof7'] = 'Warna';
$l['pof8'] = 'Size';
$l['pof9'] = 'Quantity';
$l['pof10'] = 'Total Quantity';
$l['pof11'] = 'Unit Price (USD)';
$l['pof12'] = 'Amount (USD)';


//sales quotation
$l['sqf1'] = 'Customer';
$l['sqf2'] = 'Style Name';
$l['sqf3'] = 'Color';
$l['sqf4'] = 'Ukuran';
$l['sqf5'] = 'Unit';
$l['sqf6'] = 'Unit Price';
$l['sqf7'] = 'Remark';
$l['sqf8'] = 'Payment Term';
$l['sqf9'] = 'Other';
$l['sqf10'] = 'Confirmed By Customer';
$l['sqf11'] = 'Supplier Approval';
$l['sqf12'] = 'Offer Validity';


//Sales matrial claim 
$l['mcf1'] = 'Claim Number';
$l['mcf2'] = 'No PO';
$l['mcf3'] = 'Customer';
$l['mcf4'] = 'No Planing';
$l['mcf5'] = 'Item Name';
$l['mcf6'] = 'Color';
$l['mcf7'] = 'QTY';
$l['mcf8'] = 'Unit';
$l['mcf9'] = 'QC';
$l['mcf10'] = 'Retur';
$l['mcf11'] = 'Pengganti';
$l['mcf12'] = 'Remark';
$l['mcf13'] = 'problem';

//sales sample order
$l['sof1'] = 'Custmer';
$l['sof2'] = 'No PO';
$l['sof3'] = 'Description';
$l['sof4'] = 'Size';
$l['sof5'] = 'Width (mm)';
$l['sof6'] = 'Hardness';
$l['sof7'] = 'Color';
$l['sof8'] = 'QTY';
$l['sof9'] = 'Price USD';
$l['sof10'] = 'Remark';

return $l[$variable];
}

?>