import 'dart:async';
import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';
import '../../core/models/soal_model.dart';
import '../../core/services/api_service.dart';

class UjianPage extends StatefulWidget {
  final int ulanganId;
  final String mapel;

  const UjianPage({super.key, required this.ulanganId, required this.mapel});

  @override
  _UjianPageState createState() => _UjianPageState();
}

class _UjianPageState extends State<UjianPage> {
  int _currentIndex = 0;
  int _secondsRemaining = 7200;
  Timer? _timer;
  bool _isLoading = true;
  List<Soal> _listSoal = [];
  Map<int, String> _jawabanSiswa = {};

  // Controller untuk input essay
  final TextEditingController _essayController = TextEditingController();

  @override
  void initState() {
    super.initState();
    _loadSoal();
    _startTimer();
  }

  void _startTimer() {
    _timer = Timer.periodic(const Duration(seconds: 1), (timer) {
      if (_secondsRemaining > 0) {
        if (mounted) setState(() => _secondsRemaining--);
      } else {
        _timer?.cancel();
        _handleSubmit();
      }
    });
  }

  Future<void> _loadSoal() async {
    try {
      final data = await ApiService().getSoal(widget.ulanganId);
      if (mounted) {
        setState(() {
          _listSoal = data;
          _isLoading = false;
        });
      }
    } catch (e) {
      if (mounted) setState(() => _isLoading = false);
    }
  }

  // Fungsi untuk menyimpan jawaban saat pindah soal
  void _saveCurrentAnswer() {
    if (_listSoal[_currentIndex].type == 'essay') {
      _jawabanSiswa[_listSoal[_currentIndex].id] = _essayController.text;
    }
  }

