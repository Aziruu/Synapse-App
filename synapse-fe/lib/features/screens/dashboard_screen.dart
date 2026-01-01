import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:synapse_app/shared/theme/app_colors.dart';
import '../../core/models/jadwal_model.dart';
import '../../core/models/pembiasaan_model.dart';

bool isTimePast(String endTimeStr) {
  final now = DateTime.now();
  final parts = endTimeStr.split(':');
  final endDateTime = DateTime(
    now.year,
    now.month,
    now.day,
    int.parse(parts[0]),
    int.parse(parts[1]),
  );
  return now.isAfter(endDateTime);
}

class DashboardScreen extends StatelessWidget {
  final Map<String, dynamic> userData;
  final VoidCallback onProfileTap;
  final VoidCallback onUlanganTap;
  final VoidCallback onJadwalTap;
  final VoidCallback onPembiasaanTap;

  const DashboardScreen({
    super.key,
    required this.userData,
    required this.onProfileTap,
    required this.onUlanganTap,
    required this.onJadwalTap,
    required this.onPembiasaanTap,
  });

  @override
  Widget build(BuildContext context) {
    final int hariIni = DateTime.now().weekday;

  final pembiasaanHariIni = masterPembiasaan.firstWhere(
    (p) => p.hari == hariIni,
    orElse: () => masterPembiasaan[0],
  );

    final jadwalAktif = masterJadwal
        .where((j) => j.hari == hariIni)
        .toList();

    return Scaffold(
      backgroundColor: const Color(0xFFFDFBF0),
      body: SafeArea(
        child: SingleChildScrollView(
          padding: const EdgeInsets.symmetric(horizontal: 25),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              _buildHeader(context),
              _buildSectionTitle("Pembiasaan"),
              GestureDetector(
                onTap: onPembiasaanTap,
                child: _buildBanner(
                  "${pembiasaanHariIni.judul}: ${pembiasaanHariIni.deskripsi}",
                  pembiasaanHariIni.imageAsset,
                ),
              ),
              const SizedBox(height: 25),
              _buildSectionTitle("Ulangan"),
              GestureDetector(
                onTap: onUlanganTap,
                child: _buildBannerUlangan(),
              ),
              const SizedBox(height: 25),
              _buildSectionTitle("Jadwal Pelajaran"),
              ...jadwalAktif.map((j) => GestureDetector(
                onTap: onJadwalTap,
                child:  _buildJadwalCard(j)
                )).toList(),
              const SizedBox(height: 30),
            ],
          ),
        ),
      ),
    );
  }

  // --- WIDGET HELPERS ---
  Widget _buildHeader(BuildContext context) {
    //  Ambil data avatar
    final String? avatarUrl = userData['avatar'];

    // Kita ambil kelas pertama dari array 'classes' yang dikirim Laravel
    final String className =
        (userData['classes'] != null && userData['classes'].isNotEmpty)
        ? userData['classes'][0]['class_name']
        : "Belum Ada Kelas";

    return GestureDetector(
      onTap: onProfileTap,
      child: Padding(
        padding: const EdgeInsets.symmetric(vertical: 25),
        child: Row(
          children: [
            // AVATAR DYNAMIC
            Container(
              decoration: BoxDecoration(
                shape: BoxShape.circle,
                border: Border.all(
                  color: AppColors.grey.withOpacity(0.2),
                  width: 2,
                ),
              ),
              child: CircleAvatar(
                radius: 28,
                backgroundColor: Colors.white,
                backgroundImage: avatarUrl != null && avatarUrl.isNotEmpty
                    ? NetworkImage(avatarUrl)
                    : const AssetImage('assets/images/avatar.png')
                          as ImageProvider,
              ),
            ),
            const SizedBox(width: 15),

            // INFO USER DINAMIS
            Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  userData['name'] ?? "User Empty",
                  style: GoogleFonts.fredoka(
                    fontWeight: FontWeight.bold,
                    fontSize: 18,
                    color: const Color(0xFF46494D),
                  ),
                ),
                const SizedBox(height: 2),
                Row(
                  children: [
                    Text(
                      className,
                      style: GoogleFonts.fredoka(
                        color: AppColors.grey,
                        fontSize: 13,
                      ),
                    ),
                    const SizedBox(width: 8),
                    _buildBadge(userData['role'] ?? "Siswa"),
                  ],
                ),
              ],
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildBadge(String role) {
    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 2),
      decoration: BoxDecoration(
        color: const Color(0xFF08A4A7),
        borderRadius: BorderRadius.circular(12),
      ),
      child: Text(
        role.toUpperCase(),
        style: GoogleFonts.fredoka(
          color: Colors.white,
          fontSize: 8,
          fontWeight: FontWeight.w600,
        ),
      ),
    );
  }

  Widget _buildSectionTitle(String title) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 15),
      child: Text(
        title,
        style: GoogleFonts.fredoka(
          fontWeight: FontWeight.w600,
          fontSize: 20,
          color: const Color(0xFF21004B),
        ),
      ),
    );
  }

  Widget _buildBanner(String text, String imagePath) {
    return Container(
      width: double.infinity,
      height: 180,
      decoration: BoxDecoration(
        color: Colors.grey.shade300,
        borderRadius: BorderRadius.circular(15),
      ),
      child: ClipRRect(
        borderRadius: BorderRadius.circular(15),
        child: Stack(
          children: [
            // GAMBAR BANNER
            Image.asset(
              imagePath,
              width: double.infinity,
              height: double.infinity,
              fit: BoxFit.cover,
              errorBuilder: (context, e, s) => Container(color: Colors.grey.shade300),
            ),
            // OVERLAY TEKS TEAL
            Align(
              alignment: Alignment.bottomCenter,
              child: Container(
                padding: const EdgeInsets.all(12),
                width: double.infinity,
                color: const Color(0xFF4DFED1).withOpacity(0.9),
                child: Text(
                  text,
                  style: GoogleFonts.fredoka(color: Colors.white, fontWeight: FontWeight.bold),
                ),
              ),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildBannerUlangan() {
    return ClipRRect(
      borderRadius: BorderRadius.circular(15),
      child: Image.asset(
        'assets/images/banner_ulangan.png',
        width: double.infinity,
        height: 100,
        fit: BoxFit.cover,
        errorBuilder: (context, error, stackTrace) {
          return Container(
            width: double.infinity,
            height: 100,
            color: Colors.grey.shade300,
            child: const Center(child: Icon(Icons.image, color: Colors.grey)),
          );
        },
      ),
    );
  }

  Widget _buildJadwalCard(Jadwal j) {
    const double cardHeight = 100.0;

    return Container(
      margin: const EdgeInsets.only(bottom: 12),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(8),
        boxShadow: [
          BoxShadow(
            color: Colors.grey.shade100,
            blurRadius: 4,
            offset: const Offset(0, 2),
          ),
        ],
      ),
      child: Row(
        children: [
          // --- BAGIAN GAMBAR ---
          ClipRRect(
            borderRadius: const BorderRadius.only(
              topLeft: Radius.circular(8),
              bottomLeft: Radius.circular(8),
            ),
            child: Image.asset(
              j.imageAsset,
              width: cardHeight,
              height: cardHeight,
              fit: BoxFit.cover,
              errorBuilder: (context, error, stackTrace) {
                // Placeholder kalau gambar gagal load/belum ada
                return Container(
                  width: cardHeight,
                  height: cardHeight,
                  color: Colors.grey.shade300,
                  child: const Icon(
                    Icons.image_not_supported,
                    color: Colors.grey,
                  ),
                );
              },
            ),
          ),

          // --- BAGIAN TEKS ---
          Expanded(
            child: Padding(
              padding: const EdgeInsets.symmetric(horizontal: 15, vertical: 12),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                mainAxisAlignment: MainAxisAlignment.center,
                children: [
                  Text(
                    j.subjek,
                    style: GoogleFonts.fredoka(
                      fontWeight: FontWeight.w600,
                      fontSize: 16,
                    ),
                    maxLines: 1,
                    overflow: TextOverflow.ellipsis,
                  ),
                  const SizedBox(height: 4),
                  Text(
                    j.guru,
                    style: GoogleFonts.fredoka(
                      color: const Color(0xFF08A4A7),
                      fontSize: 11,
                    ),
                    maxLines: 1,
                    overflow: TextOverflow.ellipsis,
                  ),
                  const SizedBox(height: 8),
                  Row(
                    children: [
                      const Icon(
                        Icons.access_time_rounded,
                        size: 14,
                        color: AppColors.secondaryLight,
                      ),
                      const SizedBox(width: 4),
                      Text(
                        "${j.jamMulai} - ${j.jamSelesai}",
                        style: GoogleFonts.fredoka(
                          fontSize: 12,
                          color: AppColors.secondaryLight,
                        ),
                      ),
                    ],
                  ),
                ],
              ),
            ),
          ),

          Padding(
            padding: const EdgeInsets.only(right: 15),
            child: Container(
              padding: const EdgeInsets.all(6),
              decoration: const BoxDecoration(
                color: Color(0xFF4DFED1),
                shape: BoxShape.circle,
              ),
              child: SvgPicture.asset(
                'assets/icons/arrow_next.svg',
                height: 25,
                colorFilter: const ColorFilter.mode(
                  Colors.white,
                  BlendMode.srcIn,
                ),
              ),
            ),
          ),
        ],
      ),
    );
  }
}
