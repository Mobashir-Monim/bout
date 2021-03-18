<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\DataBackupHelpers\BackupHelper;
use App\Helpers\DataBackupHelpers\DownloadHelper;
use App\Helpers\DataBackupHelpers\UploadHelper;

class DataBackupController extends Controller
{
    public function index()
    {
        $helper = new BackupHelper;

        return view('data-backup.index', ['tables' => $helper->getTablesWithDescription()]);
    }

    public function download(Request $request)
    {
        $helper = new DownloadHelper($request->table, $request->index);

        return response()->json($helper->download());
    }

    public function upload(Request $request)
    {
        $helper = new UploadHelper($request->table, $request->rows, $request->prune);

        return response()->json($helper->upload());
    }
}
