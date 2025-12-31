class Ulangan {
  final int id;
  final String mapel;
  final String guru;
  final String jam;
  final String durasi;
  final String status;
  final String imageAsset;

  Ulangan({
    required this.id,
    required this.mapel,
    required this.guru,
    required this.jam,
    required this.durasi,
    required this.status,
    required this.imageAsset,
  });
}

List<Ulangan> listUlangan = [
  Ulangan(
    id: 1,
    mapel: "Matematika",
    guru: "Budi Santoso, S.Pd",
    jam: "08:00 - 09:30",
    durasi: "90 Menit",
    status: "mulai",
    imageAsset: "assets/images/math_cover.png",
  ),
];