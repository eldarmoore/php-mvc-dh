<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\Controller;
use Framework\Viewer;

class Home extends Controller
{
    public function index()
    {
        $viewer = new Viewer;

        echo $viewer->render("shared/header.php", [
            "title" => "Home",
        ]);

        echo $viewer->render('Home/index.php');
    }
}