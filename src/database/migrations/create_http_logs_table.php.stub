<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        $tableName = config('http-db-logger.table', 'http_logs');
        Schema::create($tableName, function (Blueprint $table) {
            $table->id();
            $table->string('method');
            $table->string('url');
            $table->string('request_type',3)->default('web');
            $table->text('request_body')->nullable();
            $table->integer('response_status')->nullable();
            $table->text('response_body')->nullable();
            $table->string('ip_address')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->string('user_role')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        $tableName = config('http-db-logger.table', 'http_logs');
        Schema::dropIfExists($tableName);
    }
};
