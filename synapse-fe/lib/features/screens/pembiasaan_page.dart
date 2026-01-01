import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';
import '../../core/models/pembiasaan_model.dart'; 

class PembiasaanPage extends StatelessWidget {
  const PembiasaanPage({super.key});

  // Fungsi pembantu untuk mengubah angka hari (1-5) menjadi nama hari
  String _getNamaHari(int hari) {
    switch (hari) {
      case 1: return "Senin";
      case 2: return "Selasa";
      case 3: return "Rabu";
      case 4: return "Kamis";
      case 5: return "Jumat";
      default: return "";
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFFDFBF0),
      appBar: AppBar(
        backgroundColor: const Color(0xFF4DFED1),
        elevation: 0,
        leading: IconButton(
          icon: const Icon(Icons.arrow_back_ios_new, color: Colors.white),
          onPressed: () => Navigator.pop(context),
        ),
        title: Text(
          "Daftar Pembiasaan", 
          style: GoogleFonts.fredoka(color: Colors.white, fontWeight: FontWeight.bold)
        ),
        centerTitle: true,
      ),
      // Kita pakai ListView.builder supaya bisa scroll semua datanya dengan lancar
      body: ListView.builder(
        padding: const EdgeInsets.all(25),
        itemCount: masterPembiasaan.length,
        itemBuilder: (context, index) {
          final data = masterPembiasaan[index];
          return _buildPembiasaanCard(_getNamaHari(data.hari), data);
        },
      ),
    );
  }

  Widget _buildPembiasaanCard(String hari, Pembiasaan data) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text(
          hari, 
          style: GoogleFonts.fredoka(fontWeight: FontWeight.bold, fontSize: 18, color: const Color(0xFF21004B))
        ),
        const SizedBox(height: 10),
        Container(
          width: double.infinity,
          height: 200,
          margin: const EdgeInsets.only(bottom: 30),
          decoration: BoxDecoration(
            color: Colors.white,
            borderRadius: BorderRadius.circular(15),
            boxShadow: [
              BoxShadow(
                color: Colors.black.withOpacity(0.05), 
                blurRadius: 10,
                offset: const Offset(0, 5),
              )
            ],
          ),
          child: ClipRRect(
            borderRadius: BorderRadius.circular(15),
            child: Column(
              children: [
                Expanded(
                  child: Image.asset(
                    data.imageAsset,
                    width: double.infinity, 
                    fit: BoxFit.cover,
                    errorBuilder: (context, error, stackTrace) => Container(
                      color: Colors.grey.shade300,
                      child: const Icon(Icons.broken_image, color: Colors.grey, size: 50),
                    ),
                  ),
                ),
                Container(
                  padding: const EdgeInsets.all(15),
                  width: double.infinity,
                  color: const Color(0xFF4DFED1),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Text(
                        data.judul,
                        style: GoogleFonts.fredoka(
                          color: Colors.white, 
                          fontWeight: FontWeight.bold,
                          fontSize: 16,
                        ),
                      ),
                      Text(
                        data.deskripsi,
                        style: GoogleFonts.fredoka(
                          color: Colors.white.withOpacity(0.9), 
                          fontSize: 13,
                        ),
                      ),
                    ],
                  ),
                ),
              ],
            ),
          ),
        ),
      ],
    );
  }
}