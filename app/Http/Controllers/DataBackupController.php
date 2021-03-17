<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\DataBackupHelpers\BackupHelper;
use App\Helpers\DataBackupHelpers\DownloadHelper;

class DataBackupController extends Controller
{
    public function index()
    {
        $helper = new BackupHelper;

        return view('data-backup.index', ['tables' => $helper->tables]);
    }

    public function download(Request $request)
    {
        $helper = new DownloadHelper($request->table, $request->index);

        return response()->json($helper->download());
    }
}
