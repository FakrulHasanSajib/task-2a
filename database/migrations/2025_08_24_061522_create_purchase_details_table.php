    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up()
        {
            Schema::create('purchase_details', function (Blueprint $table) {
                $table->id();
                $table->foreignId('purchase_id')->constrained()->onDelete('cascade');
                $table->foreignId('product_id')->nullable()->constrained()->onDelete('set null');
                // ফরেন কি লাইনগুলো সাময়িকভাবে কমেন্ট করা হয়েছে
                 $table->foreignId('brand_id')->nullable()->constrained()->onDelete('set null');
                 $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
                 $table->foreignId('unit_id')->nullable()->constrained()->onDelete('set null');
                
                $table->unsignedBigInteger('brand_id')->nullable();
                $table->unsignedBigInteger('category_id')->nullable();
                $table->unsignedBigInteger('unit_id')->nullable();
                
                $table->decimal('pur_unit_price', 10, 2);
                $table->integer('quantity');
                $table->decimal('total_price', 10, 2);
                $table->timestamps();
            });
        }
        
        public function down()
        {
            Schema::dropIfExists('purchase_details');
        }
    };