import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:synapse_app/shared/theme/app_colors.dart';
import 'dashboard_screen.dart';
import 'ulangan_screen.dart';
import 'profile_screen.dart';

class MainScreen extends StatefulWidget {
  final Map<String, dynamic> userData;
  const MainScreen({super.key, required this.userData});

  @override
  State<MainScreen> createState() => _MainScreenState();
}

class _MainScreenState extends State<MainScreen> {
  int _currentIndex = 0;

  @override
  Widget build(BuildContext context) {
    // List halaman yang akan ditampilkan
    final List<Widget> _screens = [
      DashboardScreen(userData: widget.userData),
      UlanganScreen(),
      const Center(child: Text("Halaman Jadwal Pelajaran")), // Placeholder
      const ProfileScreen(),
    ];

    return Scaffold(
      backgroundColor: AppColors.background,
      body: _screens[_currentIndex],
      bottomNavigationBar: _buildCustomNavbar(),
    );
  }

  Widget _buildCustomNavbar() {
    return Container(
      height: 80,
      decoration: const BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.only(
          topLeft: Radius.circular(20),
          topRight: Radius.circular(20),
        ),
      ),
      child: Row(
        children: [
          _navbarItem(0, 'home-icon.svg', 'Home'),
          _navbarItem(1, 'ulangan-icon.svg', 'Ulangan'),
          _navbarItem(2, 'jadwal-icon.svg', 'Jadwal'),
          _navbarItem(3, 'profile-icon.svg', 'Profil'),
        ],
      ),
    );
  }

  Widget _navbarItem(int index, String iconName, String label) {
    bool isSelected = _currentIndex == index;

    return Expanded(
      child: InkWell(
        onTap: () => setState(() => _currentIndex = index),
        child: Container(
          // Efek blok warna saat dipilih sesuai desain
          color: isSelected ? AppColors.primaryLight : Colors.transparent,
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              SvgPicture.asset(
                'assets/icons/$iconName', // Sesuai nama file di image_82c916
                height: 24,
                colorFilter: ColorFilter.mode(
                  isSelected ? Colors.white : AppColors.primaryLight,
                  BlendMode.srcIn,
                ),
              ),
              const SizedBox(height: 4),
              Text(
                label,
                style: GoogleFonts.fredoka(
                  fontSize: 12,
                  fontWeight: FontWeight.w600,
                  color: isSelected ? Colors.white : AppColors.primaryLight,
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }
}