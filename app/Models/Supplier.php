<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Supplier extends Model
{
        protected $fillable = [
            'name',
            'email',
            'mobile_no',
            'address',
            'status',
            // এখানে আসল ডাটাবেজ কলামগুলা লিখবেন
        ];
    public function up()
{
    Schema::create('suppliers', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('mobile_no')->nullable();
        $table->string('email')->unique()->nullable();
        $table->string('address')->nullable();
        $table->boolean('status')->default(true); // Active/Inactive
        $table->timestamps();
    });
}
}
