<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class PublicMemberController extends Controller
{
    public function verify($uuid)
    {
        $member = Member::where('uuid', $uuid)->with('region')->firstOrFail();
        return view('public.member-verify', compact('member'));
    }
}
