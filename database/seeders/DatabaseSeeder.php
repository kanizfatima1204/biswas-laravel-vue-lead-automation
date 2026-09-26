<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Lead;
class DatabaseSeeder extends Seeder{
public function run():void{
foreach([
['Sarah Johnson','sarah@example.com','Web Development',3,1800,'Referral'],
['Michael Brown','michael@example.com','Digital Marketing',2,750,'Facebook'],
['Nadia Rahman','nadia@example.com','Graphic Design',1,250,'Website']
] as $x){[$n,$e,$s,$u,$b,$src]=$x;$score=min(100,20+($b>=1000?35:($b>=500?25:($b>=200?15:0)))+$u*10+(in_array($s,['Web Development','Digital Marketing','SEO'])?15:10)+(str_contains(strtolower($src),'ref')?10:0));$p=$score>=75?'Hot':($score>=50?'Warm':'Cold');Lead::create(['name'=>$n,'email'=>$e,'service'=>$s,'urgency'=>$u,'budget'=>$b,'source'=>$src,'score'=>$score,'priority'=>$p,'followup'=>"Hi $n,\n\nThank you for contacting Biswas IT Firm about $s. Your inquiry is marked as ".strtolower($p)." priority. We would be happy to discuss your requirements, scope and budget.\n\nBest regards,\nBiswas IT Firm"]);}}
}