<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\Response;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // 1. الإحصائيات الأساسية
        $totalSurveys = Survey::where('user_id', $user->id)->count();
        $activeSurveys = Survey::where('user_id', $user->id)->where('status', 'published')->count();
        
        $surveyIds = Survey::where('user_id', $user->id)->pluck('id');
        $totalResponses = Response::whereIn('survey_id', $surveyIds)->count();
        
        $avgCompletion = $totalSurveys > 0 ? round(($activeSurveys / $totalSurveys) * 100) : 0;
        
        // 2. آخر الاستبيانات
        $recentSurveys = Survey::where('user_id', $user->id)
            ->withCount('responses')
            ->latest()
            ->take(5)
            ->get();
        
        // 3. استبيانات تحتاج الانتباه (بدون مشاركات)
        $surveysNeedingAttention = Survey::where('user_id', $user->id)
            ->whereDoesntHave('responses')
            ->where('status', 'published')
            ->take(3)
            ->get();

        // 4. 💡 النشاط الأخير الحقيقي (دمج الاستبيانات والردود)
        $activities = collect();
        
        // جلب آخر استبيانات تم إنشاؤها
        $latestSurveys = Survey::where('user_id', $user->id)->latest()->take(5)->get();
        foreach ($latestSurveys as $s) {
            $activities->push([
                'icon' => 'plus-circle',
                'color' => 'blue',
                'message' => 'أنشأت استبيان جديد: ' . $s->title,
                'time' => $s->created_at,
                'diff' => $s->created_at->diffForHumans()
            ]);
        }
        
        // جلب آخر الردود
        $latestResponses = Response::whereIn('survey_id', $surveyIds)->with('survey')->latest()->take(10)->get();
        foreach ($latestResponses as $r) {
            $activities->push([
                'icon' => 'bolt',
                'color' => 'green',
                'message' => 'رد جديد على استبيان: ' . $r->survey->title,
                'time' => $r->created_at,
                'diff' => $r->created_at->diffForHumans()
            ]);
        }
        
        // ترتيب النشاطات من الأحدث للأقدم وأخذ أول 7 فقط
        $recentActivity = $activities->sortByDesc('time')->take(7)->values();

        // 5. 💡 بيانات الرسم البياني (أداء آخر 7 أيام)
        $chartDates = [];
        $chartData =[];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $chartDates[] = $date->translatedFormat('l'); // اسم اليوم (السبت، الأحد...)
            $chartData[] = Response::whereIn('survey_id', $surveyIds)->whereDate('created_at', $date->format('Y-m-d'))->count();
        }

        return view('dashboard', compact(
            'totalSurveys',
            'activeSurveys', 
            'totalResponses',
            'avgCompletion',
            'recentSurveys',
            'recentActivity',
            'surveysNeedingAttention',
            'chartDates',
            'chartData'
        ));
    }
    
    // private function getRecentActivity($user)
    // {
    //     // هذا مثال - يمكنك تطويره حسب احتياجاتك
    //     $activities = [];
        
    //     // آخر استبيان تم إنشاؤه
    //     $latestSurvey = Survey::where('user_id', $user->id)->latest()->first();
    //     if ($latestSurvey) {
    //         $activities[] = [
    //             'icon' => 'plus',
    //             'message' => 'أنشأت استبيان جديد: ' . $latestSurvey->title,
    //             'time' => $latestSurvey->created_at->diffForHumans()
    //         ];
    //     }
        
    //     // آخر مشاركة
    //     $latestResponse = Response::whereIn('survey_id', function($query) use ($user) {
    //         $query->select('id')
    //               ->from('surveys')
    //               ->where('user_id', $user->id);
    //     })->latest()->first();
        
    //     if ($latestResponse) {
    //         $activities[] = [
    //             'icon' => 'users',
    //             'message' => 'مشاركة جديدة في أحد استبياناتك',
    //             'time' => $latestResponse->created_at->diffForHumans()
    //         ];
    //     }
        
    //     return $activities;
    // }
}