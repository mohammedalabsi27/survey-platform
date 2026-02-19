<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // الإحصائيات الأساسية
        $totalSurveys = Survey::where('user_id', $user->id)->count();
        $activeSurveys = Survey::where('user_id', $user->id)
            ->where('status', 'published')
            ->count();
        $totalResponses = Response::whereIn('survey_id', function($query) use ($user) {
            $query->select('id')
                  ->from('surveys')
                  ->where('user_id', $user->id);
        })->count();
        
        // نسبة الإكمال (نسبة الاستبيانات المنشورة من الإجمالي)
        $avgCompletion = $totalSurveys > 0 ? round(($activeSurveys / $totalSurveys) * 100) : 0;
        
        // آخر الاستبيانات
        $recentSurveys = Survey::where('user_id', $user->id)
            ->withCount('responses')
            ->latest()
            ->take(5)
            ->get();
        
        // النشاط الأخير (مثال مبسط)
        $recentActivity = $this->getRecentActivity($user);
        
        // استبيانات تحتاج الانتباه (بدون مشاركات)
        $surveysNeedingAttention = Survey::where('user_id', $user->id)
            ->whereDoesntHave('responses')
            ->where('status', 'published')
            ->take(3)
            ->get();

        return view('dashboard', compact(
            'totalSurveys',
            'activeSurveys', 
            'totalResponses',
            'avgCompletion',
            'recentSurveys',
            'recentActivity',
            'surveysNeedingAttention'
        ));
    }
    
    private function getRecentActivity($user)
    {
        // هذا مثال - يمكنك تطويره حسب احتياجاتك
        $activities = [];
        
        // آخر استبيان تم إنشاؤه
        $latestSurvey = Survey::where('user_id', $user->id)->latest()->first();
        if ($latestSurvey) {
            $activities[] = [
                'icon' => 'plus',
                'message' => 'أنشأت استبيان جديد: ' . $latestSurvey->title,
                'time' => $latestSurvey->created_at->diffForHumans()
            ];
        }
        
        // آخر مشاركة
        $latestResponse = Response::whereIn('survey_id', function($query) use ($user) {
            $query->select('id')
                  ->from('surveys')
                  ->where('user_id', $user->id);
        })->latest()->first();
        
        if ($latestResponse) {
            $activities[] = [
                'icon' => 'users',
                'message' => 'مشاركة جديدة في أحد استبياناتك',
                'time' => $latestResponse->created_at->diffForHumans()
            ];
        }
        
        return $activities;
    }
}