<!DOCTYPE html>
<html>
<head>
    <title>Verification Result</title>
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-3">Verification Result</h1>
        @if ($status === 'success')
            <div class="alert alert-success mt-3">
                <strong>Status:</strong> {{ $status }}
            </div>
            <div class="mt-3 alert alert-success ">
                <p><strong>Message:</strong> {{ $message }}</p>
                <!-- You can customize the success message here -->
                <p>Congratulations, the data for the given vehicle and supplier exists! {{$pemasok}}</p>
            </div>
        @else
            <div class="alert alert-danger mt-3">
                <strong>Status:</strong> {{ $status }}
            </div>
            <div class="mt-3 alert-danger mt-3" >
                <p><strong>Message:</strong> {{ $message }}</p>
                <!-- You can customize the error message here -->
                <p>Sorry, the data for the given vehicle and supplier does not exist. A notification has been added.</p>
            </div>
            <div class="container mt-5">
        @if(session('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger mt-3">
                {{ session('error') }}
            </div>
        @endif
    </div>
        @endif
    </div>

    <!-- Add Bootstrap JS and jQuery scripts (optional) -->
    <!-- These are optional but required if you want to use Bootstrap's JavaScript components -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
