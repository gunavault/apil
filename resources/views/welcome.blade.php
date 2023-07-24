<!DOCTYPE html>
<html>
<head>
    <title>Generate QR Code Link</title>
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">

    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Select2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

</head>
<style>
        .custom-input::placeholder {
            opacity: 0.3; /* Set the desired opacity for the placeholder */
        }
        .select2-container .select2-selection--single {
            height: 50px; /* Set the desired height */
            font-size: 48px; /* Set the desired font size */
            text-align: center; /* Center the select box text */
            font-weight: bold; 
        }
    </style>
<body>
    <div class="container mt-5">
        <h1>Generate QR Code Link</h1>
        <form action="{{ route('create.qr.link') }}" method="post" onsubmit="formatNopol()">
            @csrf
            <div class="form-group text-center"> <!-- Add 'text-center' class to center the input -->
                <label for="nopol">Nomor Polisi:</label>
                <input type="text" name="nopol" id="nopol" class="form-control text-center font-weight-bold custom-input" placeholder="BM81234WF" style="font-size: 24px;"> <!-- Apply custom styles -->
            </div>
            <div class="form-group text-center">
            <label for="nopol">Pemasok</label>
            <select name="pemasok" id="pemasok" class="form-control select2 custom-input" data-live-search="true">
                <option value="">Select Pemasok</option>
                @foreach($namapemasokdata as $pemasokdata)
                    <option value="{{ $pemasokdata->nama }}">{{ $pemasokdata->nama }}</option>
                @endforeach
            </select>
            </div>
            <div class="form-group text-center">
                <label for="nomor_hp_pemasok">Nomor HP Pemasok:</label>
                <input type="text" name="nomor_hp_pemasok" id="nomor_hp_pemasok" class="form-control text-center font-weight-bold custom-input" placeholder="08987465123"  style="font-size: 24px;">
            </div>
            <div class="form-group">
                <label for="jeniskendaraan">Jenis Kendaraan:</label>
                <input type="text" name="jeniskendaraan" id="jeniskendaraan" class="form-control text-center font-weight-bold custom-input" placeholder="PICK UP" style="font-size: 24px;">
            </div>
            <div class="text-center"> <!-- Center the button -->
                <button type="submit" class="btn btn-primary">Generate QR Code Link</button>
            </div>
        </form>
    </div>

    <!-- Add Bootstrap JS and jQuery scripts (optional) -->
    <!-- These are optional but required if you want to use Bootstrap's JavaScript components -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- JavaScript function to format Nopol input -->
    <script>
        function formatNopol() {
            const nopolInput = document.getElementById('nopol');
            nopolInput.value = nopolInput.value.toUpperCase().replace(/\s/g, '');
        }

        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
</body>
</html>
