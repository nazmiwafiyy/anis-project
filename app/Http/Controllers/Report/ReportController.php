<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\DataTables\UsersDataTable;
use App\Http\Controllers\Controller;
use App\DataTables\PaidApplicationDataTable;
use App\DataTables\ApprovedApplicationDataTable;
use App\DataTables\RejectedApplicationDataTable;
use App\DataTables\SupportedApplicationDataTable;
use App\DataTables\UnsupportedApplicationDataTable;

class ReportController extends Controller
{
    public function getUsers(UsersDataTable $dataTable)
    {
        return $dataTable->render('report.user');
    }

    public function getSupportedApplication(SupportedApplicationDataTable $dataTable)
    {
        // $user = \App\User::permission('approval-welfare-social-bureaus')->get();
        // dd($user);
        return $dataTable->render('report.supportedApplication');
    }

    public function getUnsupportedApplication(UnsupportedApplicationDataTable $dataTable)
    {
        return $dataTable->render('report.unsupportedApplication');
    }    
    
    public function getApprovedApplication(ApprovedApplicationDataTable $dataTable)
    {
        return $dataTable->render('report.approvedApplication');
    }    
    
    public function getRejectedApplication(RejectedApplicationDataTable $dataTable)
    {
        return $dataTable->render('report.rejectedApplication');
    }    
    
    public function getPaiddApplication(PaidApplicationDataTable $dataTable)
    {
        return $dataTable->render('report.paidApplication');
    }    
}
