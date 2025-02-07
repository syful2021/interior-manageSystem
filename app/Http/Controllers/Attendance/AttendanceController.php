<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use App\Models\Batch;
use Carbon\Carbon;

use App\Exports\SingleAttendanceExport;
use App\Exports\AttendanceExport;
use App\Models\Department;
use Maatwebsite\Excel\Facades\Excel;

class AttendanceController extends Controller
{
    public function attendance() {
        $batch = Batch::query()
                ->select('id', 'name')
                ->whereHas('mentors', function ($query) {
                    $query->where('mentor_id', Auth::guard('mentor')->user()->id);
                })
                ->withCount('students')
                ->with('students')
                ->latest()
                ->paginate(20);

        return view('application.attendance.attendance', compact('batch'));
    }

    public function attendanceBatch($id) {
        $attendance = Attendance::query()
                    ->where('batch_id', $id)
                    ->select('date')
                    ->groupBy('date')
                    ->paginate(36);
        $batchName = Batch::where('id', $id)->first('name');

        return view('application.attendance.attendanceBatch', compact('attendance', 'id', 'batchName'));
    }

    public function attendanceTake($id) {
        $students = Student::where('batch_id', $id)->select('id','name')
        ->latest()
        ->get();
        $batchName = Batch::where('id', $id)->first();
        $department = Department::where('id', $batchName->department_id)->first();

        return view('application.attendance.takeAttendance', compact('students', 'id', 'batchName', 'department'));
    }

    public function attendanceBatchPost(Request $request, $id) {
        $validated = $request->validate([
            'date' => 'required',
            'course' => 'required'
        ]);

        $students = Student::whereIn('id', $request->student_id)->get();

        foreach ($students as $student) {
            $attendance = $request->input("attendance{$student->id}");

            Attendance::updateOrCreate(
                [
                    'student_id' => $student->id,
                    'date' => $request->date,
                ],
                [
                    'attendance' => $attendance,
                    'batch_id' => $id,
                    'course_id' => $request->course,
                ]
            );
        }

        return redirect()->route('attendanceBatch', $id)->with('success', 'Attendance Add Successful.');
    }

    public function attendanceEdit($date, $id) {
        $attendance = Attendance::query()
        ->with('students:id,name')
        ->where('date', $date)
        ->where('batch_id', $id)
        ->get();
        $batchName = Batch::where('id', $id)->first();
        $department = Department::where('id', $batchName->department_id)->first();
        return view('application.attendance.updateAttendance', compact('attendance', 'date', 'id', 'batchName', 'department'));
    }

    public function attendanceUpdate(Request $request, $date, $id) {
        $validated = $request->validate([
            'date' => 'required',
            'course' => 'required'
        ]);

        $students = Student::whereIn('id', $request->student_id)->get();
        foreach ($students as $index => $student) {
            $attendance = $request->input("attendance{$student->id}");
            Attendance::where('date', $date)->where('batch_id', $id)->where('student_id', $student->id)->update([
                'student_id' => $student->id,
                'date' => $request->date,
                'attendance' => $attendance,
                'batch_id' => $id,
                'course_id' => $request->course,
            ]);
        }

        return redirect()->route('attendanceBatch', $id)->with('success', 'Attendance Update Successful.');
    }

    public function attendanceView($date, $id) {
        $attendance = Attendance::query()
        ->with('students:id,name,student_id')
        ->where('date', $date)
        ->where('batch_id', $id)
        ->get();
        $batchName = Batch::where('id', $id)->first('name');

        return view('application.attendance.attendanceView', compact('attendance', 'batchName'));
    }

    public function adminAttendance() {
        $batch = Batch::query()
                ->select('id', 'name')
                ->withCount('students')
                ->with('students')
                ->latest()
                ->paginate(20);

        return view('application.attendance.adminAttendance', compact('batch'));
    }

    public function adminAttendanceBatch($id) {
        $attendance = Attendance::query()
                    ->where('batch_id', $id)
                    ->select('date')
                    ->groupBy('date')
                    ->paginate(36);
        $batchName = Batch::where('id', $id)->first('name');

        return view('application.attendance.adminAttendanceBatch', compact('attendance', 'id', 'batchName'));
    }

    public function adminAttendanceView($date, $id) {
        $attendance = Attendance::query()
                    ->with('students:id,name,student_id')
                    ->where('date', $date)
                    ->where('batch_id', $id)
                    ->get();
        $batchName = Batch::where('id', $id)->first('name');

        return view('application.attendance.adminAttendanceView', compact('attendance', 'batchName'));
    }

    public function attendancereport() {
        return view('application.attendance.attendanceReport');
    }

    public function myAttendance() {
        $attendance = Attendance::query()
                    ->where('student_id',auth()->guard('student')->user()->id)
                    ->get();
        return view('application.attendance.studentAttendanceView', compact('attendance'));
    }

    public function attendanceDownload($date, $batchId) {
        return Excel::download(new AttendanceExport($date, $batchId), 'attendance.xlsx');
    }

    public function attendancSingleeDownload($batchId, $studentId) {
        return Excel::download(new SingleAttendanceExport($batchId, $studentId), 'attendance.xlsx');
    }

}
