<?php
include '../header.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once('../classes/functions.php');
$DB = new Database();
$posts = get_posts();

$logged = false;
if (isset($_SESSION['email'])) {
    $logged = true;
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $content = addslashes(htmlspecialchars($_POST['comment']));
    $postId = $_POST['id'];
    $userid = get_userid($_SESSION['email']);
    if($DB->save("INSERT INTO comments (postId,userid,content) values ('$postId','$userid','$content')"))
    {
        header("Location: index.php");
        die;     
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Community</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap');

        body {
            font-family: 'Montserrat', sans-serif;
            background: #f8fafc;
            color: #1e293b;
            padding-bottom: 60px;
        }

        h2.text-primary {
            color: #3b82f6;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            font-weight: 700;
            text-shadow: 0 1px 3px rgba(59, 130, 246, 0.4);

        }

        a.btn-primary {
            background: linear-gradient(135deg, #2563eb, #3b82f6);
            border: none;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
            transition: all 0.3s ease;
            font-weight: 600;
            letter-spacing: 0.05em;
            border-radius: 10px;
            padding: 10px 20px;
        }

        a.btn-primary:hover {
            background: linear-gradient(135deg, #1e40af, #2563eb);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.6);
        }

        .post {
            background: #ffffff;
            border-radius: 16px;
            padding: 20px 25px;
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.15);
            margin-bottom: 25px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
            border-left: 6px solid #3b82f6;
        }

        .post:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 35px rgba(59, 130, 246, 0.3);
            border-left-color: #2563eb;
        }

        .post img {
            border-radius: 12px;
            margin-top: 15px;
            max-height: 400px;
            object-fit: cover;
            transition: box-shadow 0.3s ease;
            box-shadow: 0 4px 10px rgba(59, 130, 246, 0.1);
            cursor: pointer;
        }

        .post img:hover {
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
        }

        .post .user {
            font-weight: 700;
            font-size: 1.3rem;
            color: #2563eb;
            letter-spacing: 0.05em;
            margin-bottom: 12px;
            user-select: none;
        }

        .post .body .content {
            font-size: 1.05rem;
            line-height: 1.6;
            color: #334155;
            user-select: text;
        }

        .comments {
            margin-top: 15px;
        }

        .commentor textarea {
            border-radius: 12px;
            padding: 14px 18px;
            border: 1.5px solid #3b82f6;
            box-shadow: 0 0 10px rgba(59, 130, 246, 0.15);
            resize: vertical;
            min-height: 70px;
            font-family: 'Montserrat', sans-serif;
            font-size: 1rem;
            color: #1e293b;
            display: none;
            transition: all 0.3s ease;
        }

        .commentor textarea.active {
            display: block !important;
        }

        .commentor .submit {
            background: #3b82f6;
            border: none;
            color: white;
            font-weight: 700;
            padding: 8px 22px;
            border-radius: 10px;
            cursor: pointer;
            box-shadow: 0 5px 15px rgba(59, 130, 246, 0.3);
            transition: background 0.3s ease;
        }

        .commentor .submit:hover {
            background: #2563eb;
        }

        .comment {
            background: #f1f5f9;
            border-radius: 12px;
            padding: 12px 18px;
            margin-top: 12px;
            color: #475569;
            box-shadow: 0 1px 6px rgba(100, 116, 139, 0.1);
            border-left: 4px solid #3b82f6;
        }

        .comment .user {
            font-size: 1rem;
            font-weight: 700;
            color: #2563eb;
            margin-bottom: 6px;
            user-select: none;
        }

        .card-body {
            background: #e2e8f0;
            border-radius: 10px;
            box-shadow: inset 0 0 8px rgb(59 130 246 / 0.15);
        }

        .card-title {
            color: #2563eb;
            font-weight: 600;
        }

        .card-text {
            color: #475569;
        }

        .card-subtitle {
            color: #64748b;
        }

        .replies {
            margin-left: 2.5rem;
            margin-top: 12px;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .replies .card {
            background: #f8fafc;
            border-left: 4px solid #3b82f6;
        }

        .replier {
            border-radius: 12px;
            border: 1.5px solid #3b82f6;
            padding: 10px 14px;
            width: 100%;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.95rem;
            box-shadow: 0 0 10px rgba(59, 130, 246, 0.15);
            color: #1e293b;
            transition: box-shadow 0.3s ease;
        }

        .replier:focus {
            outline: none;
            box-shadow: 0 0 15px rgba(59, 130, 246, 0.5);
            border-color: #2563eb;
        }

        /* Scrollbar for comment textarea and replies input */
        textarea::-webkit-scrollbar,
        .replier::-webkit-scrollbar {
            width: 7px;
        }

        textarea::-webkit-scrollbar-thumb,
        .replier::-webkit-scrollbar-thumb {
            background: #3b82f6;
            border-radius: 10px;
        }
    </style>
</head>

<body>
    <section id="planner" class="py-5">
        <form method="post" id="commentor_form" style="display:none;">
            <textarea name="comment" id="text"></textarea>
            <input type="hidden" name="id" id="id" />
        </form>
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-primary fw-bold m-0">Community</h2>
                <a href="new.php" class="btn btn-primary">
                    <i class="fa fa-plus me-2"></i> Add Your Post
                </a>
            </div>

            <div class="mx-auto" style="max-width: 700px;">
                <?php
                if (is_array($posts)) {
                    foreach ($posts as $post) {
                        $username = get_post_username($post['userid']);
                        $content = nl2br(stripslashes($post['content']));
                        $comments = get_comments($post['id']);
                        echo "<div class='post shadow-sm'>
                            <p class='user'>$username</p>
                            <div class='body'>
                                <div class='content'>$content</div>";
                                if ($post['containsFile'] == 1) {
                                    echo "<img src='$post[image]' alt='Post image' class='image rounded'>";
                                }
                            echo "</div>
                            <div class='comments'>";
                        if ($logged) {
                            echo "<div class='commentor'>
                                <textarea class='non form-control' placeholder='Write your comment'></textarea>
                                <button data-id='$post[id]' class='submit' onclick='comment(this)'>Comment</button>
                            </div>";
                        }
                        if (is_array($comments)) {
                            foreach ($comments as $comment) {
                                    $commentorName = get_commentor_name($comment['id']);
                                    $replies = get_replies($comment['id']);

                                    echo "<div class='card mb-3'>
                                            <div class='card-body'>
                                                <h6 class='card-title'>$commentorName</h6>
                                                <p class='card-text'>" . nl2br($comment['content']) . "</p>
                                                <a class='text-decoration-underline text-muted small' data-id='{$comment['id']}' style='cursor:pointer;' onclick='reply_to_this(this)'>Reply</a>";

                                    if (is_array($replies)) {
                                        echo "<div class='mt-3 ps-3 border-start'>";
                                        foreach ($replies as $reply) {
                                            $replyorName = get_commentor_name($reply["id"]);
                                            echo "<div class='card mb-2 bg-light'>
                                                    <div class='card-body py-2 px-3'>
                                                        <h6 class='card-subtitle mb-1 text-secondary fw-semibold'>$replyorName</h6>
                                                        <p class='card-text small mb-0'>{$reply['content']}</p>
                                                    </div>
                                                </div>";
                                        }
                                        echo "</div>";
                                    }

                                    echo "  </div>
                                        </div>";
                            }
                        } else {
                            echo "<p class='text-center text-muted'>No comments yet!</p>";
                        }
                        echo "</div></div>";
                    }
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        let commentor_form = document.getElementById("commentor_form");

        function comment(ele) {
            let textarea = ele.previousElementSibling;
            if (textarea.classList.contains('non')) {
                textarea.className = 'active';
                textarea.focus();
            } else {
                let text = textarea.value;
                if (text.trim() == '') {
                    alert("Comment cannot be empty!");
                } else {
                    commentor_form.querySelector("#text").value = text.trim();
                    let id = ele.dataset.id;
                    commentor_form.querySelector("#id").value = id;
                    commentor_form.submit();
                }
            }
        }

        function reply_to_this(ele) {
            ele.style.display = 'none';
            let parent = ele.parentElement;
            let inp = document.createElement('input');
            inp.type = 'text';
            inp.className = 'replier';
            inp.placeholder = 'Write a reply and press Enter to submit';
            inp.onkeyup = function (eve) {
                if (eve.keyCode == 13) {
                    let reply = inp.value.trim();
                    let cId = ele.dataset.id;
                    if (reply == '')
                        alert('Reply cannot be empty!');
                    else {
                        let ajax = new XMLHttpRequest();
                        ajax.open("POST", '../ajax/reply.php', true);
                        ajax.setRequestHeader("Content-Type", "text/plain");
                        let data = {};
                        data.action = 'reply';
                        data.content = reply;
                        data.comment = cId;
                        data = JSON.stringify(data);
                        ajax.onreadystatechange = function () {
                            if (ajax.readyState === 4 && ajax.status === 200) {
                                if (ajax.responseText == 'success')
                                    location.reload();
                                else {
                                    alert("An error occured!");
                                    return;
                                }
                            }
                        };

                        ajax.send(data);
                    }
                }
            }
            inp.onblur = function () {
                inp.nextElementSibling.style.display = 'block';
                inp.remove();
            }
            parent.insertBefore(inp, ele);
            inp.focus();
        }
    </script>
</body>

</html>
<?php include '../footer.php'; ?>
