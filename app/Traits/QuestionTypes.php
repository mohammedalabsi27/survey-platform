<?php

namespace App\Traits;

trait QuestionTypes
{
    public function getTypeArabic($type)
    {
        $types = [
            'text' => 'نص قصير',
            'textarea' => 'نص طويل',
            'choice' => 'اختيار وحيد',
            'multiple_choice' => 'اختيار متعدد',
            'yes_no' => 'نعم/لا',
            'rating' => 'تقييم'
        ];
        
        return $types[$type] ?? $type;
    }
    
    public function getDefaultQuestionText($type)
    {
        $texts = [
            'text' => 'ما هو رأيك؟',
            'textarea' => 'ما هي ملاحظاتك؟',
            'choice' => 'اختر الخيار المناسب',
            'multiple_choice' => 'اختر ما ينطبق عليك',
            'yes_no' => 'اختر نعم أو لا',
            'rating' => 'قيم من 1 إلى 5'
        ];
        
        return $texts[$type] ?? 'سؤال جديد';
    }
    
    public function getTypeIcon($type)
    {
        $icons = [
            'text' => 'fas fa-font',
            'textarea' => 'fas fa-align-left',
            'choice' => 'fas fa-dot-circle',
            'multiple_choice' => 'fas fa-check-square',
            'yes_no' => 'fas fa-thumbs-up',
            'rating' => 'fas fa-star'
        ];
        
        return $icons[$type] ?? 'fas fa-question';
    }
    
    public function getTypeColor($type)
    {
        $colors = [
            'text' => 'blue',
            'textarea' => 'green',
            'choice' => 'yellow',
            'multiple_choice' => 'purple',
            'yes_no' => 'red',
            'rating' => 'orange'
        ];
        
        return $colors[$type] ?? 'gray';
    }
}