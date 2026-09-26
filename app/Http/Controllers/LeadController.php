<?php
namespace App\Http\Controllers;
use App\Models\Lead;use Illuminate\Http\Request;use Inertia\Inertia;
class LeadController extends Controller{
public function index(Request $r){
$q=$r->string('q')->toString();$p=$r->string('priority')->toString();
$leads=Lead::when($q,fn($x)=>$x->where(fn($w)=>$w->where('name','like',"%$q%")->orWhere('email','like',"%$q%")->orWhere('service','like',"%$q%")))->when($p,fn($x)=>$x->where('priority',$p))->latest()->get();
return Inertia::render('Leads/Index',['leads'=>$leads,'filters'=>['q'=>$q,'priority'=>$p],'stats'=>['total'=>Lead::count(),'hot'=>Lead::where('priority','Hot')->count(),'avg'=>round((float)Lead::avg('score')),'saved'=>Lead::count()*7]]);
}
public function store(Request $r){
$d=$r->validate(['name'=>'required|max:120','email'=>'required|email','service'=>'required','urgency'=>'required|integer|min:1|max:3','budget'=>'nullable|numeric|min:0','source'=>'nullable|max:100']);$d['budget']=$d['budget']??0;
$s=20+($d['budget']>=1000?35:($d['budget']>=500?25:($d['budget']>=200?15:0)))+$d['urgency']*10+(in_array($d['service'],['Web Development','Digital Marketing','SEO'])?15:10)+(str_contains(strtolower($d['source']??''),'ref')?10:0);
$d['score']=min(100,$s);$d['priority']=$s>=75?'Hot':($s>=50?'Warm':'Cold');$d['followup']="Hi {$d['name']},\n\nThank you for contacting Biswas IT Firm about {$d['service']}. Your inquiry is marked as ".strtolower($d['priority'])." priority. We would be happy to discuss your requirements, scope and budget.\n\nBest regards,\nBiswas IT Firm";Lead::create($d);return back();}
public function destroy(Lead $lead){$lead->delete();return back();}
}