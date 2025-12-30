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
  Jadwal(
    subjek: "Bahasa Jepang",
    guru: "Pradita Surya Arianti",
    jamMulai: "07:00",
    jamSelesai: "09:15",
    hari: 1,
    imageAsset: "assets/images/jepang_cover.png",
  ),
  Jadwal(
    subjek: "Dasar Pemograman",
    guru: "Yaqub Hadi Permana S.T",
    jamMulai: "09:45",
    jamSelesai: "11:20",
    hari: 1,
    imageAsset: "assets/images/koding_cover.png",
  ),
  Jadwal(
    subjek: "Matematika",
    guru: "Budi Santoso",
    jamMulai: "07:00",
    jamSelesai: "08:30",
    hari: 2,
    imageAsset: "assets/images/koding_cover.png",
  ),
  Jadwal(
    subjek: "Web Product",
    guru: "Pak Deri Kurniawan",
    jamMulai: "07:00",
    jamSelesai: "12:00",
    hari: 3,
    imageAsset: "assets/images/koding_cover.png",
  ),
];
