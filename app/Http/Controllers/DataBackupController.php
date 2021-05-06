<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Helpers\DataBackupHelpers\BackupHelper;
use App\Helpers\DataBackupHelpers\DownloadHelper;
use App\Helpers\DataBackupHelpers\UploadHelper;
use App\Jobs\UploadBackupData;

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
        $message = 'Stored for backup';
        $helper = new UploadHelper;
        $helper->setBackupRows($request->table, $request->rows, $request->current);

        if ($request->current == $request->last) {
            UploadBackupData::dispatch()->delay(now()->addSeconds(30));
            $message = 'Data backup scheduled to be performed after 5 minutes';
        }

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }
}
