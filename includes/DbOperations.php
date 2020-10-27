<?php

    class DbOperations{

        private $con;

        function __construct() {
            require_once dirname(__FILE__) . '/DbConnect.php';

            $db = new DbConnect;

            $this->con = $db->connect();
        }

        public function getAllProvinsi() {
            $stmt = $this->con->prepare("SELECT kd_provinsi, provinsi, foto_provinsi FROM provinsi");
            $stmt->execute();
            $stmt->bind_result($kdprovinsi, $namaprovinsi, $fotoprovinsi);
            $provinsis = array();
            while($stmt->fetch()) {
                $provinsi = array();
                $provinsi['kd_provinsi'] = $kdprovinsi;
                $provinsi['provinsi'] = $namaprovinsi;
                $provinsi['foto_provinsi'] = $fotoprovinsi;
                array_push($provinsis, $provinsi);
            }
            return $provinsis;
        }

        public function getAllKategori($kdprov) {
            $stmt = $this->con->prepare("SELECT kd_kategorikb, kategori_budaya, foto_katkb FROM kategoribudaya");
            $stmt->execute();
            $stmt->bind_result($kdkategori, $namakategori, $fotokategori);
            $kategoris = array();
            while($stmt->fetch()){
                $kategori = array();
                $kategori['kd_kategorikb'] = $kdkategori;
                $kategori['kategori_budaya'] = $namakategori;
                $kategori['foto_katkb'] = $fotokategori;
                array_push($kategoris, $kategori);
            }
            return $kategoris;
        }

        public function getKaryaBudaya($id1, $id2) {
            $stmt = $this->con->prepare("SELECT kd_karyabudaya, karya_budaya, foto_budaya, deskripsi_singkat, sejarah_singkat, kd_dokumentasi
                                         FROM karyabudaya 
                                         WHERE kd_karyabudaya IN 
                                         (Select distinct karyabudaya.kd_karyabudaya 
                                          from detil_karyabudaya, detilunsur, kecamatan, kabupatenkota, provinsi, unsurkaryabudaya, kategoribudaya,karyabudaya 
                                          where detil_karyabudaya.kd_karyabudaya = karyabudaya.kd_karyabudaya 
                                          and detil_karyabudaya.kd_kecamatan = kecamatan.kd_kecamatan 
                                          and kecamatan.kd_kabupatenkota = kabupatenkota.kd_kabupatenkota 
                                          and kabupatenkota.kd_provinsi = provinsi.kd_provinsi 
                                          and detilunsur.kd_karyabudaya = karyabudaya.kd_karyabudaya 
                                          and detilunsur.kd_unsurbudaya = unsurkaryabudaya.kd_unsurbudaya 
                                          and unsurkaryabudaya.kd_kategorikb = kategoribudaya.kd_kategorikb 
                                          and provinsi.kd_provinsi = ? and kategoribudaya.kd_kategorikb = ?)");
            $stmt->bind_param("is", $id1, $id2);
            $stmt->execute();
            $stmt->bind_result($kdbudaya, $namabudaya, $fotobudaya, $deskripsi, $sejarah, $kddokumentasi);
            $kbudayas = array();
            while($stmt->fetch()) {
                $kbudaya = array();
                $kbudaya['kd_karyabudaya'] = $kdbudaya;
                $kbudaya['karya_budaya'] = $namabudaya;
                $kbudaya['foto_budaya'] = $fotobudaya;
                $kbudaya['deskripsi_singkat'] = $deskripsi;
                $kbudaya['sejarah_singkat'] = $sejarah;
                $kbudaya['kd_dokumentasi'] = $kddokumentasi;
                array_push($kbudayas, $kbudaya);
            }
            return $kbudayas;
        }

        public function getDetailKaryaBudaya($kdkaryabudaya) {
            $stmt = $this->con->prepare("SELECT kd_karyabudaya, karya_budaya, foto_budaya, deskripsi_singkat, sejarah_singkat, kd_dokumentasi FROM karyabudaya WHERE kd_karyabudaya = ?");
            $stmt->bind_param("s", $kdkaryabudaya);
            $stmt->execute();
            $stmt->bind_result($kdkarya, $karyabudaya, $fotobudaya, $deskripsi, $sejarah, $kddokumentasi);
            $kbudayas = array();
            while($stmt->fetch()) {
                $kbudaya = array();
                $kbudaya['kd_karyabudaya'] = $kdkarya;
                $kbudaya['karya_budaya'] = $karyabudaya;
                $kbudaya['foto_budaya'] = $fotobudaya;
                $kbudaya['deskripsi_singkat'] = $deskripsi;
                $kbudaya['sejarah_singkat'] = $sejarah;
                $kbudaya['kd_dokumentasi'] = $kddokumentasi;

                array_push($kbudayas, $kbudaya);
            }
            return $kbudayas;
        }

        public function getDetailUnsurKaryaBudaya($kdkaryabudaya) {
            $stmt = $this->con->prepare("SELECT u.unsurkaryabudaya as unsurkaryabudaya
                                        FROM unsurkaryabudaya u JOIN detilunsur du ON (u.kd_unsurbudaya = du.kd_unsurbudaya)
                                        WHERE du.kd_karyabudaya = ?");
            $stmt->bind_param("s", $kdkaryabudaya);
            $stmt->execute();
            $stmt->bind_result($unsurkaryabudaya);
            $dtunsurs = array();
            while($stmt->fetch()){
                $dtunsur = array();
                $dtunsur['unsurkaryabudaya'] = $unsurkaryabudaya;
                array_push($dtunsurs, $dtunsur);
            }                            
            return $dtunsurs;
        }

        public function getMaestro($kdkaryabudaya) {
            $stmt = $this->con->prepare("SELECT DISTINCT m.kd_maestro as kd_maestro, 
            m.maestro as maestro, 
            m.alamat as alamat, 
            m.usia as usia, 
            m.telepon as telepon, 
            m.email as email, 
            m.riwayat_hidup as riwayat_hidup, 
            m.foto_maestro as foto_maestro
                                        FROM maestro m JOIN detil_maestro dm ON (m.kd_maestro = dm.kd_maestro)
                                        WHERE dm.kd_karyabudaya = ?");
            $stmt->bind_param("s", $kdkaryabudaya);
            $stmt->execute();
            $stmt->bind_result($kdmaestro, $namamaestro, $alamat, $usia, $telepon, $email, $riwayat, $foto);
            $maestros = array();
            while($stmt->fetch()){
                $maestro = array();
                $maestro['kd_maestro'] = $kdmaestro;
                $maestro['maestro'] = $namamaestro;
                $maestro['alamat'] = $alamat;
                $maestro['usia'] = $usia;
                $maestro['telepon'] = $telepon;
                $maestro['email'] = $email;
                $maestro['riwayat_hidup'] = $riwayat;
                $maestro['foto_maestro'] = $foto;
                array_push($maestros, $maestro);
            }                            
            return $maestros;
        }

        public function getPenanggungJawab($kdkaryabudaya) {
            $stmt = $this->con->prepare("SELECT DISTINCT p.kd_pngjwb as kd_pngjwb, p.pngjwb as pngjwb, p.alamat as alamat, p.telepon as telepon, p.email as email, p.foto_pngjwb as foto_pngjwb
                                        FROM penanggungjawabbudaya p JOIN detil_penanggungjawab dp ON (p.kd_pngjwb = dp.kd_pngjwb)
                                        WHERE dp.kd_karyabudaya = ?");
            $stmt->bind_param("s", $kdkaryabudaya);
            $stmt->execute();
            $stmt->bind_result($kdpngjwb, $pngjwb, $alamat, $telepon, $email, $foto);
            $penanggungjawabs = array();
            while($stmt->fetch()) {
                $penanggungjawab = array();
                $penanggungjawab['kd_pngjwb'] = $kdpngjwb;
                $penanggungjawab['pngjwb'] = $pngjwb;
                $penanggungjawab['alamat'] = $alamat;
                $penanggungjawab['telepon'] = $telepon;
                $penanggungjawab['email'] = $email;
                $penanggungjawab['foto_pngjwb'] = $foto;
                array_push($penanggungjawabs, $penanggungjawab);
            }                           
            return $penanggungjawabs;
        }

        public function getPelestarian($kdkaryabudaya) {
            $stmt = $this->con->prepare("SELECT upaya_pelestarian
            FROM pelestarian JOIN detil_pelestarian ON (pelestarian.kd_pelestarian = detil_pelestarian.kd_pelestarian)
            WHERE detil_pelestarian.kd_karyabudaya = ?");
            $stmt->bind_param("s", $kdkaryabudaya);
            $stmt->execute();
            $stmt->bind_result($upaya);
            $pelestarians = array();
            while($stmt->fetch()){
                $pelestarian = array();
                $pelestarian['upaya_pelestarian'] = $upaya;
                array_push($pelestarians, $pelestarian);
            }
            return $pelestarians;
        }

        public function getDetailPenanggungJawab($kdpenanggungjawab) {
            $stmt = $this->con->prepare("SELECT DISTINCT p.pngjwb as namapngjwb, k.kecamatan as kecamatan, dp.lat as lat, dp.lng as lng
                                        FROM detil_penanggungjawab dp JOIN kecamatan k ON (k.kd_kecamatan = dp.kd_kecamatan)
                                        JOIN penanggungjawabbudaya p ON (p.kd_pngjwb = dp.kd_pngjwb) WHERE dp.kd_pngjwb = ?");
            $stmt->bind_param("s", $kdpenanggungjawab);
            $stmt->execute();
            $stmt->bind_result($namapngjwb, $kecamatan, $lat, $lng);
            $pngjwbs = array();
            while($stmt->fetch()){
                $pngjwb = array();
                $pngjwb['namapngjwb'] = $namapngjwb;
                $pngjwb['kecamatan'] = $kecamatan;
                $pngjwb['lat'] = $lat;
                $pngjwb['lng'] = $lng;
                array_push($pngjwbs, $pngjwb);
            }
            return $pngjwbs;
        }

        public function getKabupatenKota($kdprovinsi) {
            $stmt = $this->con->prepare("SELECT kd_kabupatenkota, kabupaten_kota, rentang_kodepos
                                         FROM kabupatenkota WHERE kd_provinsi = ?");
            $stmt->bind_param("i", $kdprovinsi);
            $stmt->execute();
            $stmt->bind_result($kdkabupatenkota, $namakabupatenkota, $rentangkodepos);
            $kabupatenkotas = array();
            while($stmt->fetch()) {
                $kabupatenkota = array();
                $kabupatenkota['kd_kabupatenkota'] = $kdkabupatenkota;
                $kabupatenkota['kabupaten_kota'] = $namakabupatenkota;
                $kabupatenkota['rentang_kodepos'] = $rentangkodepos;
                array_push($kabupatenkotas, $kabupatenkota);
            }                             
            return $kabupatenkotas;
        }

        public function getKecamatan($kdkabupatenkota) {
            $stmt = $this->con->prepare("SELECT kecamatan, kodepos, lat, lng
                                         FROM kecamatan WHERE kd_kabupatenkota = ?");
            $stmt->bind_param("i", $kdkabupatenkota);
            $stmt->execute();
            $stmt->bind_result($namakecamatan, $kodepos, $lat, $lng);
            $kecamatans = array();
            while($stmt->fetch()) {
                $kecamatan = array();
                $kecamatan['kecamatan'] = $namakecamatan;
                $kecamatan['kodepos'] = $kodepos;
                $kecamatan['lat'] = $lat;
                $kecamatan['lng'] = $lng;
                array_push($kecamatans, $kecamatan);
            }
            return $kecamatans;
        }

        public function Haversine($lat, $lng) {
            $stmt = $this->con->prepare("SELECT p.kd_pngjwb, p.alamat, p.telepon, p.usia, p.email, p.riwayat_hidup, p.kd_kecamatan, p.foto_pngjwb, p.pngjwb, dp.kd_karyabudaya, dp.kd_pngjwb, lat, lng, kb.kategori_budaya, kb.kd_kategorikb, (6371 * ACOS(SIN(RADIANS(lat)) * SIN(RADIANS(?)) + COS(RADIANS(lng - ?)) * COS(RADIANS(lat)) * COS(RADIANS(?)))) AS jarak
            FROM detil_penanggungjawab dp JOIN penanggungjawabbudaya p ON (p.kd_pngjwb = dp.kd_pngjwb)
            JOIN karyabudaya k ON (k.kd_karyabudaya = dp.kd_karyabudaya)
            JOIN detilunsur du ON (du.kd_karyabudaya = k.kd_karyabudaya)
            JOIN unsurkaryabudaya u ON (u.kd_unsurbudaya = du.kd_unsurbudaya)
            JOIN kategoribudaya kb ON (kb.kd_kategorikb = u.kd_kategorikb)
            HAVING jarak < 10 ORDER BY jarak ASC");
            $stmt->bind_param("ddd", $lat, $lng, $lat);
            $stmt->execute();
            $stmt->bind_result($kdpngjwb, $alamat, $telepon, $usia, $email, $riwayathidup, $kecamatan, $fotopngjwb, $namapngjwb, $kdkaryabudaya, $kdpngjwb, $lat, $lng, $kategoribudaya, $kdkategori, $jarak);
            $haversines = array();
            while($stmt->fetch()) {
                $haversine = array();
                $haversine['pngjwb'] = $kdpngjwb;
                $haversine['alamat'] = $alamat;
                $haversine['telepon'] = $telepon;
                $haversine['usia'] = $usia;
                $haversine['email'] = $email;
                $haversine['riwayat_hidup'] = $riwayathidup;
                $haversine['kd_kecamatan'] = $kecamatan;
                $haversine['foto_pngjwb'] = $fotopngjwb;
                $haversine['pngjwb'] = $namapngjwb;
                $haversine['kd_karyabudaya'] = $kdkaryabudaya;
                $haversine['kd_pngjwb'] = $kdpngjwb;
                $haversine['lat'] = $lat;
                $haversine['lng'] = $lng;
                $haversine['kategori_budaya'] = $kategoribudaya;
                $haversine['kd_kategorikb'] = $kdkategori;
                $haversine['jarak'] = $jarak;
                array_push($haversines, $haversine);
            }
            return $haversines;
        }

        public function getAllPencatatan() {
            $stmt = $this->con->prepare("SELECT p.no_pencatatan as no_pencatatan, p.tgl_catat as tgl_catat, p.status as status, k.karya_budaya as karya_budaya, pe.pelapor as pelapor
                                        FROM pencatatan p JOIN karyabudaya k ON (p.kd_karyabudaya = k.kd_karyabudaya)
                                        JOIN pelapor pe ON (pe.kd_pelapor = p.kd_pelapor)");
            $stmt->execute();
            $stmt->bind_result($nopencatatan, $tglcatat, $status, $namakaryabudaya, $namapelapor);
            $pencatatans = array();
            while($stmt->fetch()) {
                $pencatatan = array();
                $pencatatan['no_pencatatan'] = $nopencatatan;
                $pencatatan['tgl_catat'] = $tglcatat;
                $pencatatan['status'] = $status;
                $pencatatan['karya_budaya'] = $namakaryabudaya;
                $pencatatan['pelapor'] = $namapelapor;
                array_push($pencatatans, $pencatatan);
            }
            return $pencatatans;
        }

        public function getAllPenetapan() {
            $stmt = $this->con->prepare("SELECT p.no_penetapan, p.no_sk, p.tgl_penetapan, p.no_pencatatan, k.kondisikaryabudaya
                                         FROM penetapan p JOIN kondisikaryabudaya k ON (p.kd_kondisi = k.kd_kondisi)");
            $stmt->execute();
            $stmt->bind_result($nopenetapan, $nosk, $tglpenetapan, $nopencatatan, $kondisi);
            $penetapans = array();
            while($stmt->fetch()) {
                $penetapan = array();
                $penetapan['no_penetapan'] = $nopenetapan;
                $penetapan['no_sk'] = $nosk;
                $penetapan['tgl_penetapan'] = $tglpenetapan;
                $penetapan['no_pencatatan'] = $nopencatatan;
                $penetapan['kondisikaryabudaya'] = $kondisi;
                array_push($penetapans, $penetapan);
            }
            return $penetapans;
        }

        public function searchKaryaBudaya($getkb) {
            $getkbs = '%' . $getkb . '%';
            $stmt = $this->con->prepare("SELECT kd_karyabudaya, karya_budaya, foto_budaya, deskripsi_singkat, sejarah_singkat FROM karyabudaya WHERE karya_budaya LIKE ? ");
            $stmt->bind_param("s", $getkbs);
            $stmt->execute();
            $stmt->bind_result($kdkaryabudaya, $karyabudaya, $fotobudaya, $deskripsisingkat, $sejarahsingkat);
            $searchkbs = array();
            while($stmt->fetch()) {
                $searchkb = array();
                $searchkb['kd_karyabudaya'] = $kdkaryabudaya;
                $searchkb['karya_budaya'] = $karyabudaya;
                $searchkb['foto_budaya'] = $fotobudaya;
                $searchkb['deskripsi_singkat'] = $deskripsisingkat;
                $searchkb['sejarah_singkat'] = $sejarahsingkat;
                array_push($searchkbs, $searchkb);
            }
            return $searchkbs;
        }

        public function searchMaestro($getkb) {
            $getkbs = '%' . $getkb . '%';
            $stmt = $this->con->prepare("SELECT kd_maestro, maestro, alamat, usia, telepon, email, riwayat_hidup, foto_maestro
                                         FROM maestro
                                         WHERE maestro LIKE ? ");
            $stmt->bind_param("s", $getkbs);
            $stmt->execute();
            $stmt->bind_result($kdmaestro, $maestro, $alamat, $usia, $telepon, $email, $riwayat, $fotomaestro);
            $searchmaestros = array();
            while($stmt->fetch()) {
                $searchmaestro = array();
                $searchmaestro['kd_maestro'] = $kdmaestro;
                $searchmaestro['maestro'] = $maestro;
                $searchmaestro['alamat'] = $alamat;
                $searchmaestro['usia'] = $usia;
                $searchmaestro['telepon'] = $telepon;
                $searchmaestro['email'] = $email;
                $searchmaestro['riwayat_hidup'] = $riwayat;
                $searchmaestro['foto_maestro'] = $fotomaestro;
                array_push($searchmaestros, $searchmaestro);
            }
            return $searchmaestros;
        }

        public function getAllLocations() {
            $stmt = $this->con->prepare("SELECT k.karya_budaya, p.pngjwb, dp.lat, dp.lng
                                         FROM karyabudaya k JOIN detil_penanggungjawab dp ON (k.kd_karyabudaya = dp.kd_karyabudaya)
                                         JOIN penanggungjawabbudaya p ON (p.kd_pngjwb = dp.kd_pngjwb)");
            $stmt->execute();
            $stmt->bind_result($karyabudaya, $pngjwb, $lat, $lng);
            $locations = array();
            while($stmt->fetch()) {
                $location = array();
                $location['karya_budaya'] = $karyabudaya;
                $location['pngjwb'] = $pngjwb;
                $location['lat'] = $lat;
                $location['lng'] = $lng;
                array_push($locations, $location);
            }
            return $locations;
        }

        public function getAllKaryaBudaya() {
            $stmt = $this->con->prepare("SELECT kd_karyabudaya, karya_budaya, foto_budaya, deskripsi_singkat, sejarah_singkat, kd_dokumentasi
                                         FROM karyabudaya");
            $stmt->execute();
            $stmt->bind_result($kdkaryabudaya, $karyabudaya, $fotobudaya, $deskripsi, $sejarah, $kddokumentasi);
            $budayas = array();
            while($stmt->fetch()) {
                $budaya = array();
                $budaya['kd_karyabudaya'] = $kdkaryabudaya;
                $budaya['karya_budaya'] = $karyabudaya;
                $budaya['foto_budaya'] = $fotobudaya;
                $budaya['deskripsi_singkat'] = $deskripsi;
                $budaya['sejarah_singkat'] = $sejarah;
                $budaya['kd_dokumentasi'] = $kddokumentasi;
                array_push($budayas, $budaya);
            }
            return $budayas;
        }

        public function getAllMaestro() {
            $stmt = $this->con->prepare("SELECT kd_maestro, maestro, alamat, usia, telepon, email, riwayat_hidup, foto_maestro
            FROM maestro");
            $stmt->execute();
            $stmt->bind_result($kdmaestro, $namamaestro, $alamat, $usia, $telepon, $email, $riwayat, $foto);
            $maestros = array();
            while($stmt->fetch()){
                $maestro = array();
                $maestro['kd_maestro'] = $kdmaestro;
                $maestro['maestro'] = $namamaestro;
                $maestro['alamat'] = $alamat;
                $maestro['usia'] = $usia;
                $maestro['telepon'] = $telepon;
                $maestro['email'] = $email;
                $maestro['riwayat_hidup'] = $riwayat;
                $maestro['foto_maestro'] = $foto;
                array_push($maestros, $maestro);
            }                            
            return $maestros;
        }

        public function getFotoSlider() {
            $stmt = $this->con->prepare("SELECT kd_foto_slider, foto_slider, judul_foto FROM foto_slider");
            $stmt->execute();
            $stmt->bind_result($kdfotoslider, $fotoslider, $judulfoto);
            $sliders = array();
            while($stmt->fetch()){
                $slider = array();
                $slider['kd_foto_slider'] = $kdfotoslider;
                $slider['foto_slider'] = $fotoslider;
                $slider['judul_foto'] = $judulfoto;
                array_push($sliders, $slider);
            }                            
            return $sliders;
        }

        public function getDetailHaversine($kdpngjwb) {
            $stmt = $this->con->prepare("SELECT kd_pngjwb, pngjwb, alamat, telepon, email, foto_pngjwb
            FROM penanggungjawabbudaya 
            WHERE kd_pngjwb = ?");
            $stmt->bind_param("s", $kdpngjwb);
            $stmt->execute();
            $stmt->bind_result($kdpngjwb, $pngjwb, $alamat, $telepon, $email, $foto_pngjwb);
            $dhaversines = array();
            while($stmt->fetch()) {
                $dhaversine = array();
                $dhaversine['kd_pngjwb'] = $kdpngjwb;
                $dhaversine['pngjwb'] = $pngjwb;
                $dhaversine['alamat'] = $alamat;
                $dhaversine['telepon'] = $telepon;
                $dhaversine['email'] = $email;
                $dhaversine['foto_pngjwb'] = $foto_pngjwb;
                array_push($dhaversines, $dhaversine);
            }
            return $dhaversines;
        }



    }
