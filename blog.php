<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Blog</title>
  <link rel="stylesheet" href="style.css" />
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar">
    <ul>
      <li><a href="index.html">Home</a></li>
      <li><a href="about.html">About</a></li>
      <li><a href="blog.php">Blog</a></li>
      <li><a href="contact.html">Contact</a></li>
    </ul>
  </nav>

  <!-- Main -->
  <main id="blog">
    <!-- Form Tambah Blog -->
    <div class="form-blog">
      <h1>Tambah Blog</h1>
      <form action="blog-tambah.php" method="POST" enctype="multipart/form-data">
        <label for="judul">Judul:</label><br>
        <input type="text" id="judul" name="judul" required><br><br>

        <label for="isi">Isi:</label><br>
        <textarea id="isi" name="isi" rows="4" cols="50" required></textarea><br><br>

        <label for="gambar">Gambar:</label><br>
        <input type="file" id="gambar" name="gambar" accept="image/*" required><br><br>

        <input type="submit" value="Tambah">
      </form>
    </div>

    <?php
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "my_db";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT title, content, image_url FROM articles ORDER BY created_at DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        echo "<article class='card'>";
        echo "<img src='" . $row["image_url"] . "' alt='" . $row["title"] . "' style='width:100%'>";
        echo "<h2>" . $row["title"] . "</h2>";
        echo "<p>" . $row["content"] . "</p>";
        echo "</article>";
      }
    } else {
      echo "0 results";
    }
    $conn->close();
    ?>
  </main>

  <!-- Footer -->
  <footer>
    <div class="footer">
      <div class="row">
        <ul>
          <li><a href="index.html">Home</a></li>
          <li><a href="about.html">About</a></li>
          <li><a href="blog.php">Blog</a></li>
          <li><a href="contact.html">Contact</a></li>
        </ul>
      </div>

      <div class="row">Copyright © 2024 Eiden - All rights reserved</div>
    </div>
  </footer>
</body>

</html>