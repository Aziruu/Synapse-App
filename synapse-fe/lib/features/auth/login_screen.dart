import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:synapse_app/features/screens/main_screen.dart';
import '../../../core/services/api_service.dart';
import '../../../core/services/session_manager.dart';

class LoginScreen extends StatefulWidget {
  @override
  _LoginScreenState createState() => _LoginScreenState();
}

class _LoginScreenState extends State<LoginScreen> {
  final TextEditingController _emailController = TextEditingController();
  final TextEditingController _passwordController = TextEditingController();
  bool _isLoading = false;

  void _handleLogin() async {
    setState(() => _isLoading = true);
    try {
      final result = await ApiService().login(
        _emailController.text,
        _passwordController.text,
      );
      if (result['status'] == 'success') {
        await SessionManager().saveToken(result['token']);
        if (mounted) {
          ScaffoldMessenger.of(context).showSnackBar(
            SnackBar(
              content: Text("Selamat Datang, ${result['user']['name']}!"),
            ),
          );
          Navigator.pushReplacement(
            context,
            MaterialPageRoute(
              builder: (context) => MainScreen(userData: result['user']),
            ),
          );
        }
      }
    } catch (e) {
      if (mounted) {
        ScaffoldMessenger.of(
          context,
        ).showSnackBar( SnackBar(content: Text("Login Gagal!")));
      }
    } finally {
      if (mounted) setState(() => _isLoading = false);
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFFDFBF0),
      body: Stack(
        children: [
          // 1. Teal Header Area
          Container(
            height: MediaQuery.of(context).size.height * 0.48,
            width: double.infinity,
            decoration: const BoxDecoration(
              color: Color(0xFF4DFED1),
              borderRadius: BorderRadius.only(
                bottomLeft: Radius.circular(25),
                bottomRight: Radius.circular(25),
              ),
            ),
          ),

          // 2. Konten Scrollable
          SingleChildScrollView(
            child: Column(
              children: [
                const SizedBox(height: 180),
                // 3. White Card
                Container(
                  margin: const EdgeInsets.symmetric(horizontal: 40),
                  padding: const EdgeInsets.symmetric(
                    horizontal: 30,
                    vertical: 40,
                  ),
                  decoration: BoxDecoration(
                    color: Colors.white,
                    borderRadius: BorderRadius.circular(25),
                  ),
                  child: Column(
                    children: [
                      Text(
                        "Sign In",
                        style: GoogleFonts.fredoka(
                          fontSize: 28,
                          fontWeight: FontWeight.w600,
                          color: const Color(0xFF21004B),
                        ),
                      ),
                      const SizedBox(height: 30),

                      // Email Field
                      _buildInputField(
                        label: "Email / NIS :",
                        hint: "0071120312",
                        controller: _emailController,
                        icon: Icons.person,
                      ),
                      const SizedBox(height: 20),

                      // Password Field
                      _buildInputField(
                        label: "Password :",
                        hint: "********",
                        controller: _passwordController,
                        icon: Icons.visibility_outlined,
                        isPassword: true,
                      ),
                      const SizedBox(height: 25),

                      // Tombol Sign In
                      SizedBox(
                        width: double.infinity,
                        height: 40,
                        child: ElevatedButton(
                          style: ElevatedButton.styleFrom(
                            backgroundColor: const Color(0xFF08A4A7),
                            shape: RoundedRectangleBorder(
                              borderRadius: BorderRadius.circular(25),
                            ),
                          ),
                          onPressed: _isLoading ? null : _handleLogin,
                          child: _isLoading
                              ? const SizedBox(
                                  height: 20,
                                  width: 20,
                                  child: CircularProgressIndicator(
                                    color: Colors.white,
                                    strokeWidth: 2,
                                  ),
                                )
                              : Text(
                                  "Sign In",
                                  style: GoogleFonts.fredoka(
                                    color: Colors.white,
                                    fontSize: 16,
                                    fontWeight: FontWeight.w600, // SemiBold
                                  ),
                                ),
                        ),
                      ),
                      const SizedBox(height: 15),

                      // Forgot Password
                      Text(
                        "Forgot your password?",
                        style: GoogleFonts.fredoka(
                          color: const Color(0xFF4DFED1),
                          fontSize: 12,
                          fontWeight: FontWeight.w600,
                        ),
                      ),
                    ],
                  ),
                ),

                const SizedBox(height: 30),
                Text(
                  "Or",
                  style: GoogleFonts.fredoka(
                    color: Colors.grey,
                    fontSize: 14,
                    fontWeight: FontWeight.w500,
                  ),
                ),
                const SizedBox(height: 20),

                //  Google Pill Button
                Container(
                  margin: const EdgeInsets.symmetric(horizontal: 40),
                  width: double.infinity,
                  height: 50,
                  decoration: BoxDecoration(
                    color: Colors.white,
                    borderRadius: BorderRadius.circular(50),
                  ),
                  child: Row(
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: [
                      Image.asset('assets/images/google_logo.png', height: 100),
                    ],
                  ),
                ),

                const SizedBox(height: 30),
                // Sign Up Row
                Row(
                  mainAxisAlignment: MainAxisAlignment.center,
                  children: [
                    Text(
                      "Don't have an account? ",
                      style: GoogleFonts.fredoka(
                        color: Colors.grey,
                        fontSize: 13,
                        fontWeight: FontWeight.w500,
                      ),
                    ),
                    Text(
                      "Sign up",
                      style: GoogleFonts.fredoka(
                        color: const Color(0xFF4DFED1),
                        fontSize: 13,
                        fontWeight: FontWeight.w600,
                      ),
                    ),
                  ],
                ),
                const SizedBox(height: 50),
              ],
            ),
          ),
        ],
      ),
    );
  }

  // Input Field Helper (Presisi Underline)
  Widget _buildInputField({
    required String label,
    required String hint,
    required TextEditingController controller,
    required IconData icon,
    bool isPassword = false,
  }) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text(
          label,
          style: GoogleFonts.fredoka(
            fontSize: 14,
            fontWeight: FontWeight.w600, // SemiBold
            color: const Color(0xFF21004B),
          ),
        ),
        TextField(
          controller: controller,
          obscureText: isPassword,
          style: GoogleFonts.fredoka(fontSize: 14),
          decoration: InputDecoration(
            isDense: true,
            hintText: hint,
            hintStyle: GoogleFonts.fredoka(
              color: Colors.grey.shade300,
              fontSize: 14,
            ),
            suffixIcon: Icon(icon, color: Colors.grey.shade400, size: 20),
            enabledBorder: const UnderlineInputBorder(
              borderSide: BorderSide(color: Colors.grey, width: 0.8),
            ),
            focusedBorder: const UnderlineInputBorder(
              borderSide: BorderSide(color: Color(0xFF4DFED1), width: 1.5),
            ),
            contentPadding: const EdgeInsets.symmetric(vertical: 8),
          ),
        ),
      ],
    );
  }
}
