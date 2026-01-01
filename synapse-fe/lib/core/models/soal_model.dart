class Soal {
  final int id;
  final String pertanyaan;
  final String? imageSoal;
  final List<String> pilihan;
  final String type;

  Soal({
    required this.id,
    required this.pertanyaan,
    this.imageSoal,
    required this.pilihan,
    required this.type,
  });

  factory Soal.fromJson(Map<String, dynamic> json) {
    var optionsData = json['options'];
    List<String> listPilihan = [];

    if (optionsData != null && optionsData is Map) {
      listPilihan = optionsData.values.map((value) => value.toString()).toList();
    }

    return Soal(
      id: (json['id'] as num).toInt(),
      pertanyaan: json['question_text']?.toString() ?? '',
      imageSoal: json['question_image'],
      type: json['type'] ?? 'pg',
      pilihan: listPilihan,
    );
  }
}