<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>QR Attendance Scanner</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0; padding: 0;
      background: #f4f4f9;
      color: #333;
    }
    header {
      background: #2c3e50;
      color: white;
      padding: 15px;
      text-align: center;
    }
    .scanner-container {
      padding: 20px;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 20px;
    }
    video {
      width: 100%;
      max-width: 400px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    }
    input {
      padding: 10px;
      width: 100%;
      max-width: 400px;
      border: 1px solid #ccc;
      border-radius: 8px;
    }
    .response-box {
      background: white;
      border-radius: 8px;
      padding: 15px;
      width: 100%;
      max-width: 400px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }
    .response-box h3 {
      margin: 0 0 10px;
      font-size: 18px;
      color: #2c3e50;
    }
    .list-presensi {
      margin-top: 20px;
      width: 100%;
      max-width: 500px;
    }
    .list-presensi h3 {
      margin-bottom: 10px;
    }
    .list-presensi ul {
      list-style: none;
      padding: 0;
    }
    .list-presensi li {
      background: #fff;
      padding: 10px;
      margin-bottom: 8px;
      border-radius: 6px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.15);
    }
  </style>
</head>
<body>

<header>
  <h1>Guest Attendance Scanner</h1>
</header>

<div class="scanner-container">
  <!-- Camera preview -->
  <video id="preview" autoplay playsinline></video>

  <!-- Manual input -->
  <input type="text" id="manualInput" placeholder="Masukkan kode tamu secara manual" />

  <!-- Response -->
  <div class="response-box" id="responseBox">
    <h3>Data Tamu</h3>
    <p id="responseData">Belum ada data</p>
  </div>

  <!-- List presensi -->
  <div class="list-presensi">
    <h3>Daftar Presensi</h3>
    <ul id="attendanceList"></ul>
  </div>
</div>

<script>
  const video = document.getElementById('preview');
  const manualInput = document.getElementById('manualInput');
  const responseData = document.getElementById('responseData');
  const attendanceList = document.getElementById('attendanceList');

  // Start camera
  async function startCamera() {
    try {
      const stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } });
      video.srcObject = stream;
    } catch (err) {
      console.error("Cannot access camera:", err);
      responseData.innerText = "Gagal mengakses kamera.";
    }
  }

  startCamera();

  // Fake QR reading simulation (nanti bisa ganti dengan jsQR atau library lain)
  function processCode(code) {
    if (!code) return;
    fetch('/my-guests-attendant', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ code })
    })
    .then(res => res.json())
    .then(data => {
      responseData.innerText = `Nama: ${data.name}\nStatus: ${data.status}`;
      const li = document.createElement('li');
      li.innerText = `${data.name} - ${data.status}`;
      attendanceList.prepend(li);
    })
    .catch(err => {
      console.error(err);
      responseData.innerText = "Error membaca data tamu.";
    });
  }

  // Handle manual input
  manualInput.addEventListener('keyup', (e) => {
    if (e.key === 'Enter') {
      processCode(e.target.value);
      e.target.value = "";
    }
  });
</script>

</body>
</html>
