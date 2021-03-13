<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EnterprisePart;
use App\Models\Role;
use App\Helpers\EnterprisePartHelpers\MembersHelper;
use App\Helpers\EnterprisePartHelpers\FindMembers;

class EnterprisePartController extends Controller
{
    public function index()
    {
        $parts = EnterprisePart::all();

        return view('enterprise-part/index', ['parts' => $parts]);
    }

    public function show(EnterprisePart $part, Request $request)
    {
        $helper = new FindMembers($part);
        $dcos = $helper->membersWithRole(Role::where('name', 'dco')->first());
        $members = $helper->allMembers();

        return view('enterprise-part/show', ['part' => $part, 'dcos' => $dcos, 'members' => $members]);
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

        $message = $request->email . ($request->mode == 1 ? " added to " : " removed from ") . "$part->name";
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

        $message = $request->email . ($request->mode == 1 ? " added to " : " removed from ") . "$part->name";
        $this->flashMessage('success', $message);
        
        return redirect()->route('enterprise-parts.show', ['part' => $part->id]);
    }

    public function changeType(EnterprisePart $part, Request $request)
    {
        $part->is_academic_part = $request->type == 1;
        $part->save();

        $message = "$part->name changed to " . ($part->is_academic_part ? "academic" : "non academic");
        $this->flashMessage('success', $message);

        return redirect()->route('enterprise-parts.show', ['part' => $part->id]);
    }

    public function update(EnterprisePart $part, Request $request)
    {
        $part->name = $request->name;
        $part->acronym = $request->acronym;
        $part->save();

        $this->flashMessage('success', "$part->name details updated");

        return redirect()->route('enterprise-parts.show', ['part' => $part->id]);
    }
}
