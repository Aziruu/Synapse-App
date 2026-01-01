import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:synapse_app/features/screens/jadwal_page.dart';
import 'package:synapse_app/features/screens/pembiasaan_page.dart';
import 'package:synapse_app/shared/theme/app_colors.dart';
import '../../core/services/api_service.dart';
import 'dashboard_screen.dart';
import 'ulangan_screen.dart';
import 'profile_screen.dart';

class MainScreen extends StatefulWidget {
  final Map<String, dynamic>? userData;
  const MainScreen({super.key, this.userData});

  @override
  State<MainScreen> createState() => _MainScreenState();
}

class _MainScreenState extends State<MainScreen> {
  int _currentIndex = 0;
  Map<String, dynamic>? _currentUserData;
  bool _isLoading = true;

  @override
  void initState() {
    super.initState();
    if (widget.userData != null) {
      _currentUserData = widget.userData;
      _isLoading = false;
    } else {
      _fetchProfile();
    }
  }

  Future<void> _fetchProfile() async {
    try {
      final data = await ApiService().getProfile();
      setState(() {
        _currentUserData = data;
        _isLoading = false;
      });
    } catch (e) {
      setState(() => _isLoading = false);
    }
  }

  void _onTabChange(int index) {
    setState(() {
      _currentIndex = index;
    });
  }

  @override
  Widget build(BuildContext context) {
    if (_isLoading) {
      return const Scaffold(
        body: Center(
          child: CircularProgressIndicator(color: AppColors.secondaryLight),
        ),
      );
    }

    final List<Widget> _screens = [
      DashboardScreen(
        userData: _currentUserData ?? {},
        onProfileTap: () => _onTabChange(3),
        onUlanganTap: () => _onTabChange(1),
        onJadwalTap: () => _onTabChange(2),
        onPembiasaanTap: () => Navigator.push(
          context,
          MaterialPageRoute(builder: (context) => const PembiasaanPage()),
        ),
      ),
      UlanganScreen(onBackToHome: () => _onTabChange(0)),
      JadwalPage(onBackToHome: () => _onTabChange(0)),
      ProfileScreen(onBackToHome: () => _onTabChange(0)),
    ];

    return Scaffold(
      backgroundColor: AppColors.background,
      body: _screens[_currentIndex],
      bottomNavigationBar: _buildCustomNavbar(),
    );
  }

  // --- WIDGET NAVBAR  ---
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
        onTap: () => _onTabChange(index),
        child: Container(
          color: isSelected ? AppColors.primaryLight : Colors.transparent,
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              SvgPicture.asset(
                'assets/icons/$iconName',
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
