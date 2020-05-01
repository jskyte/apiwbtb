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
            $stmt = $this->con->prepare("SELECT p.pngjwb as namapngjwb, k.kecamatan as kecamatan, dp.lat as lat, dp.lng as lng
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

    }
