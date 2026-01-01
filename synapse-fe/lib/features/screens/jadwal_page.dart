import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';
import '../../core/models/jadwal_model.dart';

class JadwalPage extends StatefulWidget {
  final VoidCallback onBackToHome;
  const JadwalPage({super.key, required this.onBackToHome});

  @override
  State<JadwalPage> createState() => _JadwalPageState();
}

class _JadwalPageState extends State<JadwalPage> {
  int selectedHari = 1; // Default Senin
  final List<String> daftarHari = ["Senin", "Selasa", "Rabu", "Kamis", "Jumat"];

  @override
  Widget build(BuildContext context) {
    // Filter masterJadwal berdasarkan hari yang dipilih
    final listJadwal = masterJadwal
        .where((j) => j.hari == selectedHari)
        .toList();

    return Scaffold(
      backgroundColor: const Color(0xFFFDFBF0),
      body: Column(
        children: [
          _buildHeader(),
          _buildDayTabs(),
          Expanded(
            child: listJadwal.isEmpty
                ? _buildEmptyState()
                : ListView.builder(
                    padding: const EdgeInsets.symmetric(horizontal: 25),
                    itemCount: listJadwal.length,
                    itemBuilder: (context, index) =>
                        _buildJadwalItem(listJadwal[index]),
                  ),
          ),
        ],
      ),
    );
  }

  Widget _buildHeader() {
    return Container(
      padding: const EdgeInsets.only(top: 50, bottom: 20),
      width: double.infinity,
      color: const Color(0xFF4DFED1),
      child: Stack(
        children: [
          IconButton(
            icon: const Icon(Icons.arrow_back_ios_new, color: Colors.white),
            onPressed: widget.onBackToHome,
          ),
          Center(
            child: Text(
              "Jadwal",
              style: GoogleFonts.fredoka(
                color: Colors.white,
                fontSize: 24,
                fontWeight: FontWeight.bold,
              ),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildDayTabs() {
    return Container(
      height: 100,
      child: ListView.builder(
        scrollDirection: Axis.horizontal,
        padding: const EdgeInsets.symmetric(horizontal: 20, vertical: 25),
        itemCount: daftarHari.length,
        itemBuilder: (context, index) {
          bool isActive = selectedHari == (index + 1);
          return GestureDetector(
            onTap: () => setState(() => selectedHari = index + 1),
            child: Container(
              margin: const EdgeInsets.only(right: 15),
              padding: const EdgeInsets.symmetric(horizontal: 25),
              decoration: BoxDecoration(
                color: isActive
                    ? const Color(0xFF4DFED1)
                    : const Color(0xFF08A4A7).withOpacity(0.8),
                borderRadius: BorderRadius.circular(10),
              ),
              child: Center(
                child: Text(
                  daftarHari[index],
                  style: GoogleFonts.fredoka(
                    color: Colors.white,
                    fontWeight: FontWeight.bold,
                  ),
                ),
              ),
            ),
          );
        },
      ),
    );
  }

  Widget _buildJadwalItem(Jadwal j) {
    const double cardHeight = 110.0;

    return Container(
      margin: const EdgeInsets.only(bottom: 15),
      height: cardHeight,
      decoration: BoxDecoration(
        color: const Color(0xFF4DFED1),
        borderRadius: BorderRadius.circular(15),
      ),
      child: Row(
        crossAxisAlignment:
            CrossAxisAlignment.stretch,
        children: [
          // --- BAGIAN GAMBAR (DIPAKSA PENUH) ---
          ClipRRect(
            borderRadius: const BorderRadius.only(
              topLeft: Radius.circular(15),
              bottomLeft: Radius.circular(15),
            ),
            child: SizedBox(
              width: 120,
              height: cardHeight,
              child: Image.asset(
                j.imageAsset,
                fit: BoxFit
                    .cover,
                errorBuilder: (context, error, stackTrace) => Container(
                  color: Colors.grey.shade300,
                  child: const Icon(Icons.image, color: Colors.grey),
                ),
              ),
            ),
          ),

          // --- BAGIAN TEKS (TANPA PADDING LUAR) ---
          Expanded(
            child: Padding(
              padding: const EdgeInsets.all(
                15,
              ),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                mainAxisAlignment: MainAxisAlignment.center,
                children: [
                  Text(
                    j.subjek,
                    style: GoogleFonts.fredoka(
                      color: Colors.white,
                      fontSize: 18,
                      fontWeight: FontWeight.bold,
                    ),
                    maxLines: 1,
                    overflow: TextOverflow.ellipsis,
                  ),
                  Text(
                    j.guru,
                    style: GoogleFonts.fredoka(
                      color: Colors.white70,
                      fontSize: 13,
                    ),
                    maxLines: 1,
                    overflow: TextOverflow.ellipsis,
                  ),
                  const SizedBox(height: 8),
                  Row(
                    children: [
                      const Icon(
                        Icons.access_time,
                        color: Colors.white,
                        size: 14,
                      ),
                      const SizedBox(width: 5),
                      Text(
                        "${j.jamMulai} - ${j.jamSelesai}",
                        style: GoogleFonts.fredoka(
                          color: Colors.white,
                          fontSize: 12,
                        ),
                      ),
                    ],
                  ),
                ],
              ),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildEmptyState() {
    return Center(
      child: Text(
        "Tidak ada pelajaran di hari ini",
        style: GoogleFonts.fredoka(color: Colors.grey),
      ),
    );
  }
}
