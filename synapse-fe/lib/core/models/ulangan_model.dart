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

  factory Ulangan.fromJson(Map<String, dynamic> json) {
    return Ulangan(
      id: json['id'],
      mapel: json['subject_name'] ?? 'Mapel Tidak Diketahui', 
      guru: json['guru_name'] ?? 'Anonim',
      jam: "${json['start_time']} - ${json['end_time']}", 
      durasi: "${json['duration']} Menit",
      status: json['status'] ?? 'pending',
      imageAsset: json['cover_image'] ?? 'assets/images/default_cover.png',
    );
  }
}