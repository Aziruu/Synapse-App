import 'dart:io';
import 'package:flutter/foundation.dart' show kIsWeb;

class ApiConfig {
  static String get baseUrl {
    if (kIsWeb) {
      // Jika ngetes lewat Browser
      return "http://127.0.0.1:8000/api";
    } else if (Platform.isAndroid) {
      // Jika ngetes pakai Android Emulator
      // 10.0.2.2 adalah alamat khusus emulator buat nembak localhost laptop
      return "http://10.0.2.2:8000/api";
    } else if (Platform.isIOS) {
      return "http://127.0.0.1:8000/api";
    } else {
      // Jika pakai HP Fisik, harus ganti ke IP Laptop
      return "http://192.168.1.7:8000/api"; 
    }
  }
}