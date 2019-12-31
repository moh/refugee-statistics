<?php
    session_start();

    if($_SESSION['programs'] != "refugee"){
        header("Location: ../index.php");
        exit;
    }
?>

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8"/>
    <title>البرامج</title>
    <meta name="author" content="Said"/>
    <link rel="stylesheet" type="text/css" href="../../index.css"/>
</head>
<body>
    <img src="../../images/logo.jpg" id="logo_image"/>
    <h2>البرامج</h2>
    <div id="programs">
        <ul>
            <li>
                <a href="add_family.php">
                    <p>اضافة اسرة</p>
                    <img src="images/add_family.png" alt="add_family"/>
                </a>
            </li>
        </ul>
        <ul>
            <li>
                <a href="search_family.php">
                    <p>البحث عن اسرة</p>
                    <img src="images/search_fam.png" alt="ref_stat"/>
                </a>
            </li>
        </ul>
        <ul>
            <li>
                <a href="show_family.php">
                    <p>عرض اخر الاسر</p>
                    <img src="images/show_fams.jpg" alt="ref_stat"/>
                </a>
            </li>
        </ul>
    </div>

    <form>

    </form>

</body>
</html>
