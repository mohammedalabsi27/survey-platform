<?php

use App\Models\Survey;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('surveys', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('title');
        });

        $surveys = Survey::all();
        foreach($surveys as $survey) {
            $survey->slug = Str::slug($survey->title) . '-' . Str::random(6);
            $survey->save();
        }

        // 3. جعل العمود "فريد" (Unique) لا يتكرر
        Schema::table('surveys', function (Blueprint $table) {
            $table->unique('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surveys', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
