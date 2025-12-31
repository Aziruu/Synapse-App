import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';

class HasilUjianPage extends StatelessWidget {
  final double skor;
  final String mapel;

  const HasilUjianPage({super.key, required this.skor, required this.mapel});

  @override
  Widget build(BuildContext context) {
    // Logika ucapan berdasarkan skor
    String pesan = skor >= 75 ? "Selamat Kamu Lulus ! 🎉" : "Maaf Kamu Remedial.";
    Color warnaSkor = skor >= 75 ? const Color(0xFF4DFED1) : Colors.orangeAccent;

    return Scaffold(
      backgroundColor: const Color(0xFFFDFBF0),
      body: Center(
        child: Padding(
          padding: const EdgeInsets.symmetric(horizontal: 30),
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              Text(
                pesan,
                textAlign: TextAlign.center,
                style: GoogleFonts.fredoka(
                  fontSize: 26, 
                  fontWeight: FontWeight.bold, 
                  color: const Color(0xFF08A4A7)
                ),
              ),
              const SizedBox(height: 10),
              Text(
                "Hasil Ulangan $mapel",
                style: GoogleFonts.fredoka(color: Colors.grey, fontSize: 16),
              ),
              const SizedBox(height: 50),

              // SKOR CIRCLE DISPLAY
              Container(
                width: 200,
                height: 200,
                decoration: BoxDecoration(
                  shape: BoxShape.circle,
                  color: Colors.white,
                  boxShadow: [
                    BoxShadow(
                      color: warnaSkor.withOpacity(0.3),
                      blurRadius: 25,
                      spreadRadius: 8,
                    )
                  ],
                  border: Border.all(color: warnaSkor, width: 8),
                ),
                child: Center(
                  child: Column(
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: [
                      Text(
                        "Skor",
                        style: GoogleFonts.fredoka(fontSize: 18, color: Colors.grey),
                      ),
                      Text(
                        "${skor.toInt()}", // Menampilkan skor
                        style: GoogleFonts.fredoka(
                          fontSize: 64, 
                          color: warnaSkor, 
                          fontWeight: FontWeight.bold
                        ),
                      ),
                    ],
                  ),
                ),
              ),

              const SizedBox(height: 60),

              // TOMBOL KEMBALI
              SizedBox(
                width: double.infinity,
                height: 55,
                child: ElevatedButton(
                  style: ElevatedButton.styleFrom(
                    backgroundColor: const Color(0xFF08A4A7),
                    shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(15)),
                    elevation: 5,
                  ),
                  onPressed: () => Navigator.pop(context),
                  child: Text(
                    "Kembali ke Dashboard",
                    style: GoogleFonts.fredoka(
                      color: Colors.white, 
                      fontSize: 18, 
                      fontWeight: FontWeight.w600
                    ),
                  ),
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }
}