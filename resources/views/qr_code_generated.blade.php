    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{asset('css/qr.css') }}">
<body>
<div class="table" id="card-qr">
  <div class="table-cell">
    <div id="ticket">
        <div class="row perforated first">
            <img class="logo" src="{{asset('img/logo_ptpn5.png') }}" />
                <div class="title" style="
            position: absolute;
            left: 20%;
            top: 40%;
            font-weight: bold;
            text-align: center;
            ">KARTU VERIFIKASI KENDARAAN
                </div>
        </div>
      <div class="row perforated destinations">
        <div class="left">
          <div class="label">Nomor Polisi</div>
          <div class="airport">{{$nopol}}</div>
          <div class="city">Riau</div>
        </div>

        <img id="plane" src="{{asset('img/logo_ptpn5.png')}}" version="1.1" x="0px" y="0px" viewBox="0 0 100 125" enable-background="new 0 0 100 100" xml:space="preserve">
        </img>
        <div class="col6">
          <div class="label" style="
    margin-left: 98px;
    margin-top: 50px;
    color: #0065aa;
    font-size: 10;
    font-weight: bolder; opacity:0.6; ">SIMOGA</div>
        </div>

      </div>
      <div class="row normRow">
        <div>
          <div class="label">Pemasok</div>
          <div class="col">{{$pemasok}}</div>
        </div>
        
      </div>
      <div class="row normRow">
        <div class="col6">
          <div class="label" style="font-size: large;">Diterbitkan :</div>
          <div class="countdown" id="diterbitkanPada">---</div>
        </div>
        <div class="col6">
          <div class="label">QR CODE :</div>
        </div>
      </div>
      <div class="row">
        <!-- <div class="sparkler">kartu ini harus dibawa saat melakukan penimbangan<</div> -->
      <img id="qr" src='' alt=''>
      </div>
      <div class="row normRow smalltext">kartu ini harus dibawa saat melakukan penimbangan</div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>

    function getCurrentTimestamp() {
      const now = new Date();
      const year = now.getFullYear();
      const month = String(now.getMonth() + 1).padStart(2, '0');
      const day = String(now.getDate()).padStart(2, '0');


      return `${day}-${month}-${year}`;
    }

    // Set the "Diterbitkan Pada" date to the current timestamp when the page loads
    document.addEventListener('DOMContentLoaded', function () {
      const diterbitkanPadaElement = document.getElementById('diterbitkanPada');
      diterbitkanPadaElement.textContent = getCurrentTimestamp();
    });

    window.addEventListener("load", function() {
            let element = document.getElementById('ticket');
            let opt = {
                margin:       3,
                filename:     'Verifikasi Kendaraan {{$nopol}}||{{$pemasok}}.pdf',
                image:        { type: 'jpeg', quality: 1 },
                html2canvas:  { scale: 5, height: 1000 },
                jsPDF:        { format: 'letter', orientation: 'portrait' }
            };
            html2pdf().set(opt).from(element).save();
      });

      function convertImgToBase64(url, callback) {
                var canvas = document.createElement('canvas');
                var ctx = canvas.getContext('2d');
                var img = new Image();
                img.crossOrigin = 'Anonymous';
                img.onload = function () {
                    canvas.width = img.width;
                    canvas.height = img.height;
                    ctx.drawImage(img, 0, 0);
                    var dataURL = canvas.toDataURL();
                    callback(dataURL);
                };
                img.src = url;
            }

            // Get the image URL
            var imageUrl = 'https://api.qrserver.com/v1/create-qr-code/?data={{$qr_link}}&amp;size=300x300';

            // Convert the image to base64 and update the src attribute
            convertImgToBase64(imageUrl, function (base64Img) {
                document.getElementById('qr').src = base64Img;
            });
</script>
