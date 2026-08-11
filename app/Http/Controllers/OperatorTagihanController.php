<?php
namespace App\Http\Controllers;
use App\Models\JenisPengajuan;
class OperatorTagihanController extends Controller
{
    public function index(){ $tagihans=JenisPengajuan::where('is_active',true)->where('is_tagihan_dashboard',true)->where('deadline_at','>=',now())->orderBy('deadline_at')->get(); return view('operator.tagihan.index',compact('tagihans')); }
}
