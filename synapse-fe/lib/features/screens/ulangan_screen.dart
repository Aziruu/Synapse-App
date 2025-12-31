import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:synapse_app/features/screens/hasil_ujian_page.dart';
import '../../core/services/api_service.dart';
import 'ujian_page.dart';
import 'package:flutter_svg/flutter_svg.dart';

class UlanganScreen extends StatefulWidget {
  @override
  _UlanganScreenState createState() => _UlanganScreenState();
}

class _UlanganScreenState extends State<UlanganScreen> {
  bool isDikerjakan = true;
  bool _isLoading = true;
  List<dynamic> _exams = [];

  @override
  void initState() {
    super.initState();
    _fetchExams();
  }

  Future<void> _fetchExams() async {
    try {
      final data = await ApiService().getExams();
      setState(() {
        _exams = data;
        _isLoading = false;
      });
    } catch (e) {
      setState(() => _isLoading = false);
    }
  }

  @override
  Widget build(BuildContext context) {
    // Filter data berdasarkan status 'finished' dari database
    final listTampil = _exams.where((u) {
      if (isDikerjakan) {
        return u['status'] != 'finished';
      } else {
        return u['status'] == 'finished';
      }
    }).toList();

    return Scaffold(
      backgroundColor: const Color(0xFFFDFBF0),
      body: Column(
        children: [
          _buildHeader(),
          _buildTabs(),
          Expanded(
            child: _isLoading
                ? const Center(
                    child: CircularProgressIndicator(color: Color(0xFF4DFED1)),
                  )
                : listTampil.isEmpty
                ? Center(
                    child: Text(
                      "Belum ada data ujian",
                      style: GoogleFonts.fredoka(),
                    ),
                  )
                : RefreshIndicator(
                    onRefresh: _fetchExams,
                    child: ListView.builder(
                      padding: const EdgeInsets.symmetric(horizontal: 25),
                      itemCount: listTampil.length,
                      itemBuilder: (context, index) =>
                          _buildUlanganCard(listTampil[index]),
                    ),
                  ),
          ),
        ],
      ),
    );
  }

