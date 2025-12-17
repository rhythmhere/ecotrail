<?php
include '../header.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once('../classes/functions.php');
$DB = new Database();
$message = '';

if(isset($_GET['s']) && $_GET['s'])
    $message = 'Post created!';

if (!isset($_SESSION['email'])) {
    header("Location: ../auth/login.php");
    die;
}

function generate_file_name(){
    $file = bin2hex(random_bytes(12));
    return "uploads/$file";
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $content = addslashes(htmlspecialchars($_POST['content']));
    $containsFile = false;
    $userid = get_userid($_SESSION['email']);
    if($_FILES['image']['name'] != "")
    {
        $file = $_FILES['image'];
        $type = $file['type'];
        if($type == 'image/png')
        {
            $ext = '.png';
        }else{
            $ext = '.jpg';
        }
        $filename = generate_file_name() . $ext;
        move_uploaded_file($file['tmp_name'],$filename);
        $containsFile = true;
    }
    if($containsFile)
    {
        if($DB->save("INSERT INTO posts (userid,content,containsFile,image) values ('$userid','$content','1','$filename')"))
        {
            $message = "Posted successfully!";
            header("Location: new.php?s=1");
            die;
        }
    }else{
        if($DB->save("INSERT INTO posts (userid,content) values ('$userid','$content')"))
        {
            $message = "Posted successfully!";
            header("Location: new.php?s=1");
            die;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Create a Post</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
  <style>
    body {
      background: #f9fafb;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .card {
      border-radius: 1rem;
      box-shadow: 0 8px 20px rgb(0 0 0 / 0.1);
      background: #ffffff;
    }

    #statusMessage {
      padding: 1rem 1.25rem;
      margin-bottom: 1.5rem;
      border: 1px solid #198754;
      color: #198754;
      border-radius: 0.5rem;
      background-color: #d1e7dd;
      font-weight: 600;
      font-size: 1rem;
      text-align: center;
    }

    textarea {
      resize: vertical;
      min-height: 160px;
      font-size: 1.05rem;
      padding: 1rem;
      border-radius: 0.75rem;
      border: 1.5px solid #ced4da;
      transition: border-color 0.3s ease;
    }

    textarea:focus {
      border-color: #0d6efd;
      box-shadow: 0 0 6px rgba(13, 110, 253, 0.4);
      outline: none;
    }

    input[type="file"] {
      border-radius: 0.5rem;
      padding: 0.3rem 0.5rem;
      font-weight: 600;
      color: #495057;
      transition: border-color 0.3s ease;
      border: 1.25px solid #ced4da;
    }

    input[type="file"]:focus {
      border-color: #0d6efd;
      box-shadow: 0 0 6px rgba(13, 110, 253, 0.4);
      outline: none;
    }

    button[type="submit"] {
      border-radius: 0.75rem;
      font-size: 1.15rem;
      padding: 0.75rem 1.5rem;
      font-weight: 700;
      box-shadow: 0 5px 15px rgb(13 110 253 / 0.4);
      transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }

    button[type="submit"]:hover {
      background-color: #0b5ed7;
      box-shadow: 0 8px 20px rgb(11 94 215 / 0.6);
    }
  </style>
</head>

<body>
  <section class="py-5 min-vh-100 d-flex align-items-center" style="background-color: #f9fafb;">
    <div class="container d-flex justify-content-center">
      <div class="card p-5 shadow-sm" style="max-width: 600px; width: 100%;">
        <h2 class="mb-4 text-center text-primary fw-bold fs-1">Create a Post</h2>

        <?php if ($message): ?>
          <div id="statusMessage"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <form id="postForm" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
          <div class="mb-4">
            <label for="content" class="form-label fw-semibold fs-5">Content</label>
            <textarea id="content" name="content" class="form-control" required
              placeholder="What's on your mind?"></textarea>
            <div class="invalid-feedback fs-6">
              Please enter the content.
            </div>
          </div>

          <div class="mb-4">
            <label for="image" class="form-label fw-semibold fs-5">Image (JPEG or PNG)</label>
            <input type="file" accept="image/jpeg,image/png" name="image" id="image" class="form-control"
              onchange="validateImage(this)">
          </div>

          <button type="submit" class="btn btn-primary w-100 py-3 fw-semibold fs-5">
            <i class="fa-solid fa-paper-plane me-2"></i> Submit
          </button>
        </form>
      </div>
    </div>
  </section>

  <!-- Bootstrap JS Bundle (includes Popper) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    function validateImage(input) {
      let file = input.files[0];
      if (file) {
        if (file.type !== "image/jpeg" && file.type !== "image/png") {
          alert("Only JPEG and PNG files are allowed.");
          input.value = '';
        }
      }
    }

    (() => {
      'use strict';
      const forms = document.querySelectorAll('.needs-validation');
      Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
          if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
          }
          form.classList.add('was-validated');
        }, false);
      });
    })();
  </script>
</body>

</html>

<?php include '../footer.php'; ?>
