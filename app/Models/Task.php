<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;



class Task extends Model
{
     protected $fillable = [
        'title',
        'description',
        'status',
        // এখানে আসল ডাটাবেজ কলামগুলা লিখবেন
    ];
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
        $table->string('title');
        $table->text('description')->nullable();
        $table->boolean('completed')->default(false);
        $table->timestamps();
        });
    }
}
