<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->text('requirements');
            $table->string('location');
            $table->string('internship_type'); // IT, Marketing, Finance, etc.
            $table->string('duration'); // 3 months, 6 months, etc.
            $table->date('application_deadline');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('positions_available')->default(1);
            $table->decimal('compensation', 8, 2)->nullable(); // Monthly stipend
            $table->string('compensation_type')->nullable(); // Paid, Unpaid, Stipend
            $table->text('benefits')->nullable(); // Additional benefits
            $table->text('skills_required')->nullable();
            $table->enum('status', ['draft', 'pending', 'active', 'closed'])->default('draft');
            $table->boolean('is_remote')->default(false);
            $table->boolean('requires_cv')->default(true);
            $table->boolean('requires_motivation_letter')->default(true);
            $table->timestamps();

            // Indexes for performance
            $table->index('company_id');
            $table->index('status');
            $table->index('internship_type');
            $table->index('location');
            $table->index('application_deadline');
            $table->index('is_remote');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};