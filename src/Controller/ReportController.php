<?php

namespace App\Controller;

use App\Model\ReportManager;

class ReportController extends AbstractController
{
    public function showReports()
    {
        $reportManager = new ReportManager();
        $reports = $reportManager->selectReports();

        return $this->twig->render('Home/index.html.twig', ['reports' => $reports]);
    }

    /*public function insertReport()
    {
        $adsReport = new ReportManager();
        $adsReportManager = $adsReport-> selectReports();

        return null;
    }*/
}