  void _handleSubmit() async {
    _saveCurrentAnswer();

    // Munculkan Loading
    showDialog(
      context: context,
      barrierDismissible: false,
      builder: (ctx) => const Center(
        child: CircularProgressIndicator(color: Color(0xFF4DFED1)),
      ),
    );

    try {
      // Kirim ke ApiService
      final success = await ApiService().submitJawaban(
        widget.ulanganId,
        _jawabanSiswa,
      );

      if (mounted) {
        Navigator.pop(context); // Tutup loading dulu

        if (success) {
          // JIKA BERHASIL: Balik ke screen sebelumnya
          Navigator.of(context).pop();

          ScaffoldMessenger.of(context).showSnackBar(
            const SnackBar(
              backgroundColor: Colors.green,
              content: Text("Selamat! Ujian kamu sudah terkirim ke Laravel. ✨"),
            ),
          );
        } else {
          // JIKA GAGAL (StatusCode bukan 200): Kasih tahu Azil!
          ScaffoldMessenger.of(context).showSnackBar(
            const SnackBar(
              backgroundColor: Colors.redAccent,
              content: Text("Gagal mengirim: Cek Log Laravel atau Ngrok kamu!"),
            ),
          );
        }
      }
    } catch (e) {
      if (mounted) Navigator.pop(context); // Tutup loading kalau crash
      debugPrint("Submit Gagal Total: $e");
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          backgroundColor: Colors.black,
          content: Text("Error Koneksi: $e"),
        ),
      );
    }
  }

  @override
  Widget build(BuildContext context) {
    if (_isLoading)
      return const Scaffold(body: Center(child: CircularProgressIndicator()));
    if (_listSoal.isEmpty)
      return const Scaffold(body: Center(child: Text("Soal Kosong")));

    Soal soalAktif = _listSoal[_currentIndex];

    return Scaffold(
      backgroundColor: const Color(0xFFFDFBF0),
      body: Column(
        children: [
          _buildHeader(),
          Expanded(
            child: SingleChildScrollView(
              padding: const EdgeInsets.symmetric(horizontal: 25, vertical: 20),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    "Soal ${_currentIndex + 1} dari ${_listSoal.length}",
                    style: GoogleFonts.fredoka(
                      color: Colors.grey,
                      fontSize: 13,
                    ),
                  ),
                  const SizedBox(height: 15),

                  // Pertanyaan Box
                  Container(
                    width: double.infinity,
                    padding: const EdgeInsets.all(20),
                    decoration: BoxDecoration(
                      color: Colors.white,
                      borderRadius: BorderRadius.circular(8),
                    ),
                    child: Text(
                      soalAktif.pertanyaan,
                      style: GoogleFonts.fredoka(
                        fontSize: 17,
                        fontWeight: FontWeight.w600,
                        color: const Color(0xFF21004B),
                      ),
                    ),
                  ),
                  const SizedBox(height: 25),

                  // LOGIKA SWITCH UI: PG vs ESSAY
                  if (soalAktif.type == 'pg')
                    ...soalAktif.pilihan.asMap().entries.map((entry) {
                      String label = String.fromCharCode(
                        65 + entry.key,
                      ); // A, B, C, D
                      return _buildOption(label, entry.value);
                    }).toList()
                  else
                    _buildEssayField(), // Munculkan kolom ngetik kalau essay!
                ],
              ),
            ),
          ),
          _buildFooter(),
        ],
      ),
    );
  }

  // WIDGET KOLOM ESSAY
  Widget _buildEssayField() {
    return Container(
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(8),
      ),
      padding: const EdgeInsets.all(15),
      child: TextField(
        controller: _essayController,
        maxLines: 5,
        decoration: InputDecoration(
          hintText: "Tuliskan jawaban kamu di sini...",
          hintStyle: GoogleFonts.fredoka(color: Colors.grey.shade400),
          border: InputBorder.none,
        ),
        style: GoogleFonts.fredoka(),
        onChanged: (val) {
          _jawabanSiswa[_listSoal[_currentIndex].id] = val;
        },
      ),
    );
  }

  // --- Header, Option, & Footer Widget tetap sama seperti sebelumnya ---
  // (Pastikan memanggil _saveCurrentAnswer() saat pindah soal di Footer)
  Widget _buildFooter() {
    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 25, vertical: 20),
      color: Colors.white,
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          if (_currentIndex > 0)
            ElevatedButton(
              onPressed: () {
                _saveCurrentAnswer();
                setState(() {
                  _currentIndex--;
                  // Reset isi controller dengan jawaban sebelumnya jika ada
                  _essayController.text =
                      _jawabanSiswa[_listSoal[_currentIndex].id] ?? "";
                });
              },
              style: ElevatedButton.styleFrom(
                backgroundColor: Colors.grey,
                shape: RoundedRectangleBorder(
                  borderRadius: BorderRadius.circular(8),
                ),
              ),
              child: Text(
                "Kembali",
                style: GoogleFonts.fredoka(color: Colors.white),
              ),
            ),
          const Spacer(),
          ElevatedButton(
            onPressed: () {
              _saveCurrentAnswer();
              if (_currentIndex < _listSoal.length - 1) {
                setState(() {
                  _currentIndex++;
                  // Reset isi controller untuk soal berikutnya
                  _essayController.text =
                      _jawabanSiswa[_listSoal[_currentIndex].id] ?? "";
                });
              } else {
                _handleSubmit(); // TOMBOL SELESAI!
              }
            },
            style: ElevatedButton.styleFrom(
              backgroundColor: const Color(0xFF08A4A7),
              shape: RoundedRectangleBorder(
                borderRadius: BorderRadius.circular(8),
              ),
            ),
            child: Text(
              _currentIndex == _listSoal.length - 1 ? "Selesai" : "Selanjutnya",
              style: GoogleFonts.fredoka(color: Colors.white),
            ),
          ),
        ],
      ),
    );
  }

  // Widget Header & Option Helper (Bisa copy dari turn sebelumnya)
  Widget _buildHeader() => Container(
    padding: const EdgeInsets.only(top: 55, bottom: 20, left: 15, right: 20),
    color: const Color(0xFF4DFED1),
    child: Row(
      mainAxisAlignment: MainAxisAlignment.spaceBetween,
      children: [
        IconButton(
          icon: const Icon(Icons.close, color: Colors.white),
          onPressed: () => Navigator.pop(context),
        ),
        Text(
          widget.mapel,
          style: GoogleFonts.fredoka(
            color: Colors.white,
            fontSize: 18,
            fontWeight: FontWeight.w600,
          ),
        ),
        Container(
          padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 6),
          decoration: BoxDecoration(
            color: Colors.white,
            borderRadius: BorderRadius.circular(20),
          ),
          child: Text(
            "${(_secondsRemaining ~/ 60).toString().padLeft(2, '0')}:${(_secondsRemaining % 60).toString().padLeft(2, '0')}",
            style: GoogleFonts.fredoka(
              color: const Color(0xFF08A4A7),
              fontWeight: FontWeight.bold,
            ),
          ),
        ),
      ],
    ),
  );
  Widget _buildOption(String code, String text) {
    bool isSelected = _jawabanSiswa[_listSoal[_currentIndex].id] == code;
    return GestureDetector(
      onTap: () =>
          setState(() => _jawabanSiswa[_listSoal[_currentIndex].id] = code),
      child: Container(
        margin: const EdgeInsets.only(bottom: 12),
        padding: const EdgeInsets.all(15),
        decoration: BoxDecoration(
          color: isSelected
              ? const Color(0xFF4DFED1).withOpacity(0.1)
              : Colors.white,
          border: Border.all(
            color: isSelected ? const Color(0xFF4DFED1) : Colors.transparent,
          ),
          borderRadius: BorderRadius.circular(8),
        ),
        child: Row(
          children: [
            CircleAvatar(
              radius: 14,
              backgroundColor: isSelected
                  ? const Color(0xFF4DFED1)
                  : Colors.grey.shade100,
              child: Text(
                code,
                style: TextStyle(
                  color: isSelected ? Colors.white : Colors.black,
                ),
              ),
            ),
            const SizedBox(width: 15),
            Expanded(
              child: Text(text, style: GoogleFonts.fredoka(fontSize: 14)),
            ),
          ],
        ),
      ),
    );
  }

  @override
  void dispose() {
    _timer?.cancel();
    _essayController.dispose();
    super.dispose();
  }
}