  // --- HEADER DENGAN TOMBOL BACK ---
  Widget _buildHeader() {
    return Container(
      padding: const EdgeInsets.only(top: 50, bottom: 20),
      width: double.infinity,
      color: const Color(0xFF4DFED1),
      child: Stack(
        children: [
          Align(
            alignment: Alignment.centerLeft,
            child: Padding(
              padding: const EdgeInsets.only(left: 10),
              child: IconButton(
                icon: const Icon(
                  Icons.arrow_back_ios_new,
                  color: Colors.white,
                  size: 22,
                ),
                onPressed: () => Navigator.pop(context),
              ),
            ),
          ),
          Center(
            child: Text(
              "Ulangan",
              style: GoogleFonts.fredoka(
                color: Colors.white,
                fontSize: 24,
                fontWeight: FontWeight.w600,
              ),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildTabs() {
    return Padding(
      padding: const EdgeInsets.symmetric(horizontal: 25, vertical: 25),
      child: Row(
        children: [
          _buildTabButton("Dikerjakan", isDikerjakan),
          const SizedBox(width: 15),
          _buildTabButton("Selesai", !isDikerjakan),
        ],
      ),
    );
  }

  Widget _buildTabButton(String label, bool isActive) {
    return Expanded(
      child: GestureDetector(
        onTap: () => setState(() => isDikerjakan = (label == "Dikerjakan")),
        child: Container(
          height: 45,
          decoration: BoxDecoration(
            color: isActive
                ? const Color(0xFF4DFED1)
                : const Color(0xFF08A4A7).withOpacity(0.8),
            borderRadius: BorderRadius.circular(8),
          ),
          child: Center(
            child: Text(
              label,
              style: GoogleFonts.fredoka(
                color: Colors.white,
                fontWeight: FontWeight.w600,
              ),
            ),
          ),
        ),
      ),
    );
  }

  // --- CARD UI DENGAN TOMBOL TEAL & ICON PUTIH (image_75b58c.png) ---
  Widget _buildUlanganCard(dynamic u) {
    bool isFinished = u['status'] == 'finished';

    return Container(
      margin: const EdgeInsets.only(bottom: 20),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(15),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.05),
            blurRadius: 10,
            offset: const Offset(0, 5),
          ),
        ],
      ),
      child: IntrinsicHeight(
        child: Row(
          children: [
            Expanded(
              flex: 7,
              child: Padding(
                padding: const EdgeInsets.all(20),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Text(
                      u['title'] ?? 'Ulangan Harian',
                      style: GoogleFonts.fredoka(
                        fontSize: 18,
                        fontWeight: FontWeight.w600,
                        color: const Color(0xFF08A4A7),
                      ),
                    ),
                    const SizedBox(height: 5),
                    Text(
                      "Senin, 30 Des 2025",
                      style: GoogleFonts.fredoka(
                        color: Colors.grey.shade500,
                        fontSize: 13,
                      ),
                    ),
                    const SizedBox(height: 15),
                    Row(
                      children: [
                        // BADGE STATUS
                        Container(
                          padding: const EdgeInsets.symmetric(
                            horizontal: 12,
                            vertical: 4,
                          ),
                          decoration: BoxDecoration(
                            color: isFinished
                                ? const Color(0xFF4DFED1)
                                : const Color(0xFF6E85E8),
                            borderRadius: BorderRadius.circular(20),
                          ),
                          child: Text(
                            isFinished ? "Selesai" : "Berlangsung",
                            style: GoogleFonts.fredoka(
                              color: Colors.white,
                              fontSize: 11,
                            ),
                          ),
                        ),
                        const SizedBox(width: 10),
                        Text(
                          "Pukul : 08.00 - 10.00",
                          style: GoogleFonts.fredoka(
                            color: Colors.grey.shade400,
                            fontSize: 11,
                          ),
                        ),
                      ],
                    ),
                  ],
                ),
              ),
            ),
            // TOMBOL
            Container(
              width: 75,
              decoration: const BoxDecoration(
                color: Color(0xFF08A4A7),
                borderRadius: BorderRadius.only(
                  topRight: Radius.circular(15),
                  bottomRight: Radius.circular(15),
                ),
              ),
              child: Material(
                color: Colors.transparent,
                child: InkWell(
                  borderRadius: const BorderRadius.only(
                    topRight: Radius.circular(15),
                    bottomRight: Radius.circular(15),
                  ),
                  onTap: () {
                    if (isFinished) {
                      Navigator.push(
                        context,
                        MaterialPageRoute(
                          builder: (context) => HasilUjianPage(
                            skor: (u['score'] as num).toDouble(),
                            mapel: u['title'] ?? 'Ujian',
                          ),
                        ),
                      );
                    } else {
                      _showTokenDialog(context, u);
                    }
                  },
                  child: Center(
                    child: SvgPicture.asset(
                      'assets/icons/arrow_next.svg',
                      height: 30,
                      colorFilter: const ColorFilter.mode(
                        Colors.white,
                        BlendMode.srcIn,
                      ),
                    ),
                  ),
                ),
              ),
            ),
          ],
        ),
      ),
    );
  }

  void _showTokenDialog(BuildContext context, dynamic u) {
    TextEditingController tokenController = TextEditingController();
    showDialog(
      context: context,
      builder: (context) => AlertDialog(
        title: Text("Token Ujian", style: GoogleFonts.fredoka()),
        content: TextField(
          controller: tokenController,
          decoration: const InputDecoration(hintText: "Contoh: MTK123"),
        ),
        actions: [
          TextButton(
            onPressed: () => Navigator.pop(context),
            child: const Text("Batal"),
          ),
          ElevatedButton(
            onPressed: () async {
              try {
                final result = await ApiService().joinExam(
                  tokenController.text,
                );
                Navigator.pop(context);
                Navigator.push(
                  context,
                  MaterialPageRoute(
                    builder: (context) => UjianPage(
                      ulanganId: (result['exam']['id'] as num).toInt(),
                      mapel: u['title'] ?? 'Ujian',
                    ),
                  ),
                ).then((_) => _fetchExams());
              } catch (e) {
                ScaffoldMessenger.of(
                  context,
                ).showSnackBar(SnackBar(content: Text(e.toString())));
              }
            },
            child: const Text("Mulai"),
          ),
        ],
      ),
    );
  }
}
