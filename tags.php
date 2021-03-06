<?php
    $posts = array();
    $query = '';
    foreach (explode('+', $_GET['tags']) as $tag) $query .= ' tags LIKE "%' . $tag . '%" OR';
    $query = substr($query, 1, strlen($query) - 4);
    require_once('dbconfig.php');
    try {
        $dbh = new PDO($driver, $user, $pass, $attr);
        try {
            $stmt = $dbh->prepare('SELECT * FROM `articles` WHERE ' . $query . ' ORDER BY `timestamp` DESC');
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                    $posts[sizeof($posts)] = $row;
            }
            unset($stmt);
            unset($dbh);
        } catch (Exception $f) {
            echo "Exception: " . $f->getMessage() . "<br />";
        }
    } catch (Exception $e) {
        $recipient = ""; //provide an email address here to send error reports to
        $subject = "ERROR - SQL Connection";
        $mail_body = "An exception occurred on the helpdesk tags page: " . $e->getMessage();
        mail($recipient, $subject, $mail_body);
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="A virtual help desk for Bow High School students and faculty.">
    <meta name="author" content="Dylan Wheeler">

    <title>Academic Helpdesk</title>

    <!-- Bootstrap Core CSS -->
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../css/blog.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
<?php
    $page_innards = '
                <h1 class="page-header">
                    Academic Helpdesk
                    <small>Tag Search</small>
                </h1>

                ';
    foreach ($posts as $post) {
        $page_innards .= '
                <h2>
                    <a href="../post.php?id=' . $post['id'] . '">' . $post['title'] . '</a>
                </h2>
                <p class="lead">
                    by <a href="#">' . $post['author'] . '</a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on ' . date('F j, Y \a\t g:i A', strtotime($post['timestamp'])) . '</p>
                <hr />
                <center><img src="' . $post['picture'] . '" height="200" /></center>
                <hr />
                ' . substr($post['contents'], 0, strpos($post['contents'], '</p>') + 4) . '
                <a class="btn btn-primary" href="../post.php?id=' . $post['id'] . '">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr />';
    }
    $page_innards .= '

                <!-- Pager -->
                <ul class="pager">
                    <li class="previous">
                        <a href="#">&larr; Older</a>
                    </li>
                    <li class="next">
                        <a href="#">Newer &rarr;</a>
                    </li>
                </ul>';
    include("body.html");
?>

    <!-- jQuery -->
    <script src="../bower_components/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

</body>

</html>
