class Jadwal {
  final String subjek;
  final String guru;
  final String jamMulai;
  final String jamSelesai;
  final int hari;
  final String imageAsset;

  Jadwal({
    required this.subjek,
    required this.guru,
    required this.jamMulai,
    required this.jamSelesai,
    required this.hari,
    required this.imageAsset,
  });
}

List<Jadwal> masterJadwal = [
  // --- SENIN (Hari 1) ---
  Jadwal(
    subjek: "Bahasa Jepang",
    guru: "Pradita Surya Arianti",
    jamMulai: "07:00",
    jamSelesai: "09:15",
    hari: 1,
    imageAsset: "assets/images/mapel/jepang_cover.png",
  ),
  Jadwal(
    subjek: "Dasar Pemograman",
    guru: "Yaqub Hadi Permana S.T",
    jamMulai: "09:45",
    jamSelesai: "11:20",
    hari: 1,
    imageAsset: "assets/images/mapel/koding_cover.png",
  ),

  // --- SELASA (Hari 2) ---
  Jadwal(
    subjek: "Matematika",
    guru: "Budi Santoso",
    jamMulai: "07:00",
    jamSelesai: "08:30",
    hari: 2,
    imageAsset: "assets/images/mapel/mtk_cover.png",
  ),
  Jadwal(
    subjek: "Pendidikan Agama",
    guru: "Ust. Ahmad Syarif",
    jamMulai: "09:00",
    jamSelesai: "10:30",
    hari: 2,
    imageAsset: "assets/images/mapel/religi_cover.png", 
  ),

  // --- RABU (Hari 3) ---
  Jadwal(
    subjek: "Web Product",
    guru: "Pak Deri Kurniawan",
    jamMulai: "07:00",
    jamSelesai: "12:00",
    hari: 3,
    imageAsset: "assets/images/mapel/koding_cover.png",
  ),

  // --- KAMIS (Hari 4) ---
  Jadwal(
    subjek: "Bahasa Indonesia",
    guru: "Ibu Siti Aminah",
    jamMulai: "07:30",
    jamSelesai: "09:00",
    hari: 4,
    imageAsset: "assets/images/mapel/indo_cover.png",
  ),
  Jadwal(
    subjek: "PKN",
    guru: "Drs. Mulyadi",
    jamMulai: "09:30",
    jamSelesai: "11:00",
    hari: 4,
    imageAsset: "assets/images/mapel/pkn_cover.png",
  ),

  // --- JUMAT (Hari 5) ---
  Jadwal(
    subjek: "Olahraga",
    guru: "Pak Bambang",
    jamMulai: "07:00",
    jamSelesai: "08:30",
    hari: 5,
    imageAsset: "assets/images/mapel/olahraga_cover.png",
  ),
  Jadwal(
    subjek: "Mobile Dev",
    guru: "Yaqub Hadi Permana S.T",
    jamMulai: "09:00",
    jamSelesai: "11:00",
    hari: 5,
    imageAsset: "assets/images/mapel/koding_cover.png",
  ),
];