import 'package:flutter/material.dart';
import 'package:synapse_app/features/screens/main_screen.dart';
import 'package:synapse_app/features/screens/splash_screen.dart';
import 'shared/theme/app_colors.dart';
import 'features/auth/login_screen.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:flutter/services.dart';

void main() {
  // Pastikan binding sudah siap sebelum panggil native code (SystemChrome)
  WidgetsFlutterBinding.ensureInitialized();

  // Aktifkan Mode Fokus (Immersive) agar navigasi & status bar HP tersembunyi
  SystemChrome.setEnabledSystemUIMode(SystemUiMode.immersiveSticky);

  runApp(const MainApp());
}

class MainApp extends StatelessWidget {
  const MainApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      debugShowCheckedModeBanner: false,
      title: 'Synapse App',
      
      // KONFIGURASI TEMA
      theme: ThemeData(
        textTheme: GoogleFonts.fredokaTextTheme(Theme.of(context).textTheme),
        primaryColor: AppColors.primaryDark,
        colorScheme: ColorScheme.fromSeed(
          seedColor: AppColors.primaryLight,
          primary: AppColors.secondaryLight,
        ),
        useMaterial3: true,
      ),

      // KONFIGURASI NAVIGASI (ROUTES)
      initialRoute: '/splash',
      routes: {
        '/splash': (context) => const SplashScreen(),
        '/login': (context) => LoginScreen(),
        
        '/home': (context) => MainScreen(),
      },
    );
  }
}