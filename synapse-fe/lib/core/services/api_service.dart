import 'dart:convert';
import 'package:http/http.dart' as http;
import '../models/soal_model.dart';
import 'session_manager.dart';

class ApiService {
  static const String baseUrl = 'https://crack-hawk-humbly.ngrok-free.app/api';

  //  Fungsi Login
  Future<Map<String, dynamic>> login(String email, String password) async {
    final response = await http.post(
      Uri.parse('$baseUrl/login'),
      headers: {'Accept': 'application/json'},
      body: {'email': email, 'password': password},
    );

    if (response.statusCode == 200) {
      return jsonDecode(response.body);
    } else {
      throw Exception('Gagal login, cek koneksi atau datamu!');
    }
  }

  //  Fungsi Ambil Soal
  Future<List<Soal>> getSoal(int ulanganId) async {
    final token = await SessionManager().getToken();
    final response = await http.get(
      Uri.parse('$baseUrl/ulangan/$ulanganId/soal'),
      headers: {
        'Authorization': 'Bearer $token',
        'Accept': 'application/json',
        'ngrok-skip-browser-warning': 'true',
      },
    );

    if (response.statusCode == 200) {
      final decoded = json.decode(response.body);
      List data = decoded['data'];
      return data.map((item) => Soal.fromJson(item)).toList();
    } else {
      throw Exception("Gagal mengambil soal ujian: ${response.statusCode}");
    }
  }

  Future<List<dynamic>> getExams() async {
    final token = await SessionManager().getToken();
    final response = await http.get(
      Uri.parse('$baseUrl/exams'),
      headers: {
        'Authorization': 'Bearer $token',
        'Accept': 'application/json',
        'ngrok-skip-browser-warning': 'true',
      },
    );

    if (response.statusCode == 200) {
      return json.decode(response.body);
    } else {
      throw Exception("Gagal mengambil daftar ujian");
    }
  }

  Future<bool> submitJawaban(int ulanganId, Map<int, String> jawaban) async {
    final token = await SessionManager().getToken();

    // Convert key int ke String
    Map<String, String> formattedJawaban = jawaban.map(
      (k, v) => MapEntry(k.toString(), v),
    );

    try {
      final response = await http.post(
        Uri.parse('$baseUrl/ulangan/$ulanganId/submit'),
        headers: {
          'Authorization': 'Bearer $token',
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'ngrok-skip-browser-warning': 'true',
        },
        body: json.encode({'jawaban': formattedJawaban}),
      );

      print("Body Balasan: ${response.body}");
      return response.statusCode == 200;
    } catch (e) {
      return false;
    }
  }

  //  Fungsi Join Ujian via Token
  Future<Map<String, dynamic>> joinExam(String token) async {
    final authToken = await SessionManager().getToken();
    final response = await http.post(
      Uri.parse('$baseUrl/join-exam'),
      headers: {
        'Authorization': 'Bearer $authToken',
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'ngrok-skip-browser-warning': 'true',
      },
      body: json.encode({'token': token}),
    );

    final decoded = json.decode(response.body);
    if (response.statusCode == 200) {
      return decoded;
    } else {
      throw Exception(
        decoded['message'] ?? "Token salah atau ujian belum mulai",
      );
    }
  }

  //  Fungsi profile
  Future<Map<String, dynamic>> getProfile() async {
    final token = await SessionManager().getToken();
    final response = await http.get(
      Uri.parse('$baseUrl/me'),
      headers: {
        'Authorization': 'Bearer $token',
        'Accept': 'application/json',
        'ngrok-skip-browser-warning': 'true',
      },
    );

    if (response.statusCode == 200) {
      return json.decode(response.body);
    } else {
      throw Exception("Gagal memuat profil");
    }
  }
}
