<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EnterprisePart;
use App\Models\Role;
use App\Helpers\EnterprisePartHelpers\MembersHelper;

class EnterprisePartController extends Controller
{
    public function index()
    {
        $parts = EnterprisePart::all();

        return view('enterprise-part/index', ['parts' => $parts]);
    }

    public function show(EnterprisePart $part, Request $request)
    {
        $dcos = [];

        foreach (Role::where('name', 'dco')->first()->users as $dco) {
            if (in_array($part->id, $dco->memberOf->pluck('id')->toArray())) {
                $dcos[] = $dco;
            }
        }

        return view('enterprise-part/show', ['part' => $part, 'dcos' => $dcos]);
    }

    public function changeHead(EnterprisePart $part, Request $request)
    {
        (new MembersHelper($part, $request->email))->changeHead();
        $this->flashMessage('success', "$part->name head changed");

        return redirect()->route('enterprise-parts.show', ['part' => $part->id]);
    }

    public function changeDCO(EnterprisePart $part, Request $request)
    {
        $helper = new MembersHelper($part, $request->email);

        if ($request->mode) {
            $helper->addDCO();
        } else {
            $helper->removeDCO();
        }

        $message = $request->email . $request->mode == 1 ? " added to " : " removed from " . "$part->name";
        $this->flashMessage('success', $message);
        
        return redirect()->route('enterprise-parts.show', ['part' => $part->id]);
    }

    public function changeMember(EnterprisePart $part, Request $request)
    {
        $helper = new MembersHelper($part, $request->email);

        if ($request->mode) {
            $helper->addMember();
        } else {
            $helper->removeMember();
        }

        $message = $request->email . $request->mode == 1 ? " added to " : " removed from " . "$part->name";
        $this->flashMessage('success', $message);
        
        return redirect()->route('enterprise-parts.show', ['part' => $part->id]);
    }

    public function changeType(EnterprisePart $part, Request $request)
    {
        $part->is_academic_part = $request->type == 1;
        $part->save();

        $message = $part->name . " changed to " . $part->is_academic_part ? "academic" : "non academic";
        $this->flashMessage('success', $message);

        return redirect()->route('enterprise-parts.show', ['part' => $part->id]);
    }
}
