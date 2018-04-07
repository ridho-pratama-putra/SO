/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50505
Source Host           : 127.0.0.1:3306
Source Database       : so

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2018-04-07 08:40:53
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for catatan_obat
-- ----------------------------
DROP TABLE IF EXISTS `catatan_obat`;
CREATE TABLE `catatan_obat` (
  `id_catatan` int(255) NOT NULL AUTO_INCREMENT,
  `id_obat` int(11) DEFAULT NULL,
  `catatan` longtext,
  PRIMARY KEY (`id_catatan`),
  KEY `id_obat_catatan` (`id_obat`),
  CONSTRAINT `id_obat_catatan` FOREIGN KEY (`id_obat`) REFERENCES `master_obat` (`id_obat`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of catatan_obat
-- ----------------------------
INSERT INTO `catatan_obat` VALUES ('3', '10', '<ul><li>Benzodiazepin termasuk nitrazepam dan flurazepam digunakan sebagai hipnotik yang memiliki masa kerja panjang serta dapat memberikan efek residual di hari berikutnya, dosis berulang cenderung bersifat kumulatif</li><li>Benzodiazepin adalah ansiolitik dan hipnotik yang paling umum digunakan</li><li>Benzodiazepin <b>tidak cocok</b> untuk terapi jangka pendek ansietas ringan</li><li>Benzodiazepin hanya digunakan untuk terapi insomnia berat, atau kondisi stres yang sangat mengganggu.</li><li>Obat ini bekerja pada reseptor benzodiazepin yang berhubungan dengan reseptor asam gammaaminobutirat (GABA).</li></ul><b>Loprazolam, lormetazepam dan temazepam <br></b><ul><li>memiliki masa kerja lebih pendek dengan efek&nbsp;hangover&nbsp;yang sedikit bahkan tidak ada sama sekali. Fenomena penghentian obat lebih sering terjadi pada penggunaan benzodiazepin dengan masa kerja pendek. Jika insomnia yang terjadi disebabkan oleh dengan ansietas pada siang hari maka penggunaan benzodiazepin ansiolitik kerja panjang seperti diazepam yang diberikan sebagai dosis tunggal pada malam hari, dapat efektif mengatasi gejala tersebut.</li></ul>Dosis benzodiazepin dapat dihentikan secara bertahap, sekitar 1/8 (dalam interval 1/10 hingga 1/4 ) dari dosis sehari, dilakukan setiap malam ke 4. Saran untuk protokol penghentian obat pada pasien yang memiliki kesulitan adalah sbb:<ol><li>Pada pasien yang ganti dengan obat setara dengan dosis diazepam per hari, sebaiknya dikonsumsi malam hari.</li><li>Turunkan dosis diazepam bertahap setiap 2–3 minggu sebanyak 2 atau 2,5 mg; jika gejala putus obat muncul, pertahankan dosis obat ini hingga gejala membaik.</li><li>Turunkan dosis lebih lanjut, jika perlu bertahap dengan dosis lebih kecil. Lebih baik penurunan dosis dilakukan dengan lebih lambat daripada dilakukan terlalu cepat.</li><li>Penghentian total. Waktu yang dibutuhkan untuk penghentian total dapat bervariasi dari sekitar 4 minggu hingga 1 tahun atau lebih.</li></ol><span>Konseling dapat membantu. beta bloker dicoba hanya jika pengobatan lainnya gagal. Antidepresan hanya digunakan dalam keadaan depresi klinik atau untuk gangguan panik; hindari antipsikosis (yang dapat memperburuk gejala putus obat).<br></span><b><br></b><b>Saran:</b><br><ol><li>Benzodiazepin diindikasikan untuk terapi jangka pendek ansietas berat (hanya digunakan selama 2 atau 4 minggu)</li><li>kondisi stres yang sangat mengganggu</li><li>kondisi ansietas saja atau yang terkait insomnia atau psikosomatik jangka pendek</li><li>penyakit psikotik atau penyakit yang dialami organ tubuh.</li></ol><b></b><b>Efek Paradoksikal&nbsp;</b><br><ul><li>Paradoksikal meningkat pada keadaan terancam/ ada ancaman dan sifat agresi dilaporkan terjadi pada pasien yang mengkonsumsi benzodiazepin. efeknya bervariasi mulai dari meracau dan rasa gembira sampai sifat agresif dan melakukan tindakan anti sosial. Penyesuaian dosis (meningkat ataupun menurun) biasanya melemahkan impuls. Peningkatan ansietas dan gangguan persepsi merupakan efek paradoksikal lainnya. Meningkatnya rasa bermusuhan dan agresi setelah mengkonsumsi barbiturat dan alkohol biasanya mengindikasikan adanya intoksikasi.</li></ul><b></b><b>Mengemudi<br></b><ul><li>Hipnotik dan ansiolitik dapat mempengaruhi kemampuan pengambilan keputusan dan memperlambat reaksi, sehingga berefek pada kemampuan mengemudi dan mengoperasikan mesin. Obat ini meningkatkan efek alkohol. Lebih lanjut, efek&nbsp;hangover&nbsp;pada dosis malam dapat mempengaruhi kemampuan mengemudi pada hari berikutnya. Lihat juga pada Obat dan Mengemudi pada Pedoman Umum.</li></ul><b>Ketergantungan dan Penghentian Obat</b><br><ul><li>Penghentian penggunaan benzodiazepin sebaiknya secara bertahap karena penghentian yang tiba-tiba dapat mengakibatkan kebingungan, gangguan psikosis, kejang atau kondisi mirip&nbsp;delirium tremens.&nbsp;</li><li>Sindroma gejala putus obat dapat timbul kapan saja hingga 3 minggu setelah penghentian benzodiazepin jangka panjang; dan dapat timbul dalam waktu beberapa jam pada penggunaan benzodiazepin jangka pendek. Hal ini ditunjukkan dengan terjadinya insomnia, ansietas, hilangnya nafsu makan dan turunnya berat badan, tremor, berkeringat, tinnitus, dan gangguan persepsi. Gejala-gejala ini mungkin sama dengan gejala umum penyakitnya sehingga penggunaan obat tetap dilanjutkan, beberapa gejala dapat berlanjut selama beberapa minggu atau beberapa bulan setelah penghentian benzodiazepin.</li></ul><br><br><br><br><br><br><br>');
INSERT INTO `catatan_obat` VALUES ('4', '11', '<ul><li>Penggunaan hipnotik sebaiknya dihindari pada lansia karena memiliki risiko terjadinya ataksia, bingung, mudah jatuh, dan melukai diri sendiri</li><li>Hipnotik dapat bermanfaat pada beberapa pasien yang cemas sewaktu akan menghadapi perawatan,&nbsp;digunakan pada waktu 1–3 malam sebelumnya.<b><br></b></li><li>Hipnotik tidak mengurangi rasa sakit dan jika rasa nyeri menganggu tidur, maka analgesik dapat diberikan<br></li><li>Peresepan hipnotik pada anak tidak dibenarkan kecuali untuk penggunaan sesekali seperti untuk mengatasi rasa takut pada malam hari dan somnabulisme (berjalan dalam tidur).<br></li><li>Pada penggunaan jangka panjang ada risiko habituasi (pemberian obat dapat menjadi kebiasaan) padahal untuk menenangkan anak pada malam hari, sebaiknya dilakukan pengobatan secara psikologis.<br></li></ul><b>Dosis:&nbsp;</b><div><ul><li>15-30 mg menjelang tidur malam hari;</li><li>Lansia (atau debilitated patients) 15 mg;</li><li>Anak, tidak dianjurkan.</li></ul>Merk obat&nbsp;<b>Dalmadorm&nbsp;</b>(menurut BPOM):</div><div><div><ul><li>Produsen:&nbsp;<a target=\"\" rel=\"\">Combiphar</a></li><li>Pendaftar:&nbsp;<a target=\"\" rel=\"\">Combiphar</a></li><li>Bentuk Sediaan:&nbsp;<a target=\"\" rel=\"\">Kapsul</a></li><li>Kekuatan: 15 mg</li><li>Golongan Obat:&nbsp;<a target=\"\" rel=\"\">K</a></li><li>Monografi:&nbsp;<a target=\"\" rel=\"\">FLURAZEPAM</a></li><li>Referensi Kelas Terapi: Hipnosis</li></ul></div></div>');
INSERT INTO `catatan_obat` VALUES ('5', '12', '<div><div><b>Efek Samping:&nbsp;</b></div><div><ul><li>ataksia dan bingung terutama pada pasien lansia, vertigo, amnesia, ketergantungan.</li></ul><br></div></div><div><div><b>Dosis:&nbsp;</b></div><div><ul><li>5-10 mg sebelum tidur;</li><li>LANSIA (atau debil) 2,5-5 mg;</li><li>ANAK tidak dianjurkan.</li></ul></div></div>');
INSERT INTO `catatan_obat` VALUES ('6', '13', '<ul><li>Untuk semua bentuk gangguan tidur disebabkan oleh gugup, ansietas, tegang, psikosis dan nyeri setelah operasi, trauma.</li></ul><b>Peringatan:&nbsp;</b><ul><li>Menjalankan mesin, lansia, gangguan jantung, ginjal dan hati, bayi, kehamilan, menyusui, dapat terjadi sedasi yang berlebih, depresi pernapasan, hipotensi, atau gangguan koordinasi gerakan.</li></ul><b>Interaksi:&nbsp;</b><div><ul><li>Obat penekan SSP (hipnosedatif dan derivat fenotiazin), antidepresi, penghambat MAO, alkohol, dan pelemas otot: meningkatkan efek estazolam.</li></ul><b>Efek Samping:&nbsp;</b></div><div><ul><li>Ketergantungan pada penggunaan jangka panjang, gejala putus obat, depresi pernapasan, reaksi tidak normal, mengantuk, pusing, kepala terasa ringan, gangguan koordinasi gerakan, sakit kepala, lesu, kemerahan, gatal.</li></ul><b>Dosis:&nbsp;</b></div><div><ul><li>Dewasa :&nbsp;Neurosis, gangguan dalam: 1-2 mg.&nbsp;Psikosis, skizofrenia: 2-4 mg.&nbsp;Sebelum operasi: 1-2 mg pada malam hari. Estazolam digunakan sebelum tidur. Dosis disesuaikan menurut umur, gejala, dan kondisi pasien.</li></ul></div>');
INSERT INTO `catatan_obat` VALUES ('7', '14', '<div><b>Indikasi:&nbsp;</b></div><div><ul><li>premedikasi, induksi anestesi dan penunjang anestesi umum; sedasi untuk tindakan diagnostik &amp; anestesi lokal.</li></ul><b>Peringatan:&nbsp;</b></div><div><ul><li>insomnia pada psikosis, depresi berat, kerusakan otak organik, insufisiensi pernapasan, mengemudi atau mengoperasikan mesin yang berbahaya pada jam pertama sampai keenam setelah mendapat obat, orang dewasa lebih dari 60 tahun, hamil, menyusui, gangguan hati, ketergantungan, pemutusan obat mendadak, pengurangan bertahap setelah pemakaian lama, penggunaan intravena apabila fasilitas resusitasi tersedia.</li></ul><b>Efek Samping:&nbsp;</b></div><div><ul><li>jarang terjadi efek samping pada kardiorespirasi, mual, muntah, nyeri kepala, cegukan, laringospamus, dispnea, halusinasi, mengantuk berlebihan, ataksia, ruam kulit, reaksi paradoksikal, episode amnesia.</li></ul><b>Dosis:&nbsp;</b></div><div><ul><li>injeksi intramuskular premedikasi sebelum operasi: DEWASA 0,07-0,1 mg/kg bb: ANAK 0,15-0,2 mg/kg bb. Injeksi intravena premedikasi sebelum diagnostik/intervensi bedah 2,5-5 mg, selanjutnya 1 mg bila diperlukan. Induksi anestesi dewasa 10-15 mg intravena dalam kombinasi dengan narkotik 0,03-0,3 mg/kg bb/jam. ANAK 0,15-0,2 mg/kg bb intramuskular dalam kombinasi dengan ketamin. Sedasi dalam unit perawatan intensif (ICU) dosis muatan (loading dose) 0,03-0,3 mg/kg bb; dosis penunjang 0,03-0,2 mg/kg bb/jam.</li></ul></div>');
INSERT INTO `catatan_obat` VALUES ('8', '15', '<div><b>Efek Samping:&nbsp;</b></div><div><ul><li>iritasi lambung, distensi abdominal dan flatulensi, ruam kulit, kemudian nyeri kepala, ketonuria, eksitasi, delirium (terutama lansia), ketergantungan pada pemakaian jangka lama, gangguan ginjal dan hati, hipotensi.</li></ul><b>Dosis:&nbsp;</b><div><ul><li>insomnia 0,5-1 g (maksimal 2 g) dengan minum banyak air pada waktu sebelum tidur. ANAK 30-50 mg/kg bb sampai maksimal dosis tunggal 1 g.</li></ul></div></div>');
INSERT INTO `catatan_obat` VALUES ('9', '16', '<div><b>Peringatan:&nbsp;</b></div><div><ul><li>Seperti obat hipnotik yang lain, penggunaan obat ini dapat mengakibatkan eksaserbasi insomnia, gangguan kognitif dan abnormalitas tingkah laku serta perburukan depresi (termasuk keinginan bunuh diri) pada pasien depresi primer; hati-hati penggunaan pada penderita dengan gangguan hati sedang; tidak boleh digunakan pada penderita dengan gangguan hati yang parah. Hati-hati penggunaan pada pengguna alkohol; penderita yang mendapat obat penghambat CYP1A2; mengendarai kendaraan bermotor dan menjalankan mesin. Tidak dianjurkan pada penderita&nbsp;Severe Sleep Apnea&nbsp;atau penderita Penyakit Paru Obstruktif Kronis (PPOK); Tidak diperlukan penyesuaian dosis pada pasien gangguan ginjal ringan sampai berat termasuk pasien hemodialisis. Tidak dianjurkan penggunaan pada ibu hamil dan menyusui. Keamanan dan efektifitas penggunaan pada anak-anak belum ditetapkan.</li></ul><b>Interaksi:&nbsp;</b></div><div><ul><li>Tidak boleh digunakan bersama fluvoksamin (inhibitor kuat CYP1A2 ). Efikasi dapat menurun jika diberikan bersamaan dengan enzim penginduksi kuat CYP seperti rifampisin. Hati-hati penggunaan pada penderita yang juga mendapat obat inhbitor CYP3A4 seperti ketokonazol dan inhibitor kuat CYP2C9 seperti flukonazol.</li></ul><b>Kontraindikasi:&nbsp;</b></div><div><ul><li>penderita hipersensitif, penyakit hati berat, pemberian bersama fluvoksamin.</li></ul><b>Efek Samping:&nbsp;</b><br></div><div><div><ul><li><u></u>mengantuk, pusing, mual, lelah, sakit kepala dan insomnia.</li></ul></div></div><div><div><b>Dosis:&nbsp;</b></div><div><ul><li>8 mg diberikan 30 menit sebelum tidur. Tidak dianjurkan diberikan sewaktu makan atau segera setelah makan makanan dengan kadar lemak tinggi.</li></ul></div></div>');
INSERT INTO `catatan_obat` VALUES ('10', '17', '<div><div><div><div><b>Indikasi:&nbsp;</b></div><div><ul><li>insomnia dan terutama bila sulit tertidur: sering terbangun malam hari dan atau bangun terlalu pagi.</li></ul></div></div><div><div><b>Peringatan:&nbsp;</b></div><div><ul><li>individu yang mudah kecanduan, depresi laten, kecenderungan bunuh diri, gangguan fungsi ginjal dan hati, apneu waktu tidur, gangguan fungsi paru berat. Hindari menjalankan mesin atau mengemudi.</li></ul></div></div><div><div><b>Interaksi:&nbsp;</b></div><div><ul><li>simetidin, eritromisin. Efek ditingkatkan oleh alkohol dan depresan SSP lain.</li></ul></div></div><b>Efek Samping:&nbsp;</b></div><div><ul><li>mengantuk, gangguan koordinasi. Kadang-kadang amnesia anterograd, bingung, agitasi.</li></ul></div></div><div><div><div><div><b>Dosis:&nbsp;</b></div><div><ul><li>pasien geriatri 0,125 mg (naikkan bertahap sampai 0,25 mg bila diperlukan). Insomnia yang belum diobati sebelumnya 0,125 mg (naikkan sampai 0,25 mg bila diperlukan). DEWASA 0,125-0,25 mg.</li></ul></div></div></div></div>');

-- ----------------------------
-- Table structure for gejala_log
-- ----------------------------
DROP TABLE IF EXISTS `gejala_log`;
CREATE TABLE `gejala_log` (
  `id_log_gejala` int(255) NOT NULL AUTO_INCREMENT,
  `id_log` int(11) DEFAULT NULL,
  `id_gejala` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_log_gejala`),
  KEY `id_gejala_log` (`id_log`),
  KEY `id_gejala_gejala` (`id_gejala`),
  CONSTRAINT `id_gejala_gejala` FOREIGN KEY (`id_gejala`) REFERENCES `master_gejala` (`id_gejala`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `id_gejala_log` FOREIGN KEY (`id_log`) REFERENCES `log_pengobatan` (`id_log`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of gejala_log
-- ----------------------------

-- ----------------------------
-- Table structure for karakteristik_obat
-- ----------------------------
DROP TABLE IF EXISTS `karakteristik_obat`;
CREATE TABLE `karakteristik_obat` (
  `id_karakteristik` int(255) NOT NULL AUTO_INCREMENT,
  `id_obat` int(255) DEFAULT NULL,
  `tipe` varchar(255) DEFAULT NULL,
  `id_tipe_master` varchar(255) DEFAULT NULL COMMENT 'untuk mengurangi inner join ;D',
  `detail_tipe` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_karakteristik`),
  KEY `nama_obat` (`id_obat`),
  CONSTRAINT `nama_obat` FOREIGN KEY (`id_obat`) REFERENCES `master_obat` (`id_obat`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of karakteristik_obat
-- ----------------------------
INSERT INTO `karakteristik_obat` VALUES ('1', '11', 'indikasi', '1', 'insomnia');
INSERT INTO `karakteristik_obat` VALUES ('2', '11', 'kontraindikasi', '6', 'Anak');
INSERT INTO `karakteristik_obat` VALUES ('3', '11', 'peringatan', '6', 'Anak');
INSERT INTO `karakteristik_obat` VALUES ('4', '12', 'indikasi', '1', 'insomnia');
INSERT INTO `karakteristik_obat` VALUES ('5', '12', 'indikasi', '2', 'gangguan tidur');
INSERT INTO `karakteristik_obat` VALUES ('6', '12', 'peringatan', '25', 'kehamilan');
INSERT INTO `karakteristik_obat` VALUES ('7', '12', 'peringatan', '8', 'menyusui');
INSERT INTO `karakteristik_obat` VALUES ('8', '12', 'peringatan', '9', 'penyakit pernapasan');
INSERT INTO `karakteristik_obat` VALUES ('9', '12', 'peringatan', '10', 'kelemahan otot');
INSERT INTO `karakteristik_obat` VALUES ('10', '12', 'peringatan', '11', 'riwayat penyalahgunaan obat atau alkohol');
INSERT INTO `karakteristik_obat` VALUES ('11', '12', 'peringatan', '12', 'kelainan kepribadian yang jelas');
INSERT INTO `karakteristik_obat` VALUES ('12', '12', 'peringatan', '14', 'gangguan faal hati dan ginjal yang jelas');
INSERT INTO `karakteristik_obat` VALUES ('13', '12', 'kontraindikasi', '15', 'depresi pernapasan');
INSERT INTO `karakteristik_obat` VALUES ('14', '12', 'kontraindikasi', '16', 'miastenia gravis');
INSERT INTO `karakteristik_obat` VALUES ('15', '12', 'kontraindikasi', '17', 'kondisi fobi atau obsesi');
INSERT INTO `karakteristik_obat` VALUES ('16', '12', 'kontraindikasi', '18', 'psikosis kronik');
INSERT INTO `karakteristik_obat` VALUES ('17', '12', 'kontraindikasi', '19', 'gangguan hati berat');
INSERT INTO `karakteristik_obat` VALUES ('18', '12', 'kontraindikasi', '6', 'anak');
INSERT INTO `karakteristik_obat` VALUES ('19', '12', 'peringatan', '6', 'anak');
INSERT INTO `karakteristik_obat` VALUES ('20', '13', 'indikasi', '2', 'gangguan tidur');
INSERT INTO `karakteristik_obat` VALUES ('21', '13', 'peringatan', '20', 'lansia');
INSERT INTO `karakteristik_obat` VALUES ('22', '13', 'peringatan', '21', 'gangguan jantung');
INSERT INTO `karakteristik_obat` VALUES ('23', '13', 'peringatan', '22', 'gangguan ginjal');
INSERT INTO `karakteristik_obat` VALUES ('24', '13', 'peringatan', '23', 'gangguan hati');
INSERT INTO `karakteristik_obat` VALUES ('25', '13', 'peringatan', '24', 'bayi');
INSERT INTO `karakteristik_obat` VALUES ('26', '13', 'peringatan', '25', 'kehamilan');
INSERT INTO `karakteristik_obat` VALUES ('27', '13', 'peringatan', '8', 'menyusui');
INSERT INTO `karakteristik_obat` VALUES ('28', '13', 'kontraindikasi', '16', 'Miastenia gravis');
INSERT INTO `karakteristik_obat` VALUES ('29', '13', 'kontraindikasi', '26', 'hipersensitivitas');
INSERT INTO `karakteristik_obat` VALUES ('30', '14', 'indikasi', '3', 'premedikasi');
INSERT INTO `karakteristik_obat` VALUES ('31', '14', 'indikasi', '4', 'induksi anestesi');
INSERT INTO `karakteristik_obat` VALUES ('32', '14', 'indikasi', '5', 'penunjang anestesi umum');
INSERT INTO `karakteristik_obat` VALUES ('33', '14', 'indikasi', '6', 'sedasi untuk tindakan diagnostik & anestesi lokal');
INSERT INTO `karakteristik_obat` VALUES ('34', '14', 'kontraindikasi', '27', 'bayi prematur');
INSERT INTO `karakteristik_obat` VALUES ('35', '14', 'kontraindikasi', '16', 'miastenia gravis');
INSERT INTO `karakteristik_obat` VALUES ('36', '14', 'peringatan', '28', 'insomnia');
INSERT INTO `karakteristik_obat` VALUES ('37', '14', 'peringatan', '29', 'depresi berat');
INSERT INTO `karakteristik_obat` VALUES ('38', '14', 'peringatan', '30', 'kerusakan otak organik');
INSERT INTO `karakteristik_obat` VALUES ('39', '14', 'peringatan', '31', 'insufisiensi pernapasan');
INSERT INTO `karakteristik_obat` VALUES ('40', '14', 'peringatan', '32', 'orang dewasa lebih dari 60 tahun');
INSERT INTO `karakteristik_obat` VALUES ('41', '14', 'peringatan', '25', 'kehamilan');
INSERT INTO `karakteristik_obat` VALUES ('42', '14', 'peringatan', '8', 'menyusui');
INSERT INTO `karakteristik_obat` VALUES ('43', '14', 'peringatan', '23', 'gangguan hati');
INSERT INTO `karakteristik_obat` VALUES ('44', '15', 'indikasi', '1', 'insomnia');
INSERT INTO `karakteristik_obat` VALUES ('45', '15', 'peringatan', '9', 'penyakit pernapasan');
INSERT INTO `karakteristik_obat` VALUES ('46', '15', 'peringatan', '11', 'riwayat penyalahgunaan obat atau alkohol');
INSERT INTO `karakteristik_obat` VALUES ('47', '15', 'peringatan', '35', 'gangguan kepribadian');
INSERT INTO `karakteristik_obat` VALUES ('48', '15', 'peringatan', '25', 'kehamilan');
INSERT INTO `karakteristik_obat` VALUES ('49', '15', 'peringatan', '8', 'menyusui');
INSERT INTO `karakteristik_obat` VALUES ('50', '15', 'kontraindikasi', '36', 'penyakit jantung berat');
INSERT INTO `karakteristik_obat` VALUES ('51', '15', 'kontraindikasi', '14', 'gangguan faal hati dan ginjal yang jelas');
INSERT INTO `karakteristik_obat` VALUES ('52', '15', 'kontraindikasi', '38', 'gastritis');
INSERT INTO `karakteristik_obat` VALUES ('53', '15', 'kontraindikasi', '25', 'kehamilan');
INSERT INTO `karakteristik_obat` VALUES ('54', '15', 'kontraindikasi', '8', 'menyusui');
INSERT INTO `karakteristik_obat` VALUES ('55', '16', 'indikasi', '1', 'insomnia');
INSERT INTO `karakteristik_obat` VALUES ('56', '16', 'kontraindikasi', '26', 'hipersensitivitas');
INSERT INTO `karakteristik_obat` VALUES ('57', '16', 'kontraindikasi', '39', 'penyakit hati berat');
INSERT INTO `karakteristik_obat` VALUES ('59', '16', 'peringatan', '41', 'gangguan hati sedang');
INSERT INTO `karakteristik_obat` VALUES ('60', '16', 'peringatan', '42', 'gangguan hati parah');
INSERT INTO `karakteristik_obat` VALUES ('61', '16', 'peringatan', '43', 'pengguna alkohol');
INSERT INTO `karakteristik_obat` VALUES ('62', '16', 'peringatan', '44', 'penderita yang mendapat obat penghambat CYP1A2');
INSERT INTO `karakteristik_obat` VALUES ('63', '16', 'peringatan', '45', 'Severe Sleep Apnea');
INSERT INTO `karakteristik_obat` VALUES ('64', '16', 'peringatan', '46', 'Penyakit Paru Obstruktif Kronis (PPOK)');
INSERT INTO `karakteristik_obat` VALUES ('65', '16', 'peringatan', '25', 'kehamilan');
INSERT INTO `karakteristik_obat` VALUES ('66', '16', 'peringatan', '8', 'menyusui');
INSERT INTO `karakteristik_obat` VALUES ('67', '17', 'indikasi', '1', 'insomnia');
INSERT INTO `karakteristik_obat` VALUES ('68', '17', 'indikasi', '7', 'sulit tertidur');
INSERT INTO `karakteristik_obat` VALUES ('69', '17', 'indikasi', '8', 'sering terbangun malam hari');
INSERT INTO `karakteristik_obat` VALUES ('70', '17', 'indikasi', '9', 'bangun terlalu pagi');
INSERT INTO `karakteristik_obat` VALUES ('71', '17', 'peringatan', '47', 'gangguan fungsi ginjal dan hati');
INSERT INTO `karakteristik_obat` VALUES ('73', '17', 'peringatan', '49', 'gangguan fungsi paru berat');

-- ----------------------------
-- Table structure for kondisi
-- ----------------------------
DROP TABLE IF EXISTS `kondisi`;
CREATE TABLE `kondisi` (
  `id_kondisi` int(255) NOT NULL AUTO_INCREMENT,
  `id_user` int(255) DEFAULT NULL,
  `id_master_kondisi` int(11) DEFAULT NULL,
  `detail_kondisi` varchar(255) DEFAULT NULL,
  `tanggal_ditambahkan` date DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_kondisi`),
  KEY `id_user_kondisi` (`id_user`),
  KEY `id_master_kondisi` (`id_master_kondisi`),
  KEY `detail_kondisi` (`detail_kondisi`),
  CONSTRAINT `detail_kondisi` FOREIGN KEY (`detail_kondisi`) REFERENCES `master_kondisi` (`detail_kondisi`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `id_master_kondisi` FOREIGN KEY (`id_master_kondisi`) REFERENCES `master_kondisi` (`id_master_kondisi`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `id_user_kondisi` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of kondisi
-- ----------------------------

-- ----------------------------
-- Table structure for log_pengobatan
-- ----------------------------
DROP TABLE IF EXISTS `log_pengobatan`;
CREATE TABLE `log_pengobatan` (
  `id_log` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  PRIMARY KEY (`id_log`),
  KEY `id_user_log` (`id_user`),
  CONSTRAINT `id_user_log` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of log_pengobatan
-- ----------------------------
INSERT INTO `log_pengobatan` VALUES ('1', '9', '2018-03-12');
INSERT INTO `log_pengobatan` VALUES ('2', '9', '2018-03-27');

-- ----------------------------
-- Table structure for master_gejala
-- ----------------------------
DROP TABLE IF EXISTS `master_gejala`;
CREATE TABLE `master_gejala` (
  `id_gejala` int(255) NOT NULL AUTO_INCREMENT,
  `detail_gejala` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_gejala`),
  UNIQUE KEY `nama_gejala` (`detail_gejala`) USING BTREE,
  KEY `id_gejala` (`id_gejala`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of master_gejala
-- ----------------------------
INSERT INTO `master_gejala` VALUES ('9', 'bangun terlalu pagi');
INSERT INTO `master_gejala` VALUES ('2', 'gangguan tidur');
INSERT INTO `master_gejala` VALUES ('4', 'induksi anestesi');
INSERT INTO `master_gejala` VALUES ('1', 'insomnia');
INSERT INTO `master_gejala` VALUES ('5', 'penunjang anestesi umum');
INSERT INTO `master_gejala` VALUES ('3', 'premedikasi');
INSERT INTO `master_gejala` VALUES ('6', 'sedasi untuk tindakan diagnostik & anestesi lokal');
INSERT INTO `master_gejala` VALUES ('8', 'sering terbangun malam hari');
INSERT INTO `master_gejala` VALUES ('7', 'sulit tertidur');

-- ----------------------------
-- Table structure for master_kondisi
-- ----------------------------
DROP TABLE IF EXISTS `master_kondisi`;
CREATE TABLE `master_kondisi` (
  `id_master_kondisi` int(255) NOT NULL AUTO_INCREMENT,
  `detail_kondisi` varchar(255) NOT NULL,
  PRIMARY KEY (`id_master_kondisi`),
  UNIQUE KEY `detail_kondisi_unik` (`detail_kondisi`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of master_kondisi
-- ----------------------------
INSERT INTO `master_kondisi` VALUES ('6', 'Anak');
INSERT INTO `master_kondisi` VALUES ('48', 'apneu waktu tidur');
INSERT INTO `master_kondisi` VALUES ('24', 'bayi');
INSERT INTO `master_kondisi` VALUES ('27', 'bayi prematur');
INSERT INTO `master_kondisi` VALUES ('29', 'depresi berat');
INSERT INTO `master_kondisi` VALUES ('15', 'depresi pernapasan');
INSERT INTO `master_kondisi` VALUES ('14', 'gangguan faal hati dan ginjal yang jelas');
INSERT INTO `master_kondisi` VALUES ('47', 'gangguan fungsi ginjal dan hati');
INSERT INTO `master_kondisi` VALUES ('49', 'gangguan fungsi paru berat');
INSERT INTO `master_kondisi` VALUES ('22', 'gangguan ginjal');
INSERT INTO `master_kondisi` VALUES ('23', 'gangguan hati');
INSERT INTO `master_kondisi` VALUES ('19', 'gangguan hati berat');
INSERT INTO `master_kondisi` VALUES ('42', 'gangguan hati parah');
INSERT INTO `master_kondisi` VALUES ('41', 'gangguan hati sedang');
INSERT INTO `master_kondisi` VALUES ('21', 'gangguan jantung');
INSERT INTO `master_kondisi` VALUES ('35', 'gangguan kepribadian');
INSERT INTO `master_kondisi` VALUES ('38', 'gastritis');
INSERT INTO `master_kondisi` VALUES ('33', 'hamil');
INSERT INTO `master_kondisi` VALUES ('26', 'hipersensitivitas');
INSERT INTO `master_kondisi` VALUES ('28', 'insomnia');
INSERT INTO `master_kondisi` VALUES ('31', 'insufisiensi pernapasan');
INSERT INTO `master_kondisi` VALUES ('25', 'kehamilan');
INSERT INTO `master_kondisi` VALUES ('12', 'kelainan kepribadian yang jelas');
INSERT INTO `master_kondisi` VALUES ('10', 'kelemahan otot');
INSERT INTO `master_kondisi` VALUES ('30', 'kerusakan otak organik');
INSERT INTO `master_kondisi` VALUES ('17', 'kondisi fobi atau obsesi');
INSERT INTO `master_kondisi` VALUES ('20', 'lansia');
INSERT INTO `master_kondisi` VALUES ('8', 'menyusui');
INSERT INTO `master_kondisi` VALUES ('16', 'miastenia gravis');
INSERT INTO `master_kondisi` VALUES ('32', 'orang dewasa lebih dari 60 tahun');
INSERT INTO `master_kondisi` VALUES ('44', 'penderita yang mendapat obat penghambat CYP1A2');
INSERT INTO `master_kondisi` VALUES ('43', 'pengguna alkohol');
INSERT INTO `master_kondisi` VALUES ('39', 'penyakit hati berat');
INSERT INTO `master_kondisi` VALUES ('36', 'penyakit jantung berat');
INSERT INTO `master_kondisi` VALUES ('46', 'Penyakit Paru Obstruktif Kronis (PPOK)');
INSERT INTO `master_kondisi` VALUES ('9', 'penyakit pernapasan');
INSERT INTO `master_kondisi` VALUES ('18', 'psikosis kronik');
INSERT INTO `master_kondisi` VALUES ('11', 'riwayat penyalahgunaan obat atau alkohol');
INSERT INTO `master_kondisi` VALUES ('45', 'Severe Sleep Apnea');

-- ----------------------------
-- Table structure for master_obat
-- ----------------------------
DROP TABLE IF EXISTS `master_obat`;
CREATE TABLE `master_obat` (
  `id_obat` int(11) NOT NULL AUTO_INCREMENT,
  `nama_obat` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_obat`),
  UNIQUE KEY `nama_obat` (`nama_obat`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of master_obat
-- ----------------------------
INSERT INTO `master_obat` VALUES ('10', 'BENZODIAZEPIN');
INSERT INTO `master_obat` VALUES ('13', 'ESTAZOLAM');
INSERT INTO `master_obat` VALUES ('11', 'FLURAZEPAM');
INSERT INTO `master_obat` VALUES ('15', 'KLORALHIDRAT');
INSERT INTO `master_obat` VALUES ('14', 'MIDAZOLAM');
INSERT INTO `master_obat` VALUES ('12', 'NITRAZEPAM');
INSERT INTO `master_obat` VALUES ('16', 'RAMELTEON');
INSERT INTO `master_obat` VALUES ('17', 'TRIAZOLAM');

-- ----------------------------
-- Table structure for obat_log
-- ----------------------------
DROP TABLE IF EXISTS `obat_log`;
CREATE TABLE `obat_log` (
  `id_log_obat` int(11) NOT NULL AUTO_INCREMENT,
  `id_log` int(255) DEFAULT NULL,
  `id_obat` int(255) DEFAULT NULL,
  `hash` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_log_obat`),
  KEY `id_obat_obat` (`id_obat`),
  KEY `id_obat_log` (`id_log`),
  CONSTRAINT `id_obat_log` FOREIGN KEY (`id_log`) REFERENCES `log_pengobatan` (`id_log`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `id_obat_obat` FOREIGN KEY (`id_obat`) REFERENCES `master_obat` (`id_obat`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of obat_log
-- ----------------------------

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id_user` int(255) NOT NULL AUTO_INCREMENT,
  `nama_user` varchar(255) DEFAULT NULL,
  `nomor_identitas` varchar(255) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `akses` varchar(255) DEFAULT NULL,
  `no_hp` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `link_foto` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `nomor_identitas` (`nomor_identitas`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'ridho', '140535606662', null, null, 'admin', null, 'db052c8066385d54dc1aa02c83ea6cf658a465b5e2f63bfffc5c79ac1dbe8447', 'a');
INSERT INTO `user` VALUES ('3', 'abdula', '140535606663', null, 'jalan mawar 45 malang', 'ppk', '085855858914', 'db052c8066385d54dc1aa02c83ea6cf658a465b5e2f63bfffc5c79ac1dbe8447', 'assets/images/users_photo/40dbd846001087_586632e0df7741.png');
INSERT INTO `user` VALUES ('9', 'pasien1', '140535606669', null, 'jalan mawar 45 malang', 'pasien', '085855858914', 'db052c8066385d54dc1aa02c83ea6cf658a465b5e2f63bfffc5c79ac1dbe8447', 'assets/images/users_photo/13528862_1039283519487891_4638299120502362364_n1.jpg');
INSERT INTO `user` VALUES ('10', 'user3', '1405356066610', null, 'jalan mawar 45 malang', 'pasien', '085855858914', 'db052c8066385d54dc1aa02c83ea6cf658a465b5e2f63bfffc5c79ac1dbe8447', 'assets/images/users_photo/97fdd8c53c4216cd793b794de5b1e73c1.jpg');

-- ----------------------------
-- Table structure for wm_gejala
-- ----------------------------
DROP TABLE IF EXISTS `wm_gejala`;
CREATE TABLE `wm_gejala` (
  `id_wm` varchar(255) DEFAULT NULL,
  `id_user` varchar(255) DEFAULT NULL,
  `id_gejala` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wm_gejala
-- ----------------------------

-- ----------------------------
-- Table structure for wm_kondisi
-- ----------------------------
DROP TABLE IF EXISTS `wm_kondisi`;
CREATE TABLE `wm_kondisi` (
  `id_wm_kondisi` varchar(255) DEFAULT NULL,
  `id_user` varchar(255) DEFAULT NULL,
  `id_kondisi` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wm_kondisi
-- ----------------------------

-- ----------------------------
-- Table structure for wm_obat
-- ----------------------------
DROP TABLE IF EXISTS `wm_obat`;
CREATE TABLE `wm_obat` (
  `id_wm_obat` varchar(255) DEFAULT NULL,
  `id_user` varchar(255) DEFAULT NULL,
  `id_obat` varchar(255) DEFAULT NULL,
  `tanggal` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wm_obat
-- ----------------------------
