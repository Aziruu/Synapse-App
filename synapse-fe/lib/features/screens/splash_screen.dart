import 'dart:async';
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import '../../core/services/session_manager.dart';

class SplashScreen extends StatefulWidget {
  const SplashScreen({super.key});

  @override
  State<SplashScreen> createState() => _SplashScreenState();
}

class _SplashScreenState extends State<SplashScreen> {
  @override
  void initState() {
    super.initState();
    _initApp();
  }

  Future<void> _initApp() async {
    SystemChrome.setEnabledSystemUIMode(SystemUiMode.immersiveSticky);

    await Future.delayed(const Duration(seconds: 3));

    // 3. Cek apakah ada token di SharedPreferences
    final token = await SessionManager().getToken();

    if (mounted) {
      if (token != null) {
        // Jika sudah login, langsung ke Dashboard/Home
        Navigator.pushReplacementNamed(context, '/home');
      } else {
        // Jika belum login, arahkan ke Login
        Navigator.pushReplacementNamed(context, '/login');
      }
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.white,
      body: Center(
        child: FadeInImage(
          placeholder: const AssetImage('assets/images/logo_splash.png'),
          image: const AssetImage('assets/images/logo_splash.png'),
          width: 200,
          fadeInDuration: const Duration(milliseconds: 800),
        ),
      ),
    );
  }
}
