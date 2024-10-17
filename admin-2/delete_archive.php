<?php

    $deleteQuery = "DELETE FROM tb_archive_faqs WHERE arc_date < NOW() - INTERVAL 30 DAY;";
    $res_tb_archive_faqs = mysqli_query($conn, $deleteQuery);

    $deleteQuery = "DELETE FROM tb_archive_event WHERE arc_date < NOW() - INTERVAL 30 DAY;";
    $res_tb_archive_event = mysqli_query($conn, $deleteQuery);

    $deleteQuery = "DELETE FROM tb_archive_resorts WHERE arc_date < NOW() - INTERVAL 30 DAY;";
    $res_tb_archive_resorts = mysqli_query($conn, $deleteQuery);

    $deleteQuery = "DELETE FROM tb_archive_recreational WHERE arc_date < NOW() - INTERVAL 30 DAY;";
    $res_tb_archive_recreational = mysqli_query($conn, $deleteQuery);

    $deleteQuery = "DELETE FROM tb_archive_hotel_lodge WHERE arc_date < NOW() - INTERVAL 30 DAY;";
    $res_tb_archive_hotel_lodge = mysqli_query($conn, $deleteQuery);

    $deleteQuery = "DELETE FROM tb_archive_natural_manmade WHERE arc_date < NOW() - INTERVAL 30 DAY;";
    $res_tb_archive_natural_manmade = mysqli_query($conn, $deleteQuery);

    $deleteQuery = "DELETE FROM tb_archive_cultural_religious WHERE arc_date < NOW() - INTERVAL 30 DAY;";
    $res_tb_archive_cultural_religious = mysqli_query($conn, $deleteQuery);

    $deleteQuery = "DELETE FROM tb_archive_restaurants WHERE arc_date < NOW() - INTERVAL 30 DAY;";
    $res_tb_archive_restaurants = mysqli_query($conn, $deleteQuery);

?>