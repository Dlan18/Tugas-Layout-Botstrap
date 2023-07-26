<?php

// Cek apakah ada data POST yang dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nama = $_POST['nama'];
  $nilai = $_POST['nilai'];

  // Include file connect
  include 'connect.php';

  // Insert data ke tabel students
  $stmt = $conn->prepare("INSERT INTO students (name) VALUES (?)");
  $stmt->bind_param("s", $nama);
  $stmt->execute();

  // Ambil id siswa yang baru saja diinsert
  $student_id = $conn->insert_id;

  // Insert data ke tabel scores
  $stmt = $conn->prepare("INSERT INTO scores (student_id, score) VALUES (?, ?)");
  $stmt->bind_param("ii", $student_id, $nilai);
  $stmt->execute();

  // Tutup statement dan koneksi database
  $stmt->close();
  $conn->close();

  // Setelah selesai mengirim data, redirect ke halaman yang sama menggunakan metode GET
  header("Location: index.php");
  exit(); // pastikan untuk menghentikan eksekusi skrip setelah header redirect
}

// Selanjutnya, tambahkan kode untuk mengambil data dari kedua tabel untuk ditampilkan di tabel
// Gunakan JOIN antara students dan scores berdasarkan student_id

include 'connect.php';

// Query untuk mengambil data dari kedua tabel
$query = "SELECT students.name, scores.score FROM students JOIN scores ON students.id = scores.student_id";
$result = $conn->query($query);

// Array untuk menyimpan data siswa dan skor
$data = array();
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
      $data[] = $row;
  }
}

// Tutup koneksi database
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SMKN 10 JKT - RANKING XI RPL</title>
    <link rel="icon" href="logo.jpeg" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.7.1.min.js"></script>
    <style>
      * {
        margin: 0;
        font-family: sans-serif;
      }
      ::-webkit-scrollbar {
        width: 10px;
      }
      ::-webkit-scrollbar-track {
        background-color: transparent;
      }
      ::-webkit-scrollbar-thumb {
        background-color: #aaa;
        border-radius: 10px;
      }
      ::-webkit-scrollbar-thumb:hover {
        background-color: #0d6efd;
      }
      #button {
        width: 50px;
        height: 50px;
        border-radius: .7rem;
        position: fixed;
        bottom: 25px;
        left: 25px;
        cursor: pointer;
        transition: background-color .3s, 
          opacity .5s, visibility .5s, scale .3s ease;
        opacity: 0;
        visibility: hidden;
        z-index: 1000;
      }
      #button svg{
        color: #fff;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
      }
      #button:hover {
        scale: .95;
      }
      #button:active {
        scale: .85;
      }
      #button.show {
        opacity: 1;
        visibility: visible;
      }
      .navbar {
        padding: 10px;
      }
      form {
        padding-right: 30px;
      }
      @media (max-width: 767px) {
        form {
          padding-right: 0;
        }
      }
      h2 {
        font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
        font-weight: 28px;
        letter-spacing: 2.5px;
      }
      label {
        margin-bottom: 5px;
      }
      td {
        padding: 7px;
      }
      th {
        padding: 11px;
      }
    </style>

  </head>
  <body>
    <a id="button" class="d-inline-block bg-primary" title="Kembali Ke Atas">
      <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-arrow-up-short" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M8 12a.5.5 0 0 0 .5-.5V5.707l2.146 2.147a.5.5 0 0 0 .708-.708l-3-3a.5.5 0 0 0-.708 0l-3 3a.5.5 0 1 0 .708.708L7.5 5.707V11.5a.5.5 0 0 0 .5.5z"/>
      </svg>
      </svg>
    </a>

    <nav class="navbar navbar-light shadow mb-5 bg-white z-3 justify-content-center sticky-top">
      <a class="navbar-brand d-flex align-items-center" href="">
        <img src="logo.jpeg" width="37" height="auto" class="me-3" alt="" />
        <h2 class="fw-bold m-0">SMKN 10 JKT</h2>
      </a>
    </nav>
    
    <div class="m-5 d-flex flex-wrap justify-content-center">
      <form class="col-12 col-md-4 mb-4" action="index.php" method="post">
        <h2 class="d-flex justify-content-center align-items-center fw-bold"><svg class="me-3" xmlns="http://www.w3.org/2000/svg" width="35" height="auto" fill="currentColor" class="bi bi-person-vcard" viewBox="0 0 16 16">
          <path d="M5 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm4-2.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5ZM9 8a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4A.5.5 0 0 1 9 8Zm1 2.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5Z"/>
          <path d="M2 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H2ZM1 4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H8.96c.026-.163.04-.33.04-.5C9 10.567 7.21 9 5 9c-2.086 0-3.8 1.398-3.984 3.181A1.006 1.006 0 0 1 1 12V4Z"/>
        </svg>XI RPL'56</h2>
        <hr>
        <h3 class="mt-4 mb-4 fw-bold">Input Data</h3>
        <div class="mb-3">
          <label for="nama"><span class="text-primary fw-bold">-</span> Nama</label>
          <input id="nama" type="text" name="nama" class="form-control" placeholder="Masukkan nama siswa/i" required />
        </div>
        <div class="mb-4">
          <label for="nilai"><span class="text-primary fw-bold">-</span> Nilai</label>
          <input id="nilai" type="number" name="nilai" class="form-control" placeholder="Masukkan nilai siswa/i" required />
        </div>
        <button class="btn btn-primary rounded-1" style="letter-spacing: 0.5px" type="submit">KIRIM</button>
      </form>

      <table class="table-bordered border-dark col-12 col-md-8 text-center">
        <thead class="bg-primary text-light">
          <tr>
            <th>No.</th>
            <th>Nama</th>
            <th>Nilai</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($data as $key => $d): ?>
          <tr>
            <td><?= $key + 1 ?></td>
            <td><?= $d['name'] ?></td>
            <td><?= $d['score'] ?></td>
          </tr>
          <?php endforeach ?>
          </tbody>
      </table>
    </div>
    
    <div class="footer fixed-bottom bg-dark p-3 b-0">
      <h2 class="d-flex justify-content-center align-items-center text-light h5" style="letter-spacing: 0;">Copyright © SMKN 10 Jakarta</h2>
    </div>

    <script>
      var btn = $('#button');

      $(window).scroll(function() {
        if ($(window).scrollTop() > 200) {
          btn.addClass('show');
        } else {
          btn.removeClass('show');
        }
      });

      btn.on('click', function(top) {
        top.preventDefault();
        $('html, body').animate({scrollTop:0});
      });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  </body>
</html>