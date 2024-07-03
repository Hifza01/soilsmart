<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('image/icon.png') }}">
    <title>SoilSmart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/content.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">   
    <style>
        .progress-bar-circle {
            width: 100px; /* Adjust size as needed */
            height: 100px;
            position: relative;
        }
        .progress-bar-label {
            text-align: center;
            margin-top: 10px;
            margin-left: 40px;
            font-size: 18px;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/progressbar.js@1.0.1/dist/progressbar.min.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-database.js"></script>
</head>
<body class="body">
    <!-- Header -->
    <div class="header">
        <nav class="navbar">
            <img src="{{ asset('image/logo_nama.png') }}" alt="" class="logo">
            <div class="header-right">        
                <a data-bs-toggle="modal" data-bs-target="#myModal">
                    <img src="{{ asset('image/icon2.png') }}" alt="">
                </a>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <img src="{{ asset('image/icon1.png') }}" alt="">
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </nav>
    </div>

    <!-- Content -->
    <div class="space1"></div>
    <center>
        <div class="card">
            <div class="container">
                <h4>Sensor Pada Tanah</h4>
                <div class="row">
                    <!-- Sensor Pada Tanah 1 -->
                    <div class="col">                        
                        <div id="sensor1Container" class="progress-bar-container">
                            <div id="sensor1Value" class="progress-bar-circle"></div>
                            <div class="progress-bar-label">Sensor Tanah 1</div>
                        </div>
                    </div>
                    <!-- Sensor Pada Tanah 2 -->
                    <div class="col">
                        <div id="sensor2Container" class="progress-bar-container">
                            <div id="sensor2Value" class="progress-bar-circle"></div>
                            <div class="progress-bar-label">Sensor Tanah 2</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </center>
    <!-- Modal -->
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Notifikasi</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <table id="notificationTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Pesan</th>
                                <th scope="col">Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($notifications as $notification)
                            <tr>
                                <td>{{ $notification['message'] }}</td>
                                <td>{{ $notification['timestamp'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <!-- Optional: Add footer buttons or other elements -->
                </div>
            </div>
        </div>
    </div>
    <div class="space1"></div>

    <!-- Footer -->
    <footer>
        <p>COPYRIGHT © SOILSMART</p>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/bar.js') }}"></script>
</body>
</html>

       