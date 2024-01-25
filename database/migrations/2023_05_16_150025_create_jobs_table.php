<?php

use App\Enums\JobType;
use App\Enums\JobLocation;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->string('job_title');
            $table->enum('job_type', [
                JobType::FullTime->value,
                JobType::PartTime->value,
                JobType::Contract->value,
            ]);
            $table->enum('job_location', [
                JobLocation::OnSite->value,
                JobLocation::Remote->value,
                JobLocation::Hybrid->value,
            ]);
            $table->integer('salary');
            $table->LongText('description');
            $table->Date('application_deadline');
            $table->timestamps();

            $table->foreign('company_id')
            ->references('id')
            ->on('companies')
            ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
