class Pembiasaan {
  final int hari;
  final String judul;
  final String deskripsi;
  final String imageAsset;

  Pembiasaan({
    required this.hari,
    required this.judul,
    required this.deskripsi,
    required this.imageAsset,
  });
}

List<Pembiasaan> masterPembiasaan = [
  Pembiasaan(
    hari: 1,
    judul: "Senin Khidmat",
    deskripsi: "Upacara Bendera",
    imageAsset: "assets/images/pembiasaan/upacara_cover.png",
  ),
  Pembiasaan(
    hari: 2,
    judul: "Selasa Bugar",
    deskripsi: "Senam Pagi Bersama",
    imageAsset: "assets/images/pembiasaan/senam_cover.png",
  ),
  Pembiasaan(
    hari: 3,
    judul: "Rabu Religi",
    deskripsi: "Shalat Dhuha & Muraja'ah",
    imageAsset: "assets/images/pembiasaan/religi_cover.png",
  ),
  Pembiasaan(
    hari: 4,
    judul: "Kamis Budaya",
    deskripsi: "Literasi & Bahasa Daerah",
    imageAsset: "assets/images/pembiasaan/budaya_cover.png",
  ),
  Pembiasaan(
    hari: 5,
    judul: "Jumat Bersih",
    deskripsi: "Kerja Bakti Lingkungan",
    imageAsset: "assets/images/pembiasaan/bersih_cover.png",
  ),
];