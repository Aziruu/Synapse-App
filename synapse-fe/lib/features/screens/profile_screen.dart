import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:synapse_app/shared/theme/app_colors.dart'; // Import library buatanmu
import '../../core/services/api_service.dart';
import '../../core/services/session_manager.dart';

class ProfileScreen extends StatefulWidget {
  final VoidCallback onBackToHome;

  const ProfileScreen({super.key, required this.onBackToHome});

  @override
  _ProfileScreenState createState() => _ProfileScreenState();
}

class _ProfileScreenState extends State<ProfileScreen> {
  Map<String, dynamic>? user;
  bool _isLoading = true;

  // Ambil dark-gray yang kamu kasih tadi
  final Color darkGray = const Color(0xFF46494D);

  @override
  void initState() {
    super.initState();
    _fetchProfile();
  }

  Future<void> _fetchProfile() async {
    try {
      final data = await ApiService().getProfile();
      setState(() {
        user = data;
        _isLoading = false;
      });
    } catch (e) {
      setState(() => _isLoading = false);
    }
  }

  void _showLogoutConfirmation() {
    showDialog(
      context: context,
      builder: (context) => AlertDialog(
        backgroundColor: AppColors.white,
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(15)),
        title: Text(
          "Konfirmasi Keluar",
          style: GoogleFonts.fredoka(
            fontWeight: FontWeight.bold,
            color: darkGray,
          ),
        ),
        content: Text(
          "Apakah kamu yakin ingin keluar dari akun Synapse?",
          style: GoogleFonts.fredoka(color: darkGray),
        ),
        actions: [
          TextButton(
            onPressed: () => Navigator.pop(context),
            child: Text(
              "Batal",
              style: GoogleFonts.fredoka(color: AppColors.grey),
            ),
          ),
          ElevatedButton(
            style: ElevatedButton.styleFrom(backgroundColor: Colors.redAccent),
            onPressed: () async {
              await SessionManager().removeToken();

              if (mounted) {
                //Tutup dialognya dulu (biar bersih)
                Navigator.of(context, rootNavigator: true).pop();

                Navigator.pushNamedAndRemoveUntil(
                  context,
                  '/login',
                  (route) => false,
                );
              }
            },
            child: Text(
              "Keluar",
              style: GoogleFonts.fredoka(color: AppColors.white),
            ),
          ),
        ],
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppColors.background,
      body: _isLoading
          ? const Center(
              child: CircularProgressIndicator(color: AppColors.secondaryLight),
            )
          : SingleChildScrollView(
              child: Padding(
                padding: const EdgeInsets.symmetric(horizontal: 25),
                child: Column(
                  children: [
                    const SizedBox(height: 60),
                    // HEADER SECTION
                    Row(
                      children: [
                        IconButton(
                          icon: Icon(
                            Icons.arrow_back_ios_new,
                            color: darkGray,
                            size: 20,
                          ),
                          onPressed: widget.onBackToHome,
                        ),
                        Expanded(
                          child: Text(
                            "Profile",
                            textAlign: TextAlign.center,
                            style: GoogleFonts.fredoka(
                              fontSize: 22,
                              fontWeight: FontWeight.w600,
                              color: darkGray,
                            ),
                          ),
                        ),
                        const SizedBox(width: 40),
                      ],
                    ),
                    const SizedBox(height: 40),

                    // LOGIKA FOTO PROFIL
                    _buildAvatar(),

                    const SizedBox(height: 20),
                    Text(
                      user?['name'] ?? "User Empty",
                      style: GoogleFonts.fredoka(
                        fontSize: 24,
                        fontWeight: FontWeight.bold,
                        color: darkGray,
                      ),
                    ),
                    const SizedBox(height: 10),
                    _buildUserTag(),
                    const SizedBox(height: 50),

                    // MENU BUTTONS
                    _buildProfileButton(
                      "Info Detail",
                      AppColors.white,
                      darkGray,
                    ),
                    const SizedBox(height: 15),
                    _buildProfileButton(
                      "Sign Out",
                      const Color(0xFFFF3B3B),
                      AppColors.white,
                      isLogout: true,
                    ),
                  ],
                ),
              ),
            ),
    );
  }

  Widget _buildAvatar() {
    // Cek apakah ada data avatar di database
    final String? avatarUrl = user?['avatar'];

    return Container(
      decoration: BoxDecoration(
        shape: BoxShape.circle,
        border: Border.all(color: AppColors.grey.withOpacity(0.3), width: 4),
      ),
      child: CircleAvatar(
        radius: 80,
        backgroundColor: AppColors.white,
        backgroundImage: avatarUrl != null && avatarUrl.isNotEmpty
            ? NetworkImage(avatarUrl) // Jika ada di DB
            : const AssetImage('assets/images/avatar.png')
                  as ImageProvider, // Fallback
      ),
    );
  }

  Widget _buildUserTag() {
    return Row(
      mainAxisAlignment: MainAxisAlignment.center,
      children: [
        Text(
          user?['classes']?.isNotEmpty == true
              ? user!['classes'][0]['class_name']
              : "Tidak Ada Kelas",
          style: GoogleFonts.fredoka(
            fontSize: 18,
            fontWeight: FontWeight.w600,
            color: darkGray.withOpacity(0.7),
          ),
        ),
        const SizedBox(width: 10),
        Container(
          padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 4),
          decoration: BoxDecoration(
            color: AppColors.secondaryLight,
            borderRadius: BorderRadius.circular(20),
          ),
          child: Text(
            "Siswa",
            style: GoogleFonts.fredoka(color: AppColors.white, fontSize: 12),
          ),
        ),
      ],
    );
  }

  Widget _buildProfileButton(
    String label,
    Color bgColor,
    Color textColor, {
    bool isLogout = false,
  }) {
    return SizedBox(
      width: double.infinity,
      height: 65,
      child: ElevatedButton(
        style: ElevatedButton.styleFrom(
          backgroundColor: bgColor,
          elevation: isLogout ? 0 : 1,
          shape: RoundedRectangleBorder(
            borderRadius: BorderRadius.circular(15),
          ),
        ),
        onPressed: isLogout
            ? _showLogoutConfirmation
            : () {
                // Navigasi ke page info/password nanti
              },
        child: Text(
          label,
          style: GoogleFonts.fredoka(
            fontSize: 18,
            fontWeight: FontWeight.bold,
            color: textColor,
          ),
        ),
      ),
    );
  }
}
