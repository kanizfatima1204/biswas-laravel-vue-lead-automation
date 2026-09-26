<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration{
public function up():void{Schema::create('leads',function(Blueprint $t){
$t->id();$t->string('name');$t->string('email');$t->string('service');$t->unsignedTinyInteger('urgency')->default(2);
$t->decimal('budget',12,2)->default(0);$t->string('source')->default('Direct');$t->unsignedTinyInteger('score')->default(0);
$t->string('priority')->default('Cold');$t->text('followup')->nullable();$t->timestamps();});}
public function down():void{Schema::dropIfExists('leads');}
};