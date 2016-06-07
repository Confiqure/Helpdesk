<?php
    $post = false;
    require_once('dbconfig.php');
    try {
        $dbh = new PDO($driver, $user, $pass, $attr);
        try {
            $stmt = $dbh->prepare('SELECT * FROM `articles` WHERE `id` = :id');
            $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_STR);
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $post = $row;
                break;
            }
            unset($stmt);
            unset($dbh);
        } catch (Exception $f) {
                echo "Exception: " . $f->getMessage() . "<br />";
        }
    } catch (Exception $e) {
        $recipient = ""; //provide an email address here to send error reports to
        $subject = "ERROR - SQL Connection";
        $mail_body = "An exception occurred on the helpdesk post page: " . $e->getMessage();
        mail($recipient, $subject, $mail_body);
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Helpdesk post">
    <meta name="author" content="Dylan Wheeler">

    <title><?php echo $post['title']; ?> - Academic Helpdesk</title>

    <!-- Bootstrap Core CSS -->
    <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/blog.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

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
                <!-- Blog Post -->

                <!-- Title -->
                <h1>' . $post['title'] . '</h1>

                <!-- Author -->
                <p class="lead">
                    by <a href="#">' . $post['author'] . '</a>
                </p>

                <hr />

                <!-- Date/Time -->
                <p><span class="glyphicon glyphicon-time"></span> Posted on ' . date('F j, Y \a\t g:i A', strtotime($post['timestamp'])) . '</p>

                <hr />

                <!-- Preview Image -->
                <center><img src="' . $post['picture'] . '" width="100%" /></center>

                <hr />

                <!-- Post Content -->
                ' . $post['contents'] . '

                <hr />

                <!-- Blog Comments -->

                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form role="form">
                        <div class="form-group">
                            <textarea class="form-control" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>

                <hr>

                <!-- Comment -->
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://lorempixel.com/64/64/cats/" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading">Mary Mae
                            <small>December 12, 2015 at 11:12 AM</small>
                        </h4>
                        I&#039;m having some problems understanding part of this article. What does the "sever" have anything to do with my desktop icons? I just want my icons back because I have important school stuff to do.
                        <!-- Nested Comment -->
                        <div class="media">
                            <a class="pull-left" href="#">
                                <img class="media-object" src="http://lorempixel.com/64/64/business/" alt="">
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading">Sam Dixon
                                    <small>December 12, 2015 at 12:38 PM</small>
                                </h4>
                                Hey Mary, the server is where all of your student account information is located. Your computer asks the server to share information about your account, including your desktop icons. By checking your connection with the server, you can restore those icons!
                            </div>
                        </div>
                        <!-- End Nested Comment -->
                        <!-- Nested Comment -->
                        <div class="media">
                            <a class="pull-left" href="#">
                                <img class="media-object" src="http://lorempixel.com/64/64/cats/" alt="">
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading">Mary Mae
                                    <small>December 12, 2015 at 1:02 PM</small>
                                </h4>
                                Thanks, Mr. Dixon!!
                            </div>
                        </div>
                        <!-- End Nested Comment -->
                    </div>
                </div>

                <!-- Posted Comments -->

                <!-- Comment -->
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://lorempixel.com/64/64/abstract/" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading">John Smith
                            <small>December 9, 2015 at 12:31 PM</small>
                        </h4>
                        Thanks! This article helped me a lot, I thought for sure all my stuff was deleted. I just followed the steps and sure enough it worked!
                    </div>
                </div>';
    include("body.html");
?>

    <!-- jQuery -->
    <script src="bower_components/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

</body>

</html>
