<!DOCTYPE html>
<html>
<head>
    <title>QR Code Generated</title>
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
  <h1>QR Code Generated</h1>
  <p>QR code link has been generated successfully:</p>
  <p>QR Code Link: <a href="{{ $link }}" target="_blank">CEK VERIFIKASI</a></p>
  <p>QR Code Image:</p>
  <img id="qr-code" src="https://api.qrserver.com/v1/create-qr-code/?data={{ $qr_link }}&amp;size=300x300" alt="" title="" />
  <button onclick="downloadQR()">Download QR Code</button>
</div>

    <!-- Add Bootstrap JS and jQuery scripts (optional) -->
    <!-- These are optional but required if you want to use Bootstrap's JavaScript components -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
function downloadQR() {
  var qrCode = document.getElementById("qr-code");
  var url = qrCode.src.replace(/^data:image\/[^;]/, 'data:application/octet-stream');
  var fileName = "qr-code.png";
  var link = document.createElement("a");
  link.download = fileName;
  link.href = url;
  link.click();
}
</script>
</body>
</html>
