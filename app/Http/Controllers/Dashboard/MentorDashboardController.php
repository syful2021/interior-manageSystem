<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Notice;
use App\Models\Student;
use Illuminate\Http\Request;

class MentorDashboardController extends Controller
{
    public function mentorDashboard() {
        // $totalBatch = Batch::query()
        //             ->where('mentor_id', auth()->guard('mentor')->user()->id)
        //             ->count();

        // $runningBatch = Batch::query()
        //             ->where('mentor_id', auth()->guard('mentor')->user()->id)
        //             ->where('status', 'running')
        //             ->count();
        $runningBatch = 0;
        $totalStudent = 0;
        $totalRunningStudent = 0;
        // $totalStudent = Student::query()
        //             ->whereHas('batch', function ($q) {
        //                 $q->where('mentor_id', auth()->guard('mentor')->user()->id);
        //             })
        //             ->count();

        // $totalRunningStudent = Student::query()
        //             ->where('student_status', 'running')
        //             ->whereHas('batch', function ($q) {
        //                 $q->where('mentor_id', auth()->guard('mentor')->user()->id);
        //             })
        //             ->count();
        $mentorNotice = Notice::query()
                    ->where('is_seen', 1)
                    ->where('user_id', auth()->guard('mentor')->user()->id)
                    ->where('person', 'm')
                    ->count();
        return view('application/mentorIndex', compact('runningBatch', 'totalStudent', 'totalRunningStudent', 'mentorNotice'));
    }

    public function myStudentMentor() {

        return view('application.admission.myStudentMentor');
    }
}
