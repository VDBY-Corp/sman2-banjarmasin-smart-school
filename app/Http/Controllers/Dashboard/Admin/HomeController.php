<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Models\AchievementData;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\ViolationData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $student_count = Student::count();
        $teacher_count = Teacher::count();
        $grade_count = Grade::count();
        $violation_count = ViolationData::count();

        // cache
        $top5_violation = Cache::remember('top5_violation', 4, function () {
            return ViolationData::with('student', 'student.grade', 'student.generation')
                ->select('student_id', DB::raw('COUNT(*) as violation_count'))
                ->groupBy('student_id')
                ->orderByDesc('violation_count')
                ->limit(5)
                ->get();
        });
        $top5_achievement = Cache::remember('top5_achievement', 4, function () {
            return AchievementData::with('student', 'student.grade', 'student.generation')
                ->select('student_id', DB::raw('COUNT(*) as achievement_count'))
                ->groupBy('student_id')
                ->orderByDesc('achievement_count')
                ->limit(5)
                ->get();
        });
        $chart_violation = Cache::remember('chart_violation', 4, function () {
            $start_date = now()->subYear()->startOfYear();
            $end_date = now()->subYear()->endOfYear();

            $violations = ViolationData::whereBetween('date', [$start_date, $end_date])
                ->selectRaw('MONTH(created_at) as quarter, COUNT(*) as violation_count')
                ->groupBy('quarter')
                ->get();

            $labels = [];
            for ($i = 1; $i <= 12; $i++) {
                $labels[] = \Carbon\Carbon::create()->month($i)->format('F');
            }

            $data = array_fill(0, 12, 0);
            foreach ($violations as $violation) {
                $data[$violation->quarter - 1] = $violation->violation_count;
            }

            return (object) [
                "violations" => $violations,
                "labels" => $labels,
                "data" => $data,
            ];
        });
        $chart_achievement = Cache::remember('chart_achievement', 4, function () {
            $q1 = now()->startOfYear();
            $q4 = now()->endOfYear();

            $achievements = AchievementData::whereBetween('date', [$q1, $q4])
                ->selectRaw('MONTH(created_at) as quarter, COUNT(*) as achievement_count')
                ->groupBy('quarter')
                ->get();

            $labels = [];
            for ($i = 1; $i <= 12; $i++) {
                $labels[] = \Carbon\Carbon::create()->month($i)->format('F');
            }
            $data = array_fill(0, 12, 0);
            foreach ($achievements as $violation) {
                $data[$violation->quarter - 1] = $violation->achievement_count;
            }

            return (object) [
                "achievements" => $achievements,
                "labels" => $labels,
                "data" => $data,
            ];
        });

        return view(
            'pages.dashboard.admin.home',
            compact(
                'student_count',
                'teacher_count',
                'grade_count',
                'violation_count',
                'top5_violation',
                'top5_achievement',
                'chart_violation',
                'chart_achievement',
            )
        );
    }
}
